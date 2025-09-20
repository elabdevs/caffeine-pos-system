<?php

namespace App\Controllers;

use App\Models\Order;
use App\Utils\JsonKit;
use App\Models\Tables;

class OrdersController {
    protected $order;
    protected $table;

    public function __construct() {
        $this->order = new Order();
        $this->table = new Tables();
    }

public static function createOrder(){
    $input    = json_decode(file_get_contents('php://input'), true) ?: [];
    $branchId = (int)($input['branch_id'] ?? 0);
    $userId   = (int)($input['user_id']   ?? 0);
    $tableNo  = trim((string)($input['table_no'] ?? ''));
    $items    = is_array($input['items'] ?? null) ? $input['items'] : [];

    if (!$branchId || $tableNo === '') {
        echo JsonKit::fail('branch_id ve table_no zorunludur', 400);
        return;
    }
    if (!$items) {
        echo JsonKit::fail('items boş olamaz', 400);
        return;
    }

    $now = date('Y-m-d H:i:s');

    $ordersDb = \App\Core\DB::table('orders');

    try {
        $ordersDb->query("SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");
        $ordersDb->query("SET SESSION innodb_lock_wait_timeout = 3");

        $ordersDb->query('START TRANSACTION');

        $row = $ordersDb->query(
            'SELECT id FROM orders
             WHERE branch_id = ? AND table_no = ? AND status = ? AND paid_at IS NULL
             ORDER BY id DESC
             LIMIT 1
             FOR UPDATE',
            [$branchId, $tableNo, 'pending'],
            'array'
        );
        $orderId = isset($row[0]['id']) ? (int)$row[0]['id'] : 0;

        if ($orderId === 0) {
            $orderId = \App\Core\DB::table('orders')->insert([
                'branch_id'    => $branchId,
                'user_id'      => $userId ?: null,
                'table_no'     => $tableNo,
                'total_amount' => 0,
                'status'       => 'pending',
                'created_at'   => $now
            ]);
            if (!$orderId) {
                throw new \RuntimeException('Sipariş oluşturulamadı');
            }
        }

        $added = 0;
        foreach ($items as $it) {
            $pid  = (int)($it['product_id'] ?? 0);
            $qty  = (float)($it['quantity']   ?? 1);
            $unit = (float)($it['unit_price'] ?? 0);
            if ($pid <= 0 || $qty <= 0) { continue; }

            $line = round($qty * $unit, 2);
            $note = isset($it['note']) ? (string)$it['note'] : '';

            \App\Core\DB::table('order_items')->insert([
                'order_id'   => $orderId,
                'product_id' => $pid,
                'quantity'   => $qty,
                'unit_price' => $unit,
                'line_total' => $line,
                'note'       => $note
            ]);
            $added++;
        }
        if ($added === 0) {
            throw new \RuntimeException('Geçerli item eklenemedi');
        }

        $sumArr = \App\Core\DB::table('order_items')->query(
            'SELECT COALESCE(SUM(line_total),0) AS total FROM order_items WHERE order_id = ?',
            [$orderId],
            'array'
        );
        $newTotal = (float)($sumArr[0]['total'] ?? 0);

        \App\Core\DB::table('orders')->where('id', $orderId)->update([
            'total_amount' => $newTotal
        ]);

        try {
            \App\Core\DB::table('tables')
                ->where('branch_id', $branchId)
                ->where('code',  $tableNo)
                ->update(['status' => 'occupied', 'updated_at' => $now]);
        } catch (\Throwable $e) {
            // continue
        }

        $ordersDb->query('COMMIT');
        echo JsonKit::json(
            ['order_id' => $orderId, 'total_amount' => $newTotal],
            'Sipariş güncellendi',
            200
        );

    } catch (\Throwable $e) {
        // hata: rollback ve mesaj
        try { $ordersDb->query('ROLLBACK'); } catch (\Throwable $ignore) {}
        echo JsonKit::fail('İşlem başarısız: '.$e->getMessage(), 500);
    }
}

    public static function getMonthlyOrders(?int $year = null,?int $month = null,?int $branchId = null,bool $onlyPaid = true) {
    try {
        // Ay aralığı [start, end)
        $now   = new \DateTimeImmutable('now');
        $year  = $year  ?? (int)$now->format('Y');
        $month = $month ?? (int)$now->format('m');

        $start = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', sprintf('%04d-%02d-01 00:00:00', $year, $month));
        $end   = $start->modify('first day of next month');

        // onlyPaid=true ise paid_at'e göre say, yoksa created_at'e göre
        $dateCol = $onlyPaid ? 'paid_at' : 'created_at';

        $where = [];
        $bind  = [];

        if ($onlyPaid) {
            $where[] = "$dateCol IS NOT NULL";
        }
        $where[] = "$dateCol >= ?";
        $where[] = "$dateCol < ?";
        $bind[]  = $start->format('Y-m-d H:i:s');
        $bind[]  = $end->format('Y-m-d H:i:s');

        if ($branchId !== null) {
            $where[] = "branch_id = ?";
            $bind[]  = $branchId;
        }

        $sql = "SELECT COUNT(*) AS cnt FROM orders WHERE " . implode(' AND ', $where);
        $row = (new \App\Core\DB('orders'))->query($sql, $bind, 'array');
        $count = (int)($row[0]['cnt'] ?? 0);

        return $count;

    } catch (\Throwable $e) {
        echo JsonKit::fail('Hata: '.$e->getMessage(), 500);
    }
}

