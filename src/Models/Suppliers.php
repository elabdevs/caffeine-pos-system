<?php

namespace App\Models;

use App\Core\DB;

class Suppliers{
    protected $db;

    public function __construct()
    {
        $this->db = new DB('suppliers');
    }

    public static function all($branch_id){
        return (new self())->db->where("branch_id", $branch_id)->get();
    }
}