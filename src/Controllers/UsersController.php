<?php

namespace App\Controllers;

use App\Models\User;

class UsersController {
    protected $user;
    public function __construct() {
        $this->user = new User();
    }
    public static function getUserById($userId) {
        $userId = (int)$userId;
        $user = (new self())->user->find($userId);

        return $user ?? null;
    }
}