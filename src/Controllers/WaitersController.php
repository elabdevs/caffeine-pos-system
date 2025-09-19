<?php

namespace App\Controllers;

use App\Models\Waiter;
use App\Utils\JsonKit;

class WaitersController{
    protected $waiter;

    public function __construct()
    {
        $this->waiter = new Waiter();
    }

    public static function getWaiters($branch_id, $array = false){
        $waiters = (new self())->waiter->all();
        foreach($waiters as &$waiter){
            unset($waiter['password_hash']);
            unset($waiter['session_version']);
            unset($waiter['created_at']);
            unset($waiter['updated_at']);
        }
        if($waiters){
            if($array == true){
                return $waiters;
            } else {
                echo Jsonkit::json($waiters, "Garsonlar getirildi.");
            }
        }
    }

    public static function getWaitersCount($branch_id){
        return count((new self())->getWaiters($branch_id, true));
    }
}