<?php

namespace App\Controllers;

use App\Models\Product;

class ProductsController
{
    protected $product;
    public function __construct()
    {
        $this->product = new Product();
    }

    public static function getAllProducts()
    {
        $products = (new self())->product->all();
        return $products ?? [];
    }

    public static function productBreakdown(): void
    {
        try {
            $days = max(1, (int) ($_GET["days"] ?? 30));
            $branchId = isset($_GET["branchId"])
                ? (int) $_GET["branchId"]
                : null;
            $onlyPaid = (int) ($_GET["onlyPaid"] ?? 1) === 1;

            $end = (new \DateTimeImmutable("tomorrow"))->setTime(0, 0, 0);
            $start = $end->modify("-{$days} days");

            $dateCol = $onlyPaid ? "o.paid_at" : "o.created_at";

            $where = [];
            $bind = [];
            if ($onlyPaid) {
                $where[] = "{$dateCol} IS NOT NULL";
            }
            $where[] = "{$dateCol} >= ?";
            $bind[] = $start->format("Y-m-d H:i:s");
            $where[] = "{$dateCol} <  ?";
            $bind[] = $end->format("Y-m-d H:i:s");
            if ($branchId !== null) {
                $where[] = "o.branch_id = ?";
                $bind[] = $branchId;
            }

            $sql =
                "
          SELECT 
            p.id           AS product_id,
            p.name         AS product_name,
            p.category_id  AS category_id,
            COALESCE(SUM(oi.quantity), 0)    AS units_sold,
            COALESCE(SUM(oi.line_total), 0)  AS net_sales
          FROM order_items oi
          JOIN orders   o ON o.id = oi.order_id
          JOIN products p ON p.id = oi.product_id
          WHERE " .
                implode(" AND ", $where) .
                "
          GROUP BY p.id, p.name, p.category_id
          ORDER BY net_sales DESC
        ";

            $rows = (new \App\Core\DB("order_items"))->query(
                $sql,
                $bind,
                "array"
            );

            $totalSales = 0.0;
            $totalUnits = 0;
            foreach ($rows as $r) {
                $totalSales += (float) $r["net_sales"];
                $totalUnits += (int) $r["units_sold"];
            }

            $items = [];
            foreach ($rows as $r) {
                $items[] = [
                    "product_id" => (int) $r["product_id"],
                    "product_name" => $r["product_name"],
                    "category" => null,
                    "units_sold" => (int) $r["units_sold"],
                    "net_sales" => round((float) $r["net_sales"], 2),
                    "pct" =>
                        $totalSales > 0
                            ? round(
                                ((float) $r["net_sales"] / $totalSales) * 100,
                                2
                            )
                            : 0.0,
                    "refunds" => 0,
                ];
            }

            echo \App\Utils\JsonKit::json(
                [
                    "range" => [
                        $start->format("Y-m-d"),
                        $end->modify("-1 day")->format("Y-m-d"),
                    ],
                    "total_sales" => round($totalSales, 2),
                    "total_units" => (int) $totalUnits,
                    "items" => $items,
                    "days" => $days,
                    "onlyPaid" => $onlyPaid ? 1 : 0,
                    "branchId" => $branchId,
                ],
                "Product breakdown",
                200
            );
        } catch (\Throwable $e) {
            echo \App\Utils\JsonKit::fail("Hata: " . $e->getMessage(), 500);
        }
    }
}
