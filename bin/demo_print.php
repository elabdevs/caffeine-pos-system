<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Core\DB;
use App\Services\PrinterRouting;

$db = new DB('print_jobs');
$pdo = $db->getConnection();

$branchId = isset($argv[1]) ? (int)$argv[1] : 0;
$stationId = isset($argv[2]) ? (int)$argv[2] : 0;

if ($stationId <= 0) {
    $stmt = $pdo->query('SELECT id, branch_id FROM prep_stations ORDER BY is_default DESC, id ASC LIMIT 1');
    $row = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
    if (!$row) {
        fwrite(STDERR, "No prep stations found. Please create a station first.\n");
        exit(1);
    }
    $stationId = (int)($row['id'] ?? 0);
    if ($branchId <= 0) {
        $branchId = (int)($row['branch_id'] ?? 0);
    }
}

if ($branchId <= 0) {
    $stmt = $pdo->prepare('SELECT branch_id FROM prep_stations WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $stationId]);
    $branchId = (int)($stmt->fetchColumn() ?: 0);
}

if ($branchId <= 0) {
    fwrite(STDERR, "Unable to resolve branch for station #{$stationId}.\n");
    exit(1);
}

$items = [
    ['name' => 'Demo Latte', 'qty' => 1, 'note' => 'Oat milk'],
    ['name' => 'Cheesecake', 'qty' => 1, 'note' => 'No strawberry'],
];

$jobId = PrinterRouting::queueStationTicket($pdo, $branchId, 0, $stationId, $items, 'DEMO');

echo "Queued demo job #{$jobId} for station #{$stationId}" . PHP_EOL;
