<?php

namespace App\Controllers;

use App\Models\Tables;
use App\Models\Payment;
use App\Models\PaymentMethods;
use App\Core\DB;
use App\Utils\JsonKit;

class PaymentController
{
    public static function getOrdersByTableId($tableNo, $branchId)
    {
        $tableId = (string) $tableNo;
        $branchId = (int) $branchId;
        $table = Tables::findByCode($tableNo, $branchId);
        if (!$table || $table->status !== "occupied") {
            return null;
        }

        $payment = DB::table("orders")
            ->where("table_no", $tableNo)
            ->where("status", "pending")
            ->get();
        return $payment ?? null;
    }

    public static function getOrderItemsByOrderId($orderId)
    {
        $orderId = (int) $orderId;
        $orderItems = DB::table("order_items")
            ->where("order_id", $orderId)
            ->get();
        return $orderItems ?? null;
    }

    public static function getPaymentPayloadForTable(
        string $tableNo,
        int $branchId
    ): ?array {
        $table = Tables::findByCode($tableNo, $branchId);
        if (!$table || ($table["status"] ?? null) !== "occupied") {
            return null;
        }

        $order = DB::table("orders")
            ->where("table_no", $tableNo)
            ->where("status", "pending")
            ->whereNull("paid_at")
            ->orderBy("id", "desc")
            ->first();
        if (!$order) {
            return null;
        }

        $orderId = (int) $order["id"];

        $items = DB::table("order_items")
            ->where("order_id", $orderId)
            ->get();

        $prodNames = [];
        try {
            if (!empty($items)) {
                $pids = array_values(
                    array_unique(array_column($items, "product_id"))
                );
                if ($pids) {
                    $rows = DB::table("products")
                        ->whereIn("id", $pids)
                        ->get();
                    foreach ($rows as $r) {
                        $prodNames[(int) $r["id"]] =
                            $r["name"] ?? "Ürün #" . $r["id"];
                    }
                }
            }
        } catch (\Throwable $e) {
        }

        $servicePct = 0.0;
        $tipPct = 0.0;
        $discount = 0.0;

        $subtotal = 0.0;
        $clientItems = [];
        foreach ($items as $it) {
            $qty = (float) ($it["quantity"] ?? 1);
            $unit = (float) ($it["unit_price"] ?? 0);
            $lineTotal = (float) ($it["line_total"] ?? round($qty * $unit, 2));
            $pid = (int) $it["product_id"];

            $clientItems[] = [
                "id" => (int) $it["id"],
                "product_id" => $pid,
                "name" => $prodNames[$pid] ?? "Ürün #" . $pid,
                "qty" => $qty,
                "unit_price" => $unit,
                "modifiers" => [],
                "notes" => $it["note"] ?? "",
                "line_total" => $lineTotal,
            ];
            $subtotal += $lineTotal;
        }

        $service = round(($subtotal * $servicePct) / 100, 2);
        $discAmt = round($discount, 2);
        $tip = round((($subtotal + $service - $discAmt) * $tipPct) / 100, 2);
        $grand = round($subtotal + $service - $discAmt + $tip, 2);

        $payments = [];
        // try {
        //     $payRows = DB::table('payments')->where('order_id', $orderId)->get();
        //     foreach ($payRows as $p) {
        //         $payments[] = [
        //             'method' => $p['method'], // cash|card|qr|meal
        //             'amount' => (float)$p['amount'],
        //             'at'     => $p['created_at'] ?? null,
        //         ];
        //     }
        // } catch (\Throwable $e) {
        //     // payments tablosu yoksa boş geç
        // }
        $paid = array_reduce(
            $payments,
            fn($a, $b) => $a + (float) $b["amount"],
            0.0
        );
        $remain = round(max(0, $grand - $paid), 2);
        $change = round(max(0, $paid - $grand), 2);

        return [
            "order_id" => $orderId,
            "opened_at" => $order["created_at"] ?? null,
            "status" => $order["status"] ?? "pending",

            "branch" => ["id" => (int) $order["branch_id"], "name" => null],
            "table" => [
                "no" => $order["table_no"],
                "name" => (string) $order["table_no"],
                "guests" => null,
            ],
            "waiter" => [
                "id" => (int) ($order["user_id"] ?? 0),
                "name" => null,
            ],
            "currency" => "TRY",

            "service_pct" => $servicePct,
            "tip_pct" => $tipPct,
            "discount" => [
                "type" => "amount",
                "value" => $discAmt,
                "reason" => null,
            ],

            "items" => $clientItems,

            "totals" => [
                "subtotal" => round($subtotal, 2),
                "service" => $service,
                "discount_amount" => $discAmt,
                "tip" => $tip,
                "grand" => $grand,
                "paid" => round($paid, 2),
                "remain" => $remain,
                "change" => $change,
            ],

            "payments" => $payments,

            "print" => [
                "receipt_no" => null,
                "qr" => null,
            ],
        ];
    }

