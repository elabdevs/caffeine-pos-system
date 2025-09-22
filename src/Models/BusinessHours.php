<?php

namespace App\Models;

use App\Core\DB;

class BusinessHours{
    protected $db;

    public function __construct()
    {
        $this->db = new DB("business_hours");
    }

    public static function all($branch_id){
        return (new self())->db->where("branch_id", $branch_id)->get();
    }

    public static function save($data, $branch_id){
        return (new self())->db->where("branch_id", $branch_id)->update($data);
    }
}