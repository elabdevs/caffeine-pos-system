<?php

namespace App\Models;

use App\Core\DB;

class Product {
    protected $db;
    public function __construct()
    {
        $this->db = new DB("products");
    }

    public static function all(): array
{
    // Tek DB instance
    $self = new self();
    $db   = $self->db;

    // 1) Ürünleri çek
    $products = $db->table('products')->get(); // array<assoc>

    if (!$products) return [];

    // 2) Ürün id'lerini topla
    $productIds = array_map(fn($p) => (int)$p['id'], $products);

    // 3) Bu ürünlere ait tüm option gruplarını tek seferde çek
    $options = $db->table('product_options')
        ->whereIn('product_id', $productIds)
        ->orderBy('product_id')
        ->orderBy('sort_order')
        ->get(); // id, product_id, name, required, multiple, sort_order...

    // 4) Option id'lerini topla ve değerleri tek seferde çek
    $optionIds = array_map(fn($o) => (int)$o['id'], $options);
    $values = $optionIds
        ? $db->table('product_option_values')
            ->whereIn('option_id', $optionIds)
            ->orderBy('option_id')
            ->orderBy('sort_order')
            ->get() // id, option_id, label, price_delta, sort_order...
        : [];

    // 5) İndeksler: product_id -> [options], option_id -> [values]
    $optsByProduct = [];
    foreach ($options as $o) {
        $pid = (int)$o['product_id'];
        $optsByProduct[$pid][] = $o;
    }

    $valsByOption = [];
    foreach ($values as $v) {
        $oid = (int)$v['option_id'];
        $valsByOption[$oid][] = $v;
    }

    // 6) Her ürün için JSON yapısını üret
    foreach ($products as &$p) {
        $pid = (int)$p['id'];

        $mods = [];
        foreach ($optsByProduct[$pid] ?? [] as $opt) {
            $oid = (int)$opt['id'];

            $optionsArr = [];
            foreach ($valsByOption[$oid] ?? [] as $val) {
                $optionsArr[] = [
                    'n' => (string)$val['label'],
                    'p' => (float)$val['price_delta'],
                ];
            }

            $mods[] = [
                'name'     => (string)$opt['name'],
                'required' => (int)($opt['required'] ?? 0),
                // istersen 'multiple' da gönderebilirsin:
                // 'multiple' => (int)($opt['multiple'] ?? 0),
                'options'  => $optionsArr,
            ];
        }

        // Ürünün JSON payload’ı
        $payload = [
            'id'   => $pid,
            'name' => (string)$p['name'],
            'price'=> (float)$p['price'],
            'cat'  => (string)($p['category_id'] ?? ''), // istersen kategori adı/slug döndür
            'fav'  => (bool)($p['fav'] ?? false),
            'mods' => $mods,
        ];

        // Tek satırda JSON’a çevir
        $p['json'] = $payload;
    }
    unset($p);

    return $products;
}

}