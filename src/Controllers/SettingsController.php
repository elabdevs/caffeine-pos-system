<?php

namespace App\Controllers;

use App\Models\Settings;
use App\Models\BusinessHours;
use App\Models\BranchHolidays;
use App\Utils\JsonKit;

class SettingsController{
    protected $settings;
    protected $businessHours;
    protected $holidays;

    public function __construct()
    {
        $this->settings = new Settings;
        $this->businessHours = new BusinessHours;
        $this->holidays = new BranchHolidays;
    }

    public static function saveSettings(){
        $payload = json_decode(file_get_contents("php://input"),true);

        if(!$payload){
            echo JsonKit::fail("Geçersiz istek", 400);
            return;
        }

        $branch_id = $payload['branch_id'];

        $settingsData = json_encode([
            'cafe' => $payload['cafe'],
            'financials' => $payload['financials'],
            'localization' => $payload['localization']
        ]);
        $businessHoursData = json_encode([
            'business_hours' => $payload['business_hours']
        ]);
        $holidaysData = json_encode([
            'holidays' => $payload['holidays']
        ]);
        
        $settingsSave = (new self())->settings->save($settingsData, $branch_id);
        $businessHoursSave = (new self())->businessHours->save($businessHoursData, $branch_id);
        var_dump($settingsSave, $businessHoursSave);
        // $holidaysSave = (new self())->holidays->save($settingsData, $branch_id);
        
    }
}