<?php

namespace App\Controllers;

use App\Models\Branches;

class BranchController
{
    public static function getBrancByBranchId($branchId)
    {
        $branchId = (int)$branchId;
        $branch = Branches::find($branchId);
        return $branch ?? null;
    }
}