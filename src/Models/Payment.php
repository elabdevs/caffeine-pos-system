<?php

namespace App\Models;

use App\Core\DB;

class Payment{
    protected $db;

    public function __construct()
    {
        $this->db = new DB("payments");
    }

    public static function save($data){
        return (new self())->db->insert($data);
    }
}