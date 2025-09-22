<?php

namespace App\Services;

use PDO;
use RuntimeException;

class PrinterRouting
{
    private static array $printJobColumns = [];
    private static array $productCache = [];
    private static array $stationCache = [];

    public static function resolveStationId(PDO $pdo, int $branchId, int $productId, int $categoryId = 0): ?int
    {
        if ($branchId <= 0) {
            return null;
        }

        if ($productId > 0) {
            $stmt = $pdo->prepare('
                SELECT station_id
                FROM product_station_overrides
                WHERE branch_id = :branch AND product_id = :product
                ORDER BY id DESC
                LIMIT 1
            ');
            $stmt->execute([':branch' => $branchId, ':product' => $productId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row && !empty($row['station_id'])) {
                return (int) $row['station_id'];
            }
        }

        if ($categoryId > 0) {
            $stmt = $pdo->prepare('
                SELECT station_id
                FROM category_station_rules
                WHERE branch_id = :branch AND category_id = :category
                ORDER BY id DESC
                LIMIT 1
            ');
            $stmt->execute([':branch' => $branchId, ':category' => $categoryId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row && !empty($row['station_id'])) {
                return (int) $row['station_id'];
            }
        }

        $stmt = $pdo->prepare('
            SELECT id
            FROM prep_stations
            WHERE branch_id = :branch AND is_default = 1
            ORDER BY id ASC
            LIMIT 1
        ');
        $stmt->execute([':branch' => $branchId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && !empty($row['id'])) {
            return (int) $row['id'];
        }

        $stmt = $pdo->prepare('
            SELECT id
            FROM prep_stations
            WHERE branch_id = :branch
            ORDER BY id ASC
            LIMIT 1
        ');
        $stmt->execute([':branch' => $branchId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && !empty($row['id']) ? (int) $row['id'] : null;
    }

    public static function pickPrinterForStation(PDO $pdo, int $stationId): ?array
    {
        $stmt = $pdo->prepare('SELECT * FROM printers WHERE station_id = :station ORDER BY id ASC');
        $stmt->execute([':station' => $stationId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$rows) {
            return null;
        }

        foreach ($rows as $row) {
            if (!isset($row['is_active']) || (int) $row['is_active'] === 1) {
                return $row;
            }
        }

        return $rows[0];
    }

    public static function queueStationTicket(PDO $pdo, int $branchId, int $orderId, int $stationId, array $items, string $tableNo): int
    {
        if ($stationId <= 0) {
            throw new RuntimeException('Station is required to queue print job.');
        }
        if ($items === []) {
            throw new RuntimeException('Cannot queue empty ticket payload.');
        }

        $stationInfo = self::getStationInfo($pdo, $stationId);
        $printer     = self::pickPrinterForStation($pdo, $stationId) ?? [];

        $meta = [
            'branch_id'    => $branchId,
            'order_id'     => $orderId > 0 ? $orderId : null,
            'station_id'   => $stationId,
            'station_name' => $stationInfo['name'] ?? null,
        ];
        $payload     = self::buildPayload($tableNo, $items, $meta);
        $jsonPayload = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $defaults = self::defaultPrinterConfig();

        $columns = self::getPrintJobColumns($pdo);
        $now     = date('Y-m-d H:i:s');

        $connector = $printer['connector'] ?? $defaults['connector'];
        $host      = $printer['host']      ?? $defaults['host'];
        $portVal   = isset($printer['port']) ? $printer['port'] : $defaults['port'];
        $port      = (string) (is_numeric($portVal) ? (int) $portVal : $portVal);

        $data = [
            'branch_id'    => $branchId,
            'order_id'     => $orderId > 0 ? $orderId : null,
            'station_id'   => $stationId,
            'printer_id'   => $printer['id'] ?? null,
            'connector'    => $connector,
            'host'         => $host,
            'port'         => $port,
            'payload_json' => $jsonPayload,
            'status'       => 'queued',
        ];

        if (isset($columns['created_at'])) {
            $data['created_at'] = $now;
        }
        if (isset($columns['updated_at'])) {
            $data['updated_at'] = $now;
        }
        if (isset($columns['error'])) {
            $data['error'] = null;
        }
        if (isset($columns['retry_count']) && !isset($data['retry_count'])) {
            $data['retry_count'] = 0;
        }

        $insertColumns = [];
        $placeholders  = [];
        $params        = [];
        foreach ($data as $column => $value) {
            if (isset($columns[$column])) {
                $insertColumns[]        = $column;
                $placeholders[]         = ':' . $column;
                $params[':' . $column ] = $value;
            }
        }

        if (!in_array('payload_json', $insertColumns, true)) {
            throw new RuntimeException('print_jobs table must contain payload_json column.');
        }

        $sql  = 'INSERT INTO print_jobs (' . implode(', ', $insertColumns) . ') VALUES (' . implode(', ', $placeholders) . ')';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return (int) $pdo->lastInsertId();
    }

    public static function dispatchOrderToPrinters(PDO $pdo, int $branchId, int $orderId, string $tableNo, array $orderItems): array
    {
        if ($orderItems === []) {
            return [];
        }

        $grouped = [];
        foreach ($orderItems as $item) {
            $productId = (int) ($item['product_id'] ?? 0);
            $quantity  = $item['quantity'] ?? ($item['qty'] ?? 1);
            $qty       = (float) $quantity;
            $note      = trim((string) ($item['note'] ?? ''));

            if ($productId <= 0) {
                continue;
            }

            $product    = self::getProduct($pdo, $productId);
            $categoryId = (int) ($item['category_id'] ?? ($product['category_id'] ?? 0));
            $stationId  = self::resolveStationId($pdo, $branchId, $productId, $categoryId ?: 0);

            if ($stationId === null) {
                error_log(sprintf('PrinterRouting: No station resolved for product #%d', $productId));
                continue;
            }

            $name = (string) ($item['product_name'] ?? $product['product_name'] ?? $product['name'] ?? ('Product #' . $productId));

            if ($qty <= 0) {
                continue;
            }

            $grouped[$stationId][] = [
                'name' => $name,
                'qty'  => $qty,
                'note' => $note,
            ];
        }

        $jobIds = [];
        foreach ($grouped as $stationId => $items) {
            try {
                $jobIds[] = self::queueStationTicket($pdo, $branchId, $orderId, (int) $stationId, $items, $tableNo);
            } catch (RuntimeException $e) {
                error_log('PrinterRouting: Failed to queue ticket - ' . $e->getMessage());
            }
        }

        return $jobIds;
    }

    private static function getProduct(PDO $pdo, int $productId): array
    {
        if (isset(self::$productCache[$productId])) {
            return self::$productCache[$productId];
        }

        $stmt = $pdo->prepare('
            SELECT p.id, p.name AS product_name, p.category_id, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE p.id = :id
            LIMIT 1
        ');
        $stmt->execute([':id' => $productId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        self::$productCache[$productId] = $row;
        return $row;
    }

    private static function getStationInfo(PDO $pdo, int $stationId): array
    {
        if (isset(self::$stationCache[$stationId])) {
            return self::$stationCache[$stationId];
        }

        $stmt = $pdo->prepare('SELECT id, name FROM prep_stations WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $stationId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        self::$stationCache[$stationId] = $row;
        return $row;
    }

    private static function buildPayload(string $tableNo, array $items, array $meta = []): array
    {
        $normalized = [];
        foreach ($items as $item) {
            $normalized[] = [
                'name' => (string) ($item['name'] ?? ''),
                'qty'  => (float) ($item['qty'] ?? 1),
                'note' => trim((string) ($item['note'] ?? '')),
            ];
        }

        $meta       = array_filter($meta, static fn($v) => $v !== null && $v !== '');
        $payloadMeta = array_merge(['table' => $tableNo], $meta);

        return [
            'title'  => 'CAFFEINE',
            'table'  => $tableNo,
            'items'  => $normalized,
            'footer' => 'Afiyet olsun',
            'meta'   => $payloadMeta,
        ];
    }

    private static function getPrintJobColumns(PDO $pdo): array
    {
        if (self::$printJobColumns !== []) {
            return self::$printJobColumns;
        }

        try {
            $stmt = $pdo->query('SHOW COLUMNS FROM print_jobs');
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                if (!empty($row['Field'])) {
                    self::$printJobColumns[$row['Field']] = true;
                }
            }
        } catch (\Throwable $e) {
            self::$printJobColumns = [
                'id'            => true,
                'branch_id'     => true,
                'order_id'      => true,
                'station_id'    => true,
                'printer_id'    => true,
                'connector'     => true,
                'host'          => true,
                'port'          => true,
                'payload_json'  => true,
                'status'        => true,
                'error'         => true,
                'created_at'    => true,
                'updated_at'    => true,
                'printed_at'    => true,
                'retry_count'   => true,
            ];
        }

        return self::$printJobColumns;
    }

    private static function defaultPrinterConfig(): array
    {
        return [
            'connector' => strtolower((string) self::env('PRINTER_MODE', 'network')),
            'host'      => (string) self::env('PRINTER_HOST', '127.0.0.1'),
            'port'      => (int) self::env('PRINTER_PORT', 9100),
        ];
    }

    private static function env(string $key, $default = null)
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        return $value !== false && $value !== null ? $value : $default;
    }
}