    public static function savePayment()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        try {
            if (
                !isset($data["payments"]) ||
                !is_array($data["payments"]) ||
                empty($data["payments"])
            ) {
                echo JsonKit::fail("payments boş/format hatalı", 400);
                return;
            }

            $orderId = $data["order_id"] ?? null;
            $branchId = $data["branch_id"] ?? null;
            $tableNo = $data["table_no"] ?? null;

            if (!$orderId || !$branchId) {
                echo JsonKit::fail("order_id ve branch_id zorunlu", 400);
                return;
            }

            try {
                if (count($data["payments"]) > 1) {
                    $paymentMethod = "mixed";
                } else {
                    $paymentMethod = $data["payments"][0]["method"];
                }

                DB::table("orders")
                    ->where("id", $orderId)
                    ->update([
                        "paid_at" => date("Y-m-d H:i:s"),
                        "payment_method" => $paymentMethod,
                    ]);
            } catch (\Throwable $th) {
                echo JsonKit::fail("Bir hata meydana geldi.", 500);
            }

            try {
                DB::table("tables")
                    ->where("code", $tableNo)
                    ->where("branch_id", $branchId)
                    ->update(["status" => "cleaning"]);
            } catch (\Throwable $th) {
                echo JsonKit::fail("Bir hata meydana geldi.", 500);
            }

            $inserted = 0;
            $errors = [];

            foreach ($data["payments"] as $i => $p) {
                $method = $p["method"] ?? null;
                $amount = isset($p["amount"]) ? (float) $p["amount"] : null;
                $txnRef = $p["txn_ref"] ?? null;

                if (!$method || $amount === null || $amount <= 0) {
                    $errors[] = "Satır #$i: method/amount geçersiz";
                    continue;
                }

                $ok = Payment::save([
                    "order_id" => $orderId,
                    "branch_id" => $branchId,
                    "table_no" => $tableNo,
                    "method" => $method,
                    "amount" => round($amount, 2),
                    "status" => "completed",
                    "txn_ref" => $txnRef,
                    "note" => $data["note"] ?? null,
                ]);

                if ($ok) {
                    $inserted++;
                } else {
                    $errors[] = "Satır #$i: insert başarısız";
                }
            }

            if ($inserted > 0 && empty($errors)) {
                echo JsonKit::success(
                    "Ödeme(ler) başarıyla alındı.",
                    ["inserted" => $inserted],
                    201
                );
            } elseif ($inserted > 0) {
                echo JsonKit::json(
                    ["inserted" => $inserted, "errors" => $errors],
                    "Kısmi başarı",
                    207
                );
            } else {
                echo JsonKit::fail("Hiçbir ödeme kaydedilemedi", 422, [
                    "errors" => $errors,
                ]);
            }
        } catch (\Throwable $e) {
            echo JsonKit::fail("Sunucu hatası: " . $e->getMessage(), 500);
        }
    }

    public static function getMonthlyRevenueRaw(
        ?int $year = null,
        ?int $month = null,
        ?int $branchId = null
    ) {
        $now = new \DateTimeImmutable("now");
        $year = $year ?? (int) $now->format("Y");
        $month = $month ?? (int) $now->format("m");

        $start = \DateTimeImmutable::createFromFormat(
            "Y-m-d H:i:s",
            sprintf("%04d-%02d-01 00:00:00", $year, $month)
        );
        $end = $start->modify("first day of next month");

        $where = "status = 'completed' AND created_at >= ? AND created_at < ?";
        $bind = [$start->format("Y-m-d H:i:s"), $end->format("Y-m-d H:i:s")];

        if ($branchId !== null) {
            $where .= " AND branch_id = ?";
            $bind[] = $branchId;
        }

        $total =
            (new DB("payments"))->query(
                "SELECT COALESCE(SUM(amount),0) AS total FROM payments WHERE $where",
                $bind,
                "array"
            )[0]["total"] ?? 0;

        $byDay = (new DB("payments"))->query(
            "SELECT DATE(created_at) AS day, COALESCE(SUM(amount),0) AS total
         FROM payments WHERE $where
         GROUP BY DATE(created_at) ORDER BY day ASC",
            $bind,
            "array"
        );

        $byMethod = (new DB("payments"))->query(
            "SELECT method, COALESCE(SUM(amount),0) AS total
         FROM payments WHERE $where
         GROUP BY method ORDER BY total DESC",
            $bind,
            "array"
        );

        return round((float) $total, 2);
    }

    public static function getRevenueTimeseries(
        ?int $year = null,
        ?int $month = null,
        ?int $branchId = null
    ): void {
        try {
            $now = new \DateTimeImmutable("now");
            $year = $year ?? (int) $now->format("Y");
            $month = $month ?? (int) $now->format("m");

            $start = (new \DateTimeImmutable("today"))
                ->modify("-6 days")
                ->setTime(0, 0, 0);
            $end = (new \DateTimeImmutable("tomorrow"))->setTime(0, 0, 0);

            $where =
                "status='completed' AND created_at >= ? AND created_at < ?";
            $bind = [
                $start->format("Y-m-d H:i:s"),
                $end->format("Y-m-d H:i:s"),
            ];

            if ($branchId !== null) {
                $where .= " AND branch_id = ?";
                $bind[] = $branchId;
            }

            $rows = (new \App\Core\DB("payments"))->query(
                "SELECT DATE(created_at) AS day, COALESCE(SUM(amount),0) AS total
             FROM payments
             WHERE $where
             GROUP BY DATE(created_at)
             ORDER BY day ASC",
                $bind,
                "array"
            );

            $labels = [];
            $series = [];
            for ($d = $start; $d < $end; $d = $d->modify("+1 day")) {
                $key = $d->format("Y-m-d");
                $labels[] = $key;
                $series[$key] = 0.0;
            }
            foreach ($rows as $r) {
                $series[$r["day"]] = (float) $r["total"];
            }
            $data = array_values($series);

            $total = array_sum($data);

            echo \App\Utils\JsonKit::json(
                [
                    "range" => [
                        $start->format("Y-m-d"),
                        $end->modify("-1 day")->format("Y-m-d"),
                    ],
                    "labels" => $labels,
                    "data" => $data,
                    "currency" => "TRY",
                    "total" => round($total, 2),
                ],
                "Zamana göre gelir",
                200
            );
        } catch (\Throwable $e) {
            echo \App\Utils\JsonKit::fail("Hata: " . $e->getMessage(), 500);
        }
    }

    public static function paymentMethods(
        ?int $days = null,
        ?int $branchId = null
    ): void {
        try {
            $days = max(1, (int) ($_GET["days"] ?? ($days ?? 30)));
            $branchId = isset($_GET["branchId"])
                ? (int) $_GET["branchId"]
                : $branchId;

            $end = (new \DateTimeImmutable("tomorrow"))->setTime(0, 0, 0);
            $start = $end->modify("-{$days} days");

            $where =
                "status='completed' AND created_at >= ? AND created_at < ?";
            $bind = [
                $start->format("Y-m-d H:i:s"),
                $end->format("Y-m-d H:i:s"),
            ];

            if ($branchId !== null) {
                $where .= " AND branch_id = ?";
                $bind[] = $branchId;
            }

            $rows = (new \App\Core\DB("payments"))->query(
                "SELECT method, COALESCE(SUM(amount),0) AS total
             FROM payments
             WHERE $where
             GROUP BY method
             ORDER BY total DESC",
                $bind,
                "array"
            );

            $grand = 0.0;
            foreach ($rows as $r) {
                $grand += (float) $r["total"];
            }

            $labels = [
                "card" => "Kredi Kartı",
                "debit" => "Banka Kartı",
                "cash" => "Nakit",
                "qr" => "QR",
                "meal" => "Yemek Kartı",
                "mixed" => "Karışık",
                "other" => "Diğer",
            ];

            $items = [];
            foreach ($rows as $r) {
                $code = strtolower(trim($r["method"] ?? "other"));
                $name = $labels[$code] ?? ucfirst($code);
                $total = round((float) $r["total"], 2);
                $pct = $grand > 0 ? round(($total * 100) / $grand, 2) : 0.0;

                $items[] = [
                    "method" => $code,
                    "label" => $name,
                    "total" => $total,
                    "pct" => $pct,
                ];
            }

            echo \App\Utils\JsonKit::json(
                [
                    "range" => [
                        $start->format("Y-m-d"),
                        $end->modify("-1 day")->format("Y-m-d"),
                    ],
                    "total" => round($grand, 2),
                    "currency" => "TRY",
                    "items" => $items,
                    "days" => $days,
                    "branchId" => $branchId,
                ],
                "Ödeme yöntemlerine göre dağılım",
                200
            );
        } catch (\Throwable $e) {
            echo \App\Utils\JsonKit::fail("Hata: " . $e->getMessage(), 500);
        }
    }

    public static function revenueByCategory(
        int $days = 30,
        ?int $branchId = null
    ): void {
        try {
            $start = (new \DateTimeImmutable("today"))
                ->modify("-" . ($days - 1) . " days")
                ->setTime(0, 0, 0);
            $end = (new \DateTimeImmutable("tomorrow"))->setTime(0, 0, 0);

            $where =
                "o.paid_at IS NOT NULL AND o.paid_at >= ? AND o.paid_at < ?";
            $bind = [
                $start->format("Y-m-d H:i:s"),
                $end->format("Y-m-d H:i:s"),
            ];

            if ($branchId !== null) {
                $where .= " AND o.branch_id = ?";
                $bind[] = $branchId;
            }

            $rows = (new DB("orders"))->query(
                "SELECT 
                    COALESCE(c.name, CONCAT('Kategori #', p.category_id)) AS label,
                    p.category_id,
                    COALESCE(SUM(oi.line_total),0) AS total
                 FROM orders o
                 JOIN order_items oi ON oi.order_id = o.id
                 JOIN products p     ON p.id       = oi.product_id
                 LEFT JOIN categories c ON c.id     = p.category_id
                 WHERE $where
                 GROUP BY p.category_id, c.name
                 ORDER BY total DESC",
                $bind,
                "array"
            );

            $labels = [];
            $data = [];
            $total = 0.0;

            foreach ($rows as $r) {
                $labels[] = (string) $r["label"];
                $val = (float) $r["total"];
                $data[] = $val;
                $total += $val;
            }

            echo JsonKit::json(
                [
                    "labels" => $labels,
                    "data" => $data,
                    "total" => round($total, 2),
                    "currency" => "TRY",
                    "range" => [
                        $start->format("Y-m-d"),
                        $end->modify("-1 day")->format("Y-m-d"),
                    ],
                    "days" => $days,
                    "branchId" => $branchId,
                ],
                "Kategoriye göre ciro",
                200
            );
        } catch (\Throwable $e) {
            echo JsonKit::fail("Hata: " . $e->getMessage(), 500);
        }
    }
    public static function revenueByTable(): void
    {
        try {
            $days = (int) ($_GET["days"] ?? 30);
            $branchId = isset($_GET["branchId"])
                ? (int) $_GET["branchId"]
                : null;

            $where =
                "paid_at IS NOT NULL AND paid_at >= NOW() - INTERVAL ? DAY";
            $bind = [$days];
            if ($branchId) {
                $where .= " AND branch_id = ?";
                $bind[] = $branchId;
            }

            $rows = (new DB("orders"))->query(
                "SELECT table_no, COALESCE(SUM(total_amount),0) AS total
                 FROM orders
                 WHERE $where
                 GROUP BY table_no
                 ORDER BY total DESC",
                $bind,
                "array"
            );

            $labels = array_map(
                fn($r) => (string) ($r["table_no"] ?? "—"),
                $rows
            );
            $data = array_map(fn($r) => (float) $r["total"], $rows);
            $sum = array_sum($data);

            echo JsonKit::json(
                [
                    "labels" => $labels,
                    "data" => $data,
                    "total" => round($sum, 2),
                    "days" => $days,
                    "branchId" => $branchId,
                ],
                "Masaya göre ciro",
                200
            );
        } catch (\Throwable $e) {
            echo JsonKit::fail("Hata: " . $e->getMessage(), 500);
        }
    }

    public function savePaymentMethods(){
        $payload = json_decode(file_get_contents("php://input"),true);
        if($payload){
            $save = PaymentMethods::save($payload);
            if($save){
                echo JsonKit::success("Ödeme yöntemleri kaydedildi");
            }
        }
    }
}
