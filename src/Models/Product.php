<?php

namespace App\Models;

use App\Core\DB;

class Product
{
    protected $db;
    public function __construct()
    {
        $this->db = new DB("products");
    }

    public static function all(): array
    {
        $self = new self();
        $db = $self->db;

        $products = $db->table("products")->get();

        if (!$products) {
            return [];
        }

        $productIds = array_map(fn($p) => (int) $p["id"], $products);

        $options = $db
            ->table("product_options")
            ->whereIn("product_id", $productIds)
            ->orderBy("product_id")
            ->orderBy("sort_order")
            ->get();

        $optionIds = array_map(fn($o) => (int) $o["id"], $options);
        $values = $optionIds
            ? $db
                ->table("product_option_values")
                ->whereIn("option_id", $optionIds)
                ->orderBy("option_id")
                ->orderBy("sort_order")
                ->get()
            : [];

        $optsByProduct = [];
        foreach ($options as $o) {
            $pid = (int) $o["product_id"];
            $optsByProduct[$pid][] = $o;
        }

        $valsByOption = [];
        foreach ($values as $v) {
            $oid = (int) $v["option_id"];
            $valsByOption[$oid][] = $v;
        }

        foreach ($products as &$p) {
            $pid = (int) $p["id"];

            $mods = [];
            foreach ($optsByProduct[$pid] ?? [] as $opt) {
                $oid = (int) $opt["id"];

                $optionsArr = [];
                foreach ($valsByOption[$oid] ?? [] as $val) {
                    $optionsArr[] = [
                        "n" => (string) $val["label"],
                        "p" => (float) $val["price_delta"],
                    ];
                }

                $mods[] = [
                    "name" => (string) $opt["name"],
                    "required" => (int) ($opt["required"] ?? 0),
                    "options" => $optionsArr,
                ];
            }

            $payload = [
                "id" => $pid,
                "name" => (string) $p["name"],
                "price" => (float) $p["price"],
                "cat" => (string) ($p["category_id"] ?? ""),
                "fav" => (bool) ($p["fav"] ?? false),
                "mods" => $mods,
            ];

            $p["json"] = $payload;
        }
        unset($p);

        return $products;
    }
}