    public static function waiterOrders(): void
{
    try {
        // ---- Parametreler
        $days     = max(1, (int)($_GET['days'] ?? 30));  // son N gün
        $branchId = isset($_GET['branchId']) ? (int)$_GET['branchId'] : null;
        $onlyPaid = (int)($_GET['onlyPaid'] ?? 1) === 1;

        $end   = (new \DateTimeImmutable('tomorrow'))->setTime(0,0,0);
        $start = $end->modify("-{$days} days");

        $dateCol = $onlyPaid ? 'o.paid_at' : 'o.created_at';
        $where   = [];
        $bind    = [];

        if ($onlyPaid) { $where[] = "{$dateCol} IS NOT NULL"; }
        $where[] = "{$dateCol} >= ?"; $bind[] = $start->format('Y-m-d H:i:s');
        $where[] = "{$dateCol} <  ?"; $bind[] = $end->format('Y-m-d H:i:s');
        if ($branchId !== null) { $where[] = "o.branch_id = ?"; $bind[] = $branchId; }

        $sql = "
          SELECT 
            COALESCE(NULLIF(TRIM(u.name),''), CONCAT('Kullanıcı #', o.user_id), 'Bilinmiyor') AS waiter_name,
            o.user_id,
            COUNT(*) AS orders_count
          FROM orders o
          LEFT JOIN users u ON u.id = o.user_id
          WHERE " . implode(' AND ', $where) . "
          GROUP BY o.user_id, u.name
          ORDER BY orders_count DESC
          LIMIT 20
        ";

        $rows = (new \App\Core\DB('orders'))->query($sql, $bind, 'array');

        $labels = array_map(fn($r) => $r['waiter_name'], $rows);
        $data   = array_map(fn($r) => (int)$r['orders_count'], $rows);

        echo JsonKit::json([
            'range'  => [$start->format('Y-m-d'), $end->modify('-1 day')->format('Y-m-d')],
            'labels' => $labels,
            'data'   => $data,
            'total'  => array_sum($data),
            'days'   => $days,
            'onlyPaid' => $onlyPaid ? 1 : 0,
            'branchId' => $branchId,
        ], 'Garsonlara göre sipariş', 200);

    } catch (\Throwable $e) {
        echo JsonKit::fail('Hata: '.$e->getMessage(), 500);
    }
}

// OrdersController.php içine ekle
public static function staffPerformance(): void
{
    try {
        // --- params
        $days     = max(1, (int)($_GET['days'] ?? 30));         // default 30 gün
        $branchId = isset($_GET['branchId']) ? (int)$_GET['branchId'] : null;

        // --- tarih aralığı [start, end)
        $end   = (new \DateTimeImmutable('tomorrow'))->setTime(0,0,0);
        $start = $end->modify("-{$days} days");

        // --- filtreler
        $where = "o.paid_at IS NOT NULL AND o.paid_at >= ? AND o.paid_at < ?";
        $bind  = [$start->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s')];
        if ($branchId !== null) { $where .= " AND o.branch_id = ?"; $bind[] = $branchId; }

        /**
         * Not: orders.total_amount kullanıyoruz.
         * Eğer bazı kayıtlarda 0/NULL kalırsa, order_items'tan toplayan varyant ekleyebiliriz.
         */

        $sql = "
            SELECT 
                u.id   AS user_id,
                u.name AS user_name,
                r.name AS role_name,
                COALESCE(s.orders, 0) AS orders,
                COALESCE(s.sales,  0) AS sales,
                CASE WHEN COALESCE(s.orders,0) = 0 THEN 0
                     ELSE ROUND(COALESCE(s.sales,0) / s.orders, 2) END AS avg_sale
            FROM users u
            LEFT JOIN user_roles ur ON ur.user_id = u.id
            LEFT JOIN roles r       ON r.id = ur.role_id
            LEFT JOIN (
                SELECT 
                    o.user_id,
                    COUNT(*)                                          AS orders,
                    ROUND(COALESCE(SUM(o.total_amount),0), 2)         AS sales
                FROM orders o
                WHERE $where
                GROUP BY o.user_id
            ) s ON s.user_id = u.id
            ORDER BY s.sales DESC, s.orders DESC, user_name ASC
        ";

        $rows = (new \App\Core\DB('users'))->query($sql, $bind, 'array');

        $items = [];
        foreach ($rows as $r) {
            $items[] = [
                'user_id'  => (int)$r['user_id'],
                'name'     => (string)$r['user_name'],
                'role'     => $r['role_name'] ?? null,   // waiter/cashier/admin...
                'sales'    => (float)$r['sales'],
                'orders'   => (int)$r['orders'],
                'avg_sale' => (float)$r['avg_sale'],
            ];
        }

        echo \App\Utils\JsonKit::json([
                'range'    => [$start->format('Y-m-d'), $end->modify('-1 day')->format('Y-m-d')],
                'days'     => $days,
                'branchId' => $branchId,
                'currency' => 'TRY',
                'items'    => $items
        ], null, 200);

    } catch (\Throwable $e) {
        echo \App\Utils\JsonKit::fail('Hata: '.$e->getMessage(), 500);
    }
}




}