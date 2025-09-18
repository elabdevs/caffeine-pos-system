<?php

namespace App\Models;

use App\Core\DB;

class Tables {
    protected $db;
    public function __construct() {
        $this->db = new DB('tables');
    }

    public static function all($branch_id){
        $tables = (new self())->db->where("branch_id", $branch_id)->get();
        return $tables ?: [];
    }

    public static function find($tableId, $branch_id){
        $tableId = (int)$tableId;
        
        $table = (new self())->db->where("id", $tableId)->where("branch_id", $branch_id)->first();
        return $table ?: null;
    }

    public static function findByCode($tableCode, $branch_id){
        $tableCode = (string)$tableCode;
        
        $table = (new self())->db->where("code", $tableCode)->where("branch_id", $branch_id)->first();
        return $table ?: null;
    }

    public static function changeStatus($tableNo, $status){
        $tableNo = (string)$tableNo;
        $status = (string)$status;

        $update = (new self())->db->where("code", $tableNo)->update(['status' => $status]);
        return $update;
    }
}