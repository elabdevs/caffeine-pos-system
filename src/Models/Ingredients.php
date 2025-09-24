<?php

namespace App\Models;

use App\Core\DB;

class Ingredients {
    protected $db;

    public function __construct()
    {
        $this->db = new DB("ingredients");
    }

    public static function all($branch_id){
        return (new self())->db->where("branch_id", $branch_id)->get();
    }

    public static function save($data){
        return (new self())->db->insert($data);
    }

    public static function delete($id){
        return (new self())->db->where("id",$id)->delete($id);
    }
}