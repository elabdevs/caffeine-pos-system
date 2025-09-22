<?php

namespace App\Controllers;

use App\Models\BusinessHours as BH;
use App\Utils\JsonKit;

class BusinessHoursController {
    protected BH $bh;

    public function __construct()
    {
        $this->bh = new BH;
    }

    public static function getBusinessHours(){
        if(isset($_SESSION['branch_id'])){
            $bhid = $_SESSION['branch_id'];
        }
        $bh = (new self())->bh->all($bhid);

        if($bh){
            echo JsonKit::json($bh, "Veriler getirildi");
        }
    }
}