<?php

namespace App\Controllers;

use App\Models\Product;

class ProductsController {
    protected $product;
    public function __construct() {
        $this->product = new Product();
    }

    public static function getAllProducts() {
        $products = (new self())->product->all();
        return $products ?? [];
    }
}