<?php

namespace App\Controllers;

use App\Models\Suppliers;
use App\Utils\JsonKit;

class SuppliersController{
    protected $sp;

    public function __construct()
    {
        $this->sp = new Suppliers;
    }

    public function getSuppliers(){
        $suppliers = $this->sp->all($_SESSION['branch_id']);
        foreach($suppliers as &$data){
            $data['contact_info'] = json_decode($data['contact_info']);
        }
        echo JsonKit::json($suppliers, "Toptancılar getirildi");
    }
}