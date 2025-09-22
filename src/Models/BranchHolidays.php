<?php

namespace App\Models;

use App\Core\DB;

class BranchHolidays{
    protected DB $db;

    public function __construct()
    {
        $this->db = new DB("branch_holidays");
    }

    public static function all($branch_id){
        return (new self())->db->where("branch_id", $branch_id)->get();
    }

    public static function insert($data, $branch_id){
        return (new self())->db->insert([
            "branch_id" => $branch_id,
            "settings" => $data
        ]);
    }

    public static function update($data, $branch_id){
        return (new self())->db->where("branch_id", $branch_id)->update($data);
    }
}