<?php
namespace App\Models;

use App\Core\DB;

class User
{
    public $db;

    public function __construct()
    {
        $this->db = new DB('users');
    }

    public function findByUsername(string $username): ?array
    {
        $username = trim(strtolower($username));

        $userSql = "
            SELECT *
            FROM users
            WHERE username = ?
            LIMIT 1
        ";
        $rows = $this->db->query($userSql, [$username], 'array');
        if (!$rows) {
            return null;
        }
        $user = $rows[0];

        $rolesSql = "
            SELECT r.name
            FROM roles r
            INNER JOIN user_roles ur ON ur.role_id = r.id
            WHERE ur.user_id = ?
        ";
        $roleRows = $this->db->query($rolesSql, [$user['id']], 'array');
        $user['roles'] = array_column($roleRows, 'name');

        return $user;
    }

    public function all(){
        $users = $this->db->get();
        foreach($users as &$user){
            unset($user['password_hash']);
        }
        return $users;
    }

    public function find(int $id): ?array
    {
        $user = $this->db->where("id", $id)->first();
        if ($user) {
            unset($user['password_hash']);
        }
        return $user ?: null;
    }
}