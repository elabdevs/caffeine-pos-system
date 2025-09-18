<?php

namespace App\Models;

use App\Core\DB;

class Order {
    protected $db;
    public function __construct() {
        $this->db = new DB('orders');
    }

    public static function createOrder($data) {
        $orderModel = new self();
        $orderId = (new self())->db->insert($data);
        return $orderId ?: null;
    }

    public static function createOrderItems($data){
        $orderItemsId = (new self())->db->table("order_items")->insert($data);
        return $orderItemsId ?: null;
    }
}