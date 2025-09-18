<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController {
    protected $category;
    public function __construct() {
        $this->category = new Category();
    }

    public static function getAllCategories() {
        $categories = Category::all();
        return $categories ?? [];
    }
    
    public static function getCategoryById($categoryId, $branch_id) {
        $categoryId = (int)$categoryId;
        $category = (new self())->category->find($categoryId, $branch_id);
        return $category ?? null;
    }
}