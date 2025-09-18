<?php

namespace App\Models;


class View
{
    public static function render($template, $data = [])
    {
        extract($data);
        include dirname(__DIR__) . "/Views/{$template}.php";

    }
}