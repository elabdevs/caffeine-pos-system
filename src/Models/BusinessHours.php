<?php

namespace App\Models;

use App\Core\DB;
use Exception;

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
        if(is_array($data)){
            try {
                foreach($data as $value){
                    (new self())->db->where("branch_id", $branch_id)->where("weekday", $value['weekday'])->update([
                        'open_time' => $value['open_time'],
                        'close_time' => $value['close_time'],
                        'enabled' => $value['enabled']
                    ]);
                }
                return true;
            } catch (Exception $e) {
                throw new Exception("Error Processing Request: ".$e, 1);
            }
        }
    }
}