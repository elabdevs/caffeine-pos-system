<?php

namespace App\Controllers;

use App\Core\DB;
use App\Models\Order;
use App\Models\Tables;
use App\Services\PrinterRouting;
use App\Utils\JsonKit;
use DateInterval;
use DateTimeImmutable;
use RuntimeException;
use Throwable;

class OrdersController
{
    protected Order $order;
    protected Tables $table;

    public function __construct()
    {
        $this->order = new Order();
        $this->table = new Tables();
    }

    public static function createOrder(): void
    {
        $input = json_decode(file_get_contents("php://input"), true) ?: [];
        $branchId = (int) ($input["branch_id"] ?? 0);
        $userId = (int) ($input["user_id"] ?? 0);
        $tableNo = trim((string) ($input["table_no"] ?? ""));
        $items = is_array($input["items"] ?? null) ? $input["items"] : [];
        $itemsForDispatch = [];

        if ($branchId <= 0 || $tableNo === "") {
            echo JsonKit::fail("branch_id ve table_no zorunludur", 400);
            return;
        }
        if ($items === []) {
            echo JsonKit::fail("items bos olamaz", 400);
            return;
        }

        $now = date("Y-m-d H:i:s");
        $ordersDb = DB::table("orders");

        try {
            $ordersDb->query(
                "SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED"
            );
            $ordersDb->query("SET SESSION innodb_lock_wait_timeout = 3");
            $ordersDb->query("START TRANSACTION");

            $row = $ordersDb->query(
                'SELECT id FROM orders
                 WHERE branch_id = ? AND table_no = ? AND status = ? AND paid_at IS NULL
                 ORDER BY id DESC
                 LIMIT 1
                 FOR UPDATE',
                [$branchId, $tableNo, "pending"],
                "array"
            );
            $orderId = isset($row[0]["id"]) ? (int) $row[0]["id"] : 0;

            if ($orderId === 0) {
                $orderId = DB::table("orders")->insert([
                    "branch_id" => $branchId,
                    "user_id" => $userId ?: null,
                    "table_no" => $tableNo,
                    "total_amount" => 0,
                    "status" => "pending",
                    "created_at" => $now,
                ]);
                if (!$orderId) {
                    throw new RuntimeException("Siparis olusturulamadi");
                }
            }

            $added = 0;
            foreach ($items as $it) {
                $productId = (int) ($it["product_id"] ?? 0);
                $quantity = (float) ($it["quantity"] ?? 1);
                $unitPrice = (float) ($it["unit_price"] ?? 0);
                if ($productId <= 0 || $quantity <= 0) {
                    continue;
                }

                $lineTotal = round($quantity * $unitPrice, 2);
                $note = isset($it["note"]) ? (string) $it["note"] : "";

                DB::table("order_items")->insert([
                    "order_id" => $orderId,
                    "product_id" => $productId,
                    "quantity" => $quantity,
                    "unit_price" => $unitPrice,
                    "line_total" => $lineTotal,
                    "note" => $note,
                ]);

                $productName = isset($it["product_name"])
                    ? (string) $it["product_name"]
                    : (isset($it["name"])
                        ? (string) $it["name"]
                        : null);
                $categoryId = isset($it["category_id"])
                    ? (int) $it["category_id"]
                    : 0;

                $itemsForDispatch[] = [
                    "product_id" => $productId,
                    "category_id" => $categoryId,
                    "product_name" => $productName,
                    "quantity" => $quantity,
                    "note" => $note,
                ];

                $added++;
            }

            if ($added === 0) {
                throw new RuntimeException("Gecerli item eklenemedi");
            }

            $sumArr = DB::table("order_items")->query(
                "SELECT COALESCE(SUM(line_total),0) AS total FROM order_items WHERE order_id = ?",
                [$orderId],
                "array"
            );
            $newTotal = (float) ($sumArr[0]["total"] ?? 0);

            DB::table("orders")
                ->where("id", $orderId)
                ->update([
                    "total_amount" => $newTotal,
                ]);

            try {
                DB::table("tables")
                    ->where("branch_id", $branchId)
                    ->where("code", $tableNo)
                    ->update(["status" => "occupied", "updated_at" => $now]);
            } catch (Throwable $ignored) {
            }

            $ordersDb->query("COMMIT");

            try {
                $pdo = $ordersDb->getConnection();
                if ($itemsForDispatch) {
                    PrinterRouting::dispatchOrderToPrinters(
                        $pdo,
                        $branchId,
                        $orderId,
                        $tableNo,
                        $itemsForDispatch
                    );
                }
            } catch (Throwable $dispatchError) {
                error_log(
                    "Printer dispatch failed: " . $dispatchError->getMessage()
                );
            }

            echo JsonKit::json(
                [
                    "order_id" => $orderId,
                    "total_amount" => $newTotal,
                ],
                "Siparis guncellendi",
                200
            );
        } catch (Throwable $e) {
            try {
                $ordersDb->query("ROLLBACK");
            } catch (Throwable $ignored) {
            }
            echo JsonKit::fail("Islem basarisiz: " . $e->getMessage(), 500);
        }
    }

