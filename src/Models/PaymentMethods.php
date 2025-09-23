<?php

namespace App\Models;

use App\Core\DB;
use Exception;

class PaymentMethods {
    protected $db;

    public function __construct()
    {
        $this->db = new DB("payment_methods");
    }

    public static function save($data)
    {
        $db = (new self())->db;

        if (!isset($data['payment_methods']) || !is_array($data['payment_methods'])) {
            return false;
        }

        try {
            foreach ($data['payment_methods'] as $code => $active) {
                $sql = $db->where("code", $code)
                   ->update([
                       "is_system_active" => $active ? 1 : 0,
                       "updated_at" => date("Y-m-d H:i:s")
                   ]);
                   var_dump($sql);
            }
            //code...
        } catch (\Exception $e) {
            throw new Exception($e);
        }

        return true;
    }
}
