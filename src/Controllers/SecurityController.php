<?php
namespace App\Middlewares;

class AuthMiddleware
{
    public function ensureSessionAlive(int $idle=900, int $absolute=28800) {
        session_start();
        $now = time();
        if (!isset($_SESSION['user_id'])) return false;

        $ua = hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? '');
        if (($ua !== ($_SESSION['ua_hash'] ?? ''))) return false;

        if (($now - ($_SESSION['last_activity'] ?? 0)) > $idle) return false;

        if (($now - ($_SESSION['login_at'] ?? 0)) > $absolute) return false;

        if (($now - ($_SESSION['last_activity'] ?? 0)) > 300) {
            session_regenerate_id(true);
        }
        $_SESSION['last_activity'] = $now;

        $currentVersion = db_get_user_session_version($_SESSION['user_id']);
        if ($currentVersion !== ($_SESSION['session_version'] ?? null)) return false;

        return true;
    }

    public function csrf_field(): string {
        $t = $_SESSION['csrf_token'] ?? '';
        return '<input type="hidden" name="csrf_token" value="'.htmlspecialchars($t, ENT_QUOTES).'">';
    }
    public function csrf_check(string $token): bool {
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }
}