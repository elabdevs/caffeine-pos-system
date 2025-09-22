<?php

namespace App\Controllers;

use App\Models\BranchHolidays;
use App\Utils\JsonKit;

class BranchHolidaysController {
    protected BranchHolidays $bh;

    public function __construct()
    {
        $this->bh = new BranchHolidays;
    }

    public static function getBranchHolidays(){
        if($_SESSION['branch_id']){
            $branch_id = $_SESSION['branch_id'];
        }

        $data = (new self())->bh->all($branch_id);

        if($data){
            echo JsonKit::json($data, "Veriler getirildi");
        }
    }
}