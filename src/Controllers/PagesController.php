<?php

namespace App\Controllers;
use App\Models\View;

class PagesController {
    public function login() {
        View::render('login');
    }

    public function dashboard() {
        View::render('index', [
            'header' => dirname(__DIR__) . '/Views/partials/header.php',
            'sidebar' => dirname(__DIR__) . '/Views/partials/sidebar.php'
        ]);
    }

    public function __call($name, $arguments) {
        View::render($name);
        exit;
    }
}