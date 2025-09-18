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
             WHERE branch_id = ? AND table_no = ? AND status = ?
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

}