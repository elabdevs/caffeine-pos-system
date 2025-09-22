<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Core\DB;
use App\Services\PrintManager;

$printManager = new PrintManager();
$db = new DB('print_jobs');
$pdo = $db->getConnection();

$columns = describePrintJobs($pdo);
$idleSleep = (int) (getenv('PRINT_WORKER_IDLE_SLEEP') ?: 1);
if ($idleSleep < 1) {
    $idleSleep = 1;
}

echo "[print_worker] Starting worker..." . PHP_EOL;

while (true) {
    $job = lockNextJob($pdo, $columns);
    if ($job === null) {
        sleep($idleSleep);
        continue;
    }

    $jobId = (int) $job['id'];
    echo "[print_worker] Processing job #{$jobId}" . PHP_EOL;

    $payload = [
        'connector'    => $job['connector'] ?? null,
        'host'         => $job['host'] ?? null,
        'port'         => $job['port'] ?? null,
        'timeout'      => $job['timeout'] ?? null,
        'printer_name' => $job['printer_name'] ?? null,
        'payload_json' => $job['payload_json'] ?? null,
    ];

    try {
        $printManager->printTicket($payload);
        markJobComplete($pdo, $columns, $jobId);
        echo "[print_worker] Job #{$jobId} printed" . PHP_EOL;
    } catch (\Throwable $e) {
        markJobFailed($pdo, $columns, $jobId, $e);
        echo "[print_worker] Job #{$jobId} failed: " . $e->getMessage() . PHP_EOL;
    }
}

function lockNextJob(\PDO $pdo, array $columns): ?array
{
    $candidates = [
        "SELECT * FROM print_jobs WHERE status = 'queued' ORDER BY id ASC LIMIT 1 FOR UPDATE SKIP LOCKED",
        "SELECT * FROM print_jobs WHERE status = 'queued' ORDER BY id ASC LIMIT 1 FOR UPDATE",
    ];

    foreach ($candidates as $sql) {
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->query($sql);
            $job = $stmt ? $stmt->fetch(\PDO::FETCH_ASSOC) : null;
            if (!$job) {
                $pdo->commit();
                continue;
            }

            updateStatus($pdo, $columns, (int) $job['id'], 'processing');
            $pdo->commit();
            return $job;
        } catch (\PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            continue;
        }
    }

    return null;
}

function updateStatus(\PDO $pdo, array $columns, int $jobId, string $status, array $extra = []): void
{
    $sets = ['status = :status'];
    $params = [':status' => $status, ':id' => $jobId];
    $now = date('Y-m-d H:i:s');

    if (isset($columns['updated_at'])) {
        $sets[] = 'updated_at = :updated_at';
        $params[':updated_at'] = $now;
    }

    foreach ($extra as $field => $value) {
        if (!isset($columns[$field])) {
            continue;
        }
        $sets[] = "{$field} = :{$field}";
        $params[":{$field}"] = $value;
    }

    $sql = 'UPDATE print_jobs SET ' . implode(', ', $sets) . ' WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
}

function markJobComplete(\PDO $pdo, array $columns, int $jobId): void
{
    $extra = [];
    $now = date('Y-m-d H:i:s');

    if (isset($columns['printed_at'])) {
        $extra['printed_at'] = $now;
    }
    if (isset($columns['error'])) {
        $extra['error'] = null;
    }
    if (isset($columns['retry_count'])) {
        $extra['retry_count'] = 0;
    }

    updateStatus($pdo, $columns, $jobId, 'printed', $extra);
}

function markJobFailed(\PDO $pdo, array $columns, int $jobId, \Throwable $e): void
{
    $extra = [];

    if (isset($columns['error'])) {
        $extra['error'] = substr($e->getMessage(), 0, 500);
    }
    if (isset($columns['retry_count'])) {
        $stmt = $pdo->prepare('UPDATE print_jobs SET retry_count = COALESCE(retry_count, 0) + 1 WHERE id = :id');
        $stmt->execute([':id' => $jobId]);
    }

    updateStatus($pdo, $columns, $jobId, 'failed', $extra);
}

function describePrintJobs(\PDO $pdo): array
{
    $columns = [];
    try {
        $stmt = $pdo->query('SHOW COLUMNS FROM print_jobs');
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            if (!empty($row['Field'])) {
                $columns[$row['Field']] = true;
            }
        }
    } catch (\Throwable $e) {
        $columns = [
            'id' => true,
            'status' => true,
            'payload_json' => true,
            'connector' => true,
            'host' => true,
            'port' => true,
            'error' => true,
            'retry_count' => true,
            'updated_at' => true,
            'printed_at' => true,
        ];
    }

    return $columns;
}
