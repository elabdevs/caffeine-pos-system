<?php
declare(strict_types=1);

namespace App\Middlewares;
use App\Core\DB;
use App\Models\View;
use Throwable;

final class AuthMiddleware
{
    public static array $whitelist = [
        '/login',
        '/api/v1/login',
        '/api/v1/handheld/login',
        '/api/v1/handheld/createOrder',
        '/api/v1/handheld/settle',
        '/register',
        '/forgot-password',
        '/auth/refresh',
        '/assets',
        '/favicon.ico',
        '/handheld',
        '/handheld/',
        '/handheld/login',
        '/handheld/dashboard',
        '/handheld/tables',
        '/handheld/payment',
        '/handheld/table',
    ];
    public static function handle(array $opt = []): void
    {
        // ---- Defaults
        $requireLogin = $opt['requireLogin'] ?? true;
        $roles        = $opt['roles'] ?? null;
        $idle         = $opt['idle'] ?? 900;
        $absolute     = $opt['absolute'] ?? 28800;
        $apiMode      = $opt['api'] ?? self::isApiRequest();
        $redirectTo   = $opt['redirect'] ?? '/login';
        $path         = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';


        if (self::isWhitelisted($path)) {
            // Whitelist sayfalarda CSRF token hazırla
            if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
                csrfToken();
            }
            return; // normal login kontrolünü atla
        }

        // ---- Session başlat
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // ---- Login gerekli mi?
        if ($requireLogin && empty($_SESSION['user_id'])) {
            self::fail($apiMode, $redirectTo, 401, 'not_authenticated');
        }

        // ---- UA kilidi (opsiyonel ama güçlü)
        $uaHash = hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? '');
        if (!hash_equals($_SESSION['ua_hash'] ?? '', $uaHash)) {
            self::destroyAndFail($apiMode, $redirectTo, 401, 'ua_mismatch');
        }

        $now = time();

        // ---- Idle timeout
        $last = (int)($_SESSION['last_activity'] ?? 0);
        if ($last && ($now - $last) > $idle) {
            self::destroyAndFail($apiMode, $redirectTo, 401, 'idle_timeout');
        }

        // ---- Absolute timeout
        $loginAt = (int)($_SESSION['login_at'] ?? 0);
        if ($loginAt && ($now - $loginAt) > $absolute) {
            self::destroyAndFail($apiMode, $redirectTo, 401, 'absolute_timeout');
        }

        // ---- CSRF (yalnızca state-changing isteklerde)
        if (in_array($_SERVER['REQUEST_METHOD'] ?? 'GET', ['POST','PUT','PATCH','DELETE'], true)) {
            $sent = $_POST['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
            if (!self::csrfCheck($sent)) {
                self::fail($apiMode, $redirectTo, 419, 'csrf_failed');
            }
        }

        // ---- session_version (force logout mekanizması)
        $currentVersion = self::dbGetUserSessionVersion((int)$_SESSION['user_id']);
        // die(var_dump($currentVersion, $_SESSION['session_version'] ?? null));
        if ($currentVersion === null || $currentVersion !== ($_SESSION['session_version'] ?? null)) {
            self::destroyAndFail($apiMode, $redirectTo, 401, 'session_version_mismatch');
        }

        // ---- Rol kontrolü (opsiyonel)
        if (is_array($roles) && $roles) {
            $role = (string)($_SESSION['role'] ?? '');
            if (!in_array($role, $roles, true)) {
                self::fail($apiMode, $redirectTo, 403, 'forbidden');
            }
        }

        // ---- Periyodik session id yenilemesi + last_activity güncelle
        if (($now - $last) > 300) { // 5 dk
            session_regenerate_id(true);
        }
        $_SESSION['last_activity'] = $now;
    }

    private static function isApiRequest(): bool
    {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        $xhr    = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
        $uri    = $_SERVER['REQUEST_URI'] ?? '';
        return str_contains($accept, 'application/json')
            || strcasecmp($xhr, 'XMLHttpRequest') === 0
            || str_starts_with($uri, '/api/');
    }

    private static function csrfCheck(string $token): bool
    {
        $sess = $_SESSION['csrf_token'] ?? '';
        return $token !== '' && hash_equals($sess, $token);
    }

    private static function jsonOut(int $code, string $error): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok'=>false, 'error'=>$error], JSON_UNESCAPED_UNICODE);
        exit;
    }

    private static function destroyAndFail(bool $api, string $redirect, int $code, string $error): void
    {
        try { session_destroy(); } catch (Throwable) {}
        self::fail($api, $redirect, $code, $error);
    }

    private static function fail(bool $api, string $redirect, int $code, string $error): void
    {
        if ($api) {
            self::jsonOut($code, $error);
        }
        $current = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        if ($current === $redirect) {
            http_response_code(401);
            View::render("login", ['error' => $error]);
            exit;
        }
        header('Location: '.$redirect.'?reason='.urlencode($error));
        exit;
    }

    private static function dbGetUserSessionVersion(int $userId): ?string
    {
        $row = DB::table("users")->where("id", $userId)->first()['session_version'] ?? null;
        // die(var_dump($row));
        return $row ?? null;
    }

    private static function isWhitelisted(string $path): bool
    {
        foreach (self::$whitelist as $g) {
            if ($path === $g || str_starts_with($path, rtrim($g, '/').'/')) {
                return true;
            }
        }
        return false;
    }
}
