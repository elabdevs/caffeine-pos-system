<?php

namespace App\Models;

use App\Core\DB;

class Category {
    protected $db;
    public function __construct() {
        $this->db = new DB('categories');
    }

    public static function all(){
        $categories = (new self())->db->where("is_active", 1)->get();
        return $categories ?: [];
    }
    
    public static function find($categoryId){
        $categoryId = (int)$categoryId;
        
        $category = (new self())->db->where("id", $categoryId)->where("is_active", 1)->first();
        return $category ?: null;
    }
}