    public static function waiterOrders(): void
    {
        try {
            $days = max(1, (int) ($_GET["days"] ?? 30));
            $branchId = isset($_GET["branchId"])
                ? (int) $_GET["branchId"]
                : null;
            $onlyPaid = (int) ($_GET["onlyPaid"] ?? 1) === 1;

            $end = (new DateTimeImmutable("tomorrow"))->setTime(0, 0, 0);
            $start = $end->sub(new DateInterval("P" . $days . "D"));

            $dateCol = $onlyPaid ? "o.paid_at" : "o.created_at";

            $where = [];
            $params = [];

            if ($onlyPaid) {
                $where[] = "{$dateCol} IS NOT NULL";
            }
            $where[] = "{$dateCol} >= ?";
            $params[] = $start->format("Y-m-d H:i:s");
            $where[] = "{$dateCol} < ?";
            $params[] = $end->format("Y-m-d H:i:s");
            if ($branchId) {
                $where[] = "o.branch_id = ?";
                $params[] = $branchId;
            }

            $sql =
                '
                SELECT
                    COALESCE(NULLIF(TRIM(u.name), ""), CONCAT("Garson #", o.user_id), "Bilinmiyor") AS waiter_name,
                    o.user_id,
                    COUNT(*) AS orders_count
                FROM orders o
                LEFT JOIN users u ON u.id = o.user_id
                WHERE ' .
                implode(" AND ", $where) .
                '
                GROUP BY o.user_id, u.name
                ORDER BY orders_count DESC, waiter_name ASC
                LIMIT 20
            ';

            $rows = (new DB("orders"))->query($sql, $params, "array");

            $labels = array_map(
                static fn($r) => (string) ($r["waiter_name"] ?? "Bilinmiyor"),
                $rows
            );
            $data = array_map(
                static fn($r) => (int) ($r["orders_count"] ?? 0),
                $rows
            );

            echo JsonKit::json(
                [
                    "labels" => $labels,
                    "data" => $data,
                    "total" => array_sum($data),
                    "days" => $days,
                    "branchId" => $branchId,
                    "onlyPaid" => $onlyPaid ? 1 : 0,
                    "range" => [
                        $start->format("Y-m-d"),
                        $end->modify("-1 day")->format("Y-m-d"),
                    ],
                ],
                "Garsonlara gore siparis",
                200
            );
        } catch (Throwable $e) {
            echo JsonKit::fail("Hata: " . $e->getMessage(), 500);
        }
    }

    public static function staffPerformance(): void
    {
        try {
            $days = max(1, (int) ($_GET["days"] ?? 30));
            $branchId = isset($_GET["branchId"])
                ? (int) $_GET["branchId"]
                : null;

            $end = (new DateTimeImmutable("tomorrow"))->setTime(0, 0, 0);
            $start = $end->sub(new DateInterval("P" . $days . "D"));

            $where =
                "o.paid_at IS NOT NULL AND o.paid_at >= ? AND o.paid_at < ?";
            $params = [
                $start->format("Y-m-d H:i:s"),
                $end->format("Y-m-d H:i:s"),
            ];
            if ($branchId) {
                $where .= " AND o.branch_id = ?";
                $params[] = $branchId;
            }

            $sql =
                '
                SELECT
                    u.id   AS user_id,
                    u.name AS user_name,
                    r.name AS role_name,
                    COALESCE(s.orders, 0) AS orders,
                    COALESCE(s.sales, 0)  AS sales,
                    CASE WHEN COALESCE(s.orders, 0) = 0 THEN 0
                         ELSE ROUND(COALESCE(s.sales, 0) / s.orders, 2) END AS avg_sale
                FROM users u
                LEFT JOIN user_roles ur ON ur.user_id = u.id
                LEFT JOIN roles r ON r.id = ur.role_id
                LEFT JOIN (
                    SELECT
                        o.user_id,
                        COUNT(*) AS orders,
                        ROUND(COALESCE(SUM(o.total_amount), 0), 2) AS sales
                    FROM orders o
                    WHERE ' .
                $where .
                '
                    GROUP BY o.user_id
                ) s ON s.user_id = u.id
                ORDER BY s.sales DESC, s.orders DESC, user_name ASC
            ';

            $rows = (new DB("users"))->query($sql, $params, "array");

            $items = array_map(static function ($row) {
                return [
                    "user_id" => (int) ($row["user_id"] ?? 0),
                    "name" => (string) ($row["user_name"] ?? "Bilinmiyor"),
                    "role" => $row["role_name"] ?? null,
                    "sales" => (float) ($row["sales"] ?? 0),
                    "orders" => (int) ($row["orders"] ?? 0),
                    "avg_sale" => (float) ($row["avg_sale"] ?? 0),
                ];
            }, $rows);

            echo JsonKit::json(
                [
                    "range" => [
                        $start->format("Y-m-d"),
                        $end->modify("-1 day")->format("Y-m-d"),
                    ],
                    "days" => $days,
                    "branchId" => $branchId,
                    "currency" => "TRY",
                    "items" => $items,
                ],
                null,
                200
            );
        } catch (Throwable $e) {
            echo JsonKit::fail("Hata: " . $e->getMessage(), 500);
        }
    }
}
