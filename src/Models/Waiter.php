<?php

namespace App\Models;

use App\Core\DB;

class Waiter {
    protected DB $db;

    public function __construct()
    {
        $this->db = new DB('users');
    }

    /**
     * Sadece garson (role_id=3) kullanıcıları döndürür.
     * İstersen branch filtresi verebilirsin.
     */
    public function all(?int $branchId = null): array
    {
        $q = (new DB('users'))->whereRaw('EXISTS (SELECT 1 FROM user_roles ur WHERE ur.user_id = users.id AND ur.role_id = ?)',[3]);

        if ($branchId !== null) {
            $q->where('branch_id', $branchId);
        }

        return $q->get();
    }
}
