<?php

namespace App\Models;

use App\Core\DB;

class Branches{
    protected $db;

    public function __construct() {
        $this->db = new DB('branches');
    }

    public static function find($branchId){
        $branchId = (int)$branchId;
        
        $branch = (new self())->db->where("id", $branchId)->first();
        return $branch ?: null;
    }
}