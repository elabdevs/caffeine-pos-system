<?php

namespace App\Controllers;

use App\Utils\JsonKit;
use App\Models\User;
use App\Controllers\OrdersController;

class APIv1Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = new User();
    }

    public function login(): void
    {
        
        $isHttps =
            (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ||
            ($_SERVER["SERVER_PORT"] ?? "") === "443";

        session_set_cookie_params([
            "lifetime" => 0,
            "path" => "/",
            "secure" => $isHttps,
            "httponly" => true,
            "samesite" => "Lax",
        ]);

        session_start();
        if (($_SERVER["REQUEST_METHOD"] ?? "GET") !== "POST") {
            JsonKit::fail("method_not_allowed", 405);
            exit;
        }
        $ctype = $_SERVER["CONTENT_TYPE"] ?? "";
        if (!str_starts_with(strtolower($ctype), "application/json")) {
            JsonKit::fail("invalid_content_type", 415);
            exit;
        }

        $csrfHeader = $_SERVER["HTTP_X_CSRF_TOKEN"] ?? "";
        if (!hash_equals($_SESSION["csrf_token"] ?? "", $csrfHeader)) {
            JsonKit::fail("csrf_failed", 419);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true) ?: [];

        $username = trim((string) ($data["username"] ?? ""));
        $password = (string) ($data["password"] ?? "");

        if ($username === "" || $password === "") {
            JsonKit::fail("missing_fields", 422);
            exit;
        }

        $ip = $_SERVER["REMOTE_ADDR"] ?? "0.0.0.0";
        if ($this->tooManyAttempts($ip)) {
            JsonKit::fail("too_many_attempts", 429);
            exit;
        }
        $user = $this->user->findByUsername($username);

        $hash = $user["password_hash"] ?? "";
        $hash =
            $hash && preg_match('~^[A-Za-z0-9/+]+=*$~', $hash)
                ? (base64_decode($hash) ?:
                $hash)
                : $hash;

        $ok = $hash && password_verify($password, $hash);

        if ($ok && isset($user["status"]) && $user["status"] !== "active") {
            $ok = false;
        }

        if (!$ok) {
            $this->bumpAttempts($ip);
            usleep(200000);
            JsonKit::fail("invalid_credentials", 401);
            exit;
        }

        $this->clearAttempts($ip);

        session_regenerate_id(true);

        $_SESSION["user_id"] = (int) $user["id"];
        $_SESSION["role"] = (string) ($user["role"] ?? "user");
        $_SESSION["branch_id"] = $user["branch_id"] ?? null;
        $_SESSION["login_at"] = time();
        $_SESSION["last_activity"] = time();
        $_SESSION["ua_hash"] = hash(
            "sha256",
            $_SERVER["HTTP_USER_AGENT"] ?? ""
        );
        $_SESSION["session_version"] =
            (string) ($user["session_version"] ?? "1");
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

        JsonKit::success([
            "message" => "login_success",
            "redirect" => "/admin",
        ]);
        exit;
    }

    private function tooManyAttempts(
        string $ip,
        int $max = 5,
        int $windowSec = 300
    ): bool {
        $key = sys_get_temp_dir() . "/login_" . sha1($ip);
        $now = time();
        $arr = is_file($key)
            ? (json_decode(file_get_contents($key), true) ?:
            [])
            : [];
        $arr = array_filter($arr, fn($t) => $now - (int) $t < $windowSec);
        return count($arr) >= $max;
    }

    private function bumpAttempts(string $ip): void
    {
        $key = sys_get_temp_dir() . "/login_" . sha1($ip);
        $arr = is_file($key)
            ? (json_decode(file_get_contents($key), true) ?:
            [])
            : [];
        $arr[] = time();
        file_put_contents($key, json_encode($arr));
    }

    private function clearAttempts(string $ip): void
    {
        $key = sys_get_temp_dir() . "/login_" . sha1($ip);
        @unlink($key);
    }

    public function getUsers(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        $users = $this->user->all();
        JsonKit::json($users, "Veriler alındı", 200);
        exit;
    }

    public function allSecurityRules($user){
        if (($_SERVER["REQUEST_METHOD"] ?? "GET") !== "POST") {
            JsonKit::fail("method_not_allowed", 405);
            exit;
        }
        $ctype = $_SERVER["CONTENT_TYPE"] ?? "";
        if (!str_starts_with(strtolower($ctype), "application/json")) {
            JsonKit::fail("invalid_content_type", 415);
            exit;
        }

        $ip = $_SERVER["REMOTE_ADDR"] ?? "0.0.0.0";
        if ($this->tooManyAttempts($ip)) {
            JsonKit::fail("too_many_attempts", 429);
            exit;
        }

        $csrfHeader = $_SERVER["HTTP_X_CSRF_TOKEN"] ?? "";
        if (!hash_equals($_SESSION["csrf_token"] ?? "", $csrfHeader)) {
            JsonKit::fail("csrf_failed", 419);
            exit;
        }

        if (isset($user["status"]) && $user["status"] !== "active") {
            $ok = false;
        }

        if (!$ok) {
            $this->bumpAttempts($ip);
            usleep(200000);
            JsonKit::fail("invalid_credentials", 401);
            exit;
        }
    }

    public function handheldLogin(): void
{
    // die("asdasd");
    // ---- HTTPS & session cookie ayarları
    $isHttps =
        (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ||
        (($_SERVER["SERVER_PORT"] ?? "") === "443");

        if(session_status() === PHP_SESSION_NONE){
            session_set_cookie_params([
                "lifetime" => 0,
                "path"     => "/",
                "secure"   => $isHttps,
                "httponly" => true,
                "samesite" => "Lax",
            ]);
        
            session_start();
        }

    // ---- Yöntem / Content-Type kontrol
    if (($_SERVER["REQUEST_METHOD"] ?? "GET") !== "POST") {
        JsonKit::fail("method_not_allowed", 405);
        exit;
    }
    $ctype = $_SERVER["CONTENT_TYPE"] ?? "";
    if (!str_starts_with(strtolower($ctype), "application/json")) {
        JsonKit::fail("invalid_content_type", 415);
        exit;
    }

    // ---- CSRF
    $csrfHeader = $_SERVER["HTTP_X_CSRF_TOKEN"] ?? "";
    if (!hash_equals($_SESSION["csrf_token"] ?? "", $csrfHeader)) {
        JsonKit::fail("csrf_failed", 419);
        exit;
    }

    // ---- Input
    $data = json_decode(file_get_contents("php://input"), true) ?: [];

    $username = trim((string)($data["username"] ?? ""));
    $password = (string)($data["password"] ?? "");
    $branch   = (string)($data["branch"]   ?? "");
    $shift    = (string)($data["shift"]    ?? "");

    if ($username === "" || $password === "" || $branch === "" || $shift === "") {
        JsonKit::fail("missing_fields", 422);
        exit;
    }

    // ---- Basit rate-limit (IP bazlı)
    $ip = $_SERVER["REMOTE_ADDR"] ?? "0.0.0.0";
    if ($this->tooManyAttempts($ip)) {
        JsonKit::fail("too_many_attempts", 429);
        exit;
    }

    // ---- Kullanıcı doğrulama
    $user = $this->user->findByUsername($username);

    $hash = $user["password_hash"] ?? "";
    $hash = $hash && preg_match('~^[A-Za-z0-9/+]+=*$~', $hash)
        ? (base64_decode($hash) ?: $hash)
        : $hash;

    $ok = $hash && password_verify($password, $hash);

    if ($ok && isset($user["status"]) && $user["status"] !== "active") {
        $ok = false;
    }

    if (!$ok) {
        $this->bumpAttempts($ip);
        usleep(200000);
        JsonKit::fail("invalid_credentials", 401);
        exit;
    }

    $this->clearAttempts($ip);

    // ---- Oturum kur
    session_regenerate_id(true);

    $_SESSION["waiter_user_id"]         = (int)($user["id"]);
    $_SESSION["waiter_role"]            = (string)($user["role"] ?? "user");
    // Tercih: branch frontenden geldiyse onu yaz; yoksa user içindeki branch_id
    $_SESSION["waiter_branch_id"]       = $user["branch_id"] ?? $branch;
    $_SESSION["waiter_shift"]           = $shift;
    $_SESSION["waiter_is_handheld"]     = true; // handheld bayrağı
    $_SESSION["waiter_login_at"]        = time();
    $_SESSION["waiter_last_activity"]   = time();
    $_SESSION["waiter_ua_hash"]         = hash("sha256", $_SERVER["HTTP_USER_AGENT"] ?? "");
    $_SESSION["waiter_session_version"] = (string)($user["session_version"] ?? "1");

    // Yeni istekler için taze CSRF
    $_SESSION["csrf_token"]      = bin2hex(random_bytes(32));

    JsonKit::success([
        "message"  => "login_success",
        "redirect" => "/handheld/dashboard",
    ]);
    exit;
}

    public function createOrder(){
        OrdersController::createOrder();
    }

    public function settle(){
        PaymentController::savePayment();
    }

}
