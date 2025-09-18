<?php

namespace App\Controllers;

use App\Models\Tables;
use App\Core\DB;
use App\Utils\JsonKit;

class TablesController {
    protected $table;
    public function __construct() {
        $this->table = new Tables();
    }

    public static function getAllTables($branch_id) {
        $tables = Tables::all($branch_id);
        return $tables ?? [];
    }
    
    public static function getTableByCode($tableCode, $branch_id) {
        $tableCode = (string)$tableCode;
        $table = (new self())->table->findByCode($tableCode, $branch_id);
        return $table ?? null;
    }

    public static function updateTableStatus(){
        $input = json_decode(file_get_contents("php://input"));

        try {
            $save = DB::table("tables")->where("code", $input['table_no'])->update([
                'status' => $input['status'],
            ]);
            if($save){
                echo JsonKit::success("Masa durumu başarıyla güncellendi; " . $input['status']);
                exit;
            }
        } catch (\Throwable $th) {
            echo JsonKit::fail("Bir hata meydana geldi");
            exit;
        }
    }
}