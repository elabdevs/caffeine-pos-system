<?php

namespace App\Controllers;

use App\Models\Ingredients;
use App\Utils\JsonKit;

class IngredientsController{
    protected $ig;

    public function __construct()
    {
        $this->ig = new Ingredients;
    }

    public function getAllIngredients(){
        echo JsonKit::json($this->ig->all($_SESSION['branch_id']), "Malzemeler getirildi");
    }

    public function saveIngredient(){
        $payload = json_decode(file_get_contents("php://input"),true);

        if($payload){
            $data = [
                'branch_id' => $_SESSION['branch_id'],
                'name' => $payload['name'],
                'unit' => $payload['unit'],
                'stock_quantity' => $payload['stock_quantity'],
                'min_threshold' => $payload['min_threshold'],
            ];
            $save = Ingredients::save($data);
            if($save){
                echo JsonKit::success("Veriler kaydedildi");
                exit;
            } else {
                echo JsonKit::fail("Bir hata oluştu");

            }
        }
    }

    public function removeIngredient($id){
        $delete = $this->ig->delete($id);

        if($delete){
            echo JsonKit::success("Malzeme başarıyla silindi");
            exit;
        } else {
            echo JsonKit::fail("Bir hata oluştu");
            exit;
        }
    }
}