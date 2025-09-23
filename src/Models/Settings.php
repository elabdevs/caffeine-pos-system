<?php

namespace App\Models;

use App\Core\DB;

class Settings{
    protected $db;

    public function __construct()
    {
        $this->db = new DB("settings");
    }

    public static function save($data, $branch_id){
        $jsonSettings = is_array($data) ? json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : $data;

        $db = new self();

        if(!$db->db->where("branch_id", $branch_id)->first()){
            $save = $db->db->insert([
                'branch_id' => $branch_id,
                'settings'  => $jsonSettings
            ]);
            return $save ?: false;
        } else {
            $save = $db->db->where("branch_id", $branch_id)->update([
                'settings' => $jsonSettings
            ]);
            return $save ?: false;
        }
    }
}