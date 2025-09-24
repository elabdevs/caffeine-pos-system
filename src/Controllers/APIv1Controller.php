<?php

namespace App\Controllers;

use App\Utils\JsonKit;
use App\Models\User;
use App\Controllers\OrdersController;
use App\Controllers\WaitersController;
use App\Core\DB;

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
            exit();
        }

        $ip = $_SERVER["REMOTE_ADDR"] ?? "0.0.0.0";
        if ($this->tooManyAttempts($ip)) {
            JsonKit::fail("too_many_attempts", 429);
            exit;
        }
        $user = $this->user->findByUsername($username);

        
        $permissions = $this->getUserPermissions($user['id']);

        if (empty($permissions['merged_permissions']['super_admin']) || empty($permissions['merged_permissions']['admin.panel.login'])) {
            JsonKit::fail("Yetkisiz erişim.", 403);
            exit;
        }

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
            exit();
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
        exit();
    }

    private function getUserPermissions(int $userId): array {
        $rows = DB::table('user_roles')
            ->join('roles', 'role_id', '=', 'roles.id')
            ->where('user_id', $userId)
            ->select([
                'roles.id AS role_id',
                'roles.name AS role_name',
                'roles.permissions AS permissions_json'
            ])
            ->get();

        $roles   = [];
        $merged  = [];

        foreach ($rows as $r) {
            $perm = json_decode($r['permissions_json'] ?? '[]', true);
            if (!is_array($perm)) { $perm = []; }

            $roles[] = [
                'id'          => (int)$r['role_id'],
                'name'        => $r['role_name'],
                'permissions' => $perm,
            ];

            foreach ($perm as $key => $val) {
                if (!isset($merged[$key])) {
                    $merged[$key] = $val;
                } else {
                    $merged[$key] = (bool)$merged[$key] || (bool)$val;
                }
            }
        }

        return [
            'user_id'            => $userId,
            'roles'              => $roles,
            'merged_permissions' => $merged
        ];
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

    public function getUsers()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $users = $this->user->all();
        JsonKit::json($users, "Veriler alındı", 200);
        exit();
    }

    public function allSecurityRules($user)
    {
        if (($_SERVER["REQUEST_METHOD"] ?? "GET") !== "POST") {
            JsonKit::fail("method_not_allowed", 405);
            exit();
        }
        $ctype = $_SERVER["CONTENT_TYPE"] ?? "";
        if (!str_starts_with(strtolower($ctype), "application/json")) {
            JsonKit::fail("invalid_content_type", 415);
            exit();
        }

        $ip = $_SERVER["REMOTE_ADDR"] ?? "0.0.0.0";
        if ($this->tooManyAttempts($ip)) {
            JsonKit::fail("too_many_attempts", 429);
            exit();
        }

        $csrfHeader = $_SERVER["HTTP_X_CSRF_TOKEN"] ?? "";
        if (!hash_equals($_SESSION["csrf_token"] ?? "", $csrfHeader)) {
            JsonKit::fail("csrf_failed", 419);
            exit();
        }

        if (isset($user["status"]) && $user["status"] !== "active") {
            $ok = false;
        }

        if (!$ok) {
            $this->bumpAttempts($ip);
            usleep(200000);
            JsonKit::fail("invalid_credentials", 401);
            exit();
        }
    }

    public function handheldLogin(): void
    {
        $isHttps =
            (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ||
            ($_SERVER["SERVER_PORT"] ?? "") === "443";

        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                "lifetime" => 0,
                "path" => "/",
                "secure" => $isHttps,
                "httponly" => true,
                "samesite" => "Lax",
            ]);

            session_start();
        }

        if (($_SERVER["REQUEST_METHOD"] ?? "GET") !== "POST") {
            JsonKit::fail("method_not_allowed", 405);
            exit();
        }
        $ctype = $_SERVER["CONTENT_TYPE"] ?? "";
        if (!str_starts_with(strtolower($ctype), "application/json")) {
            JsonKit::fail("invalid_content_type", 415);
            exit();
        }

        $csrfHeader = $_SERVER["HTTP_X_CSRF_TOKEN"] ?? "";
        if (!hash_equals($_SESSION["csrf_token"] ?? "", $csrfHeader)) {
            JsonKit::fail("csrf_failed", 419);
            exit();
        }

        $data = json_decode(file_get_contents("php://input"), true) ?: [];

        $username = trim((string) ($data["username"] ?? ""));
        $password = (string) ($data["password"] ?? "");
        $branch = (string) ($data["branch"] ?? "");
        $shift = (string) ($data["shift"] ?? "");

        if (
            $username === "" ||
            $password === "" ||
            $branch === "" ||
            $shift === ""
        ) {
            JsonKit::fail("missing_fields", 422);
            exit();
        }

        $ip = $_SERVER["REMOTE_ADDR"] ?? "0.0.0.0";
        if ($this->tooManyAttempts($ip)) {
            JsonKit::fail("too_many_attempts", 429);
            exit();
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
            exit();
        }

        $this->clearAttempts($ip);

        session_regenerate_id(true);

        $_SESSION["waiter_user_id"] = (int) $user["id"];
        $_SESSION["waiter_role"] = (string) ($user["role"] ?? "user");
        $_SESSION["waiter_branch_id"] = $user["branch_id"] ?? $branch;
        $_SESSION["waiter_shift"] = $shift;
        $_SESSION["waiter_is_handheld"] = true;
        $_SESSION["waiter_login_at"] = time();
        $_SESSION["waiter_last_activity"] = time();
        $_SESSION["waiter_ua_hash"] = hash(
            "sha256",
            $_SERVER["HTTP_USER_AGENT"] ?? ""
        );
        $_SESSION["waiter_session_version"] =
            (string) ($user["session_version"] ?? "1");

        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

        JsonKit::success([
            "message" => "login_success",
            "redirect" => "/handheld/dashboard",
        ]);
        exit();
    }

    public function createOrder()
    {
        OrdersController::createOrder();
    }

    public function settle()
    {
        PaymentController::savePayment();
    }

    public function updateTableStatus($table_no)
    {
        TablesController::updateTableStatus($table_no);
    }

    public function getWaiters()
    {
        WaitersController::getWaiters($_SESSION["branch_id"]);
    }

    public static function getDashboardData(): void
    {
        try {
            $now = new \DateTimeImmutable("now");
            $curStart = $now
                ->modify("first day of this month")
                ->setTime(0, 0, 0);
            $nextStart = $curStart->modify("first day of next month");
            $prevStart = $curStart->modify("first day of last month");

            $revCur =
                (new \App\Core\DB("payments"))->query(
                    "SELECT COALESCE(SUM(amount),0) total
             FROM payments
             WHERE status='completed' AND created_at >= ? AND created_at < ?",
                    [
                        $curStart->format("Y-m-d H:i:s"),
                        $nextStart->format("Y-m-d H:i:s"),
                    ],
                    "array"
                )[0]["total"] ?? 0;

            $revPrev =
                (new \App\Core\DB("payments"))->query(
                    "SELECT COALESCE(SUM(amount),0) total
             FROM payments
             WHERE status='completed' AND created_at >= ? AND created_at < ?",
                    [
                        $prevStart->format("Y-m-d H:i:s"),
                        $curStart->format("Y-m-d H:i:s"),
                    ],
                    "array"
                )[0]["total"] ?? 0;

            $ordCur =
                (new \App\Core\DB("orders"))->query(
                    "SELECT COUNT(*) cnt FROM orders
             WHERE paid_at IS NOT NULL AND paid_at >= ? AND paid_at < ?",
                    [
                        $curStart->format("Y-m-d H:i:s"),
                        $nextStart->format("Y-m-d H:i:s"),
                    ],
                    "array"
                )[0]["cnt"] ?? 0;

            $ordPrev =
                (new \App\Core\DB("orders"))->query(
                    "SELECT COUNT(*) cnt FROM orders
             WHERE paid_at IS NOT NULL AND paid_at >= ? AND paid_at < ?",
                    [
                        $prevStart->format("Y-m-d H:i:s"),
                        $curStart->format("Y-m-d H:i:s"),
                    ],
                    "array"
                )[0]["cnt"] ?? 0;

            $waitCur =
                (new \App\Core\DB("orders"))->query(
                    "SELECT COUNT(DISTINCT user_id) c FROM orders
             WHERE user_id IS NOT NULL AND paid_at IS NOT NULL
               AND paid_at >= ? AND paid_at < ?",
                    [
                        $curStart->format("Y-m-d H:i:s"),
                        $nextStart->format("Y-m-d H:i:s"),
                    ],
                    "array"
                )[0]["c"] ?? 0;

            $waitPrev =
                (new \App\Core\DB("orders"))->query(
                    "SELECT COUNT(DISTINCT user_id) c FROM orders
             WHERE user_id IS NOT NULL AND paid_at IS NOT NULL
               AND paid_at >= ? AND paid_at < ?",
                    [
                        $prevStart->format("Y-m-d H:i:s"),
                        $curStart->format("Y-m-d H:i:s"),
                    ],
                    "array"
                )[0]["c"] ?? 0;

            echo \App\Utils\JsonKit::json(
                [
                    "monthlyRevenue" => (float) $revCur,
                    "monthlyRevenue_prev" => (float) $revPrev,

                    "monthlyOrders" => (int) $ordCur,
                    "monthlyOrders_prev" => (int) $ordPrev,

                    "waitersCount" => (int) $waitCur,
                    "waitersCount_prev" => (int) $waitPrev,

                    "workingWaiters" => (int) 1,
                    "workingWaiters_prev" => (int) 1,
                ],
                "Anasayfa verileri getirildi",
                200
            );
        } catch (\Throwable $e) {
            echo \App\Utils\JsonKit::fail("Hata: " . $e->getMessage(), 500);
        }
    }

    public function getRevenueTimeseries()
    {
        PaymentController::getRevenueTimeseries(
            null,
            null,
            $_SESSION["branch_id"]
        );
    }

    public function waiterOrders()
    {
        OrdersController::waiterOrders();
    }

    public function productBreakdown()
    {
        ProductsController::productBreakdown();
    }

    public function paymentMethods()
    {
        PaymentController::paymentMethods();
    }

    public function staffPerformance()
    {
        OrdersController::staffPerformance();
    }

    public static function getKPIStats(): void
    {
        try {
            $days = max(1, (int) ($_GET["days"] ?? 30));
            $branchId = isset($_GET["branchId"])
                ? (int) $_GET["branchId"]
                : null;

            $end = (new \DateTimeImmutable("tomorrow"))->setTime(0, 0, 0);
            $start = $end->modify("-{$days} days");

            $prevEnd = $start;
            $prevStart = $prevEnd->modify("-{$days} days");

            $paymentsWhere =
                "status='completed' AND created_at >= ? AND created_at < ?";
            $ordersWhere =
                "paid_at IS NOT NULL AND paid_at >= ? AND paid_at < ?";

            $payBind = [
                $start->format("Y-m-d H:i:s"),
                $end->format("Y-m-d H:i:s"),
            ];
            $ordBind = $payBind;

            $payPrev = [
                $prevStart->format("Y-m-d H:i:s"),
                $prevEnd->format("Y-m-d H:i:s"),
            ];
            $ordPrev = $payPrev;

            if ($branchId !== null) {
                $paymentsWhere .= " AND branch_id = ?";
                $ordersWhere .= " AND branch_id = ?";

                $payBind[] = $branchId;
                $ordBind[] = $branchId;

                $payPrev[] = $branchId;
                $ordPrev[] = $branchId;
            }

            // ---- CURRENT
            $revenue =
                (new DB("payments"))->query(
                    "SELECT COALESCE(SUM(amount),0) AS t FROM payments WHERE $paymentsWhere",
                    $payBind,
                    "array"
                )[0]["t"] ?? 0;

            $orders =
                (new DB("orders"))->query(
                    "SELECT COUNT(*) AS c FROM orders WHERE $ordersWhere",
                    $ordBind,
                    "array"
                )[0]["c"] ?? 0;

            $revenue = round((float) $revenue, 2);
            $orders = (int) $orders;
            $aov = $orders > 0 ? round($revenue / $orders, 2) : 0.0;

            // ---- PREVIOUS (delta için)
            $revenuePrev =
                (new DB("payments"))->query(
                    "SELECT COALESCE(SUM(amount),0) AS t FROM payments WHERE $paymentsWhere",
                    $payPrev,
                    "array"
                )[0]["t"] ?? 0;

            $ordersPrev =
                (new DB("orders"))->query(
                    "SELECT COUNT(*) AS c FROM orders WHERE $ordersWhere",
                    $ordPrev,
                    "array"
                )[0]["c"] ?? 0;

            $revenuePrev = round((float) $revenuePrev, 2);
            $ordersPrev = (int) $ordersPrev;
            $aovPrev =
                $ordersPrev > 0 ? round($revenuePrev / $ordersPrev, 2) : 0.0;

            // ---- % Değişim
            $pct = function ($cur, $prev) {
                $cur = (float) $cur;
                $prev = (float) $prev;
                if ($prev == 0) {
                    return $cur > 0 ? 100.0 : 0.0;
                }
                return round((($cur - $prev) / $prev) * 100, 1);
            };

            $resp = [
                "range" => [
                    $start->format("Y-m-d"),
                    $end->modify("-1 day")->format("Y-m-d"),
                ],
                "prev_range" => [
                    $prevStart->format("Y-m-d"),
                    $prevEnd->modify("-1 day")->format("Y-m-d"),
                ],
                "currency" => "TRY",
                "totals" => [
                    "revenue" => $revenue,
                    "orders" => $orders,
                    "avg_order_value" => $aov,
                ],
                "previous" => [
                    "revenue" => $revenuePrev,
                    "orders" => $ordersPrev,
                    "avg_order_value" => $aovPrev,
                ],
                "deltas" => [
                    "revenue_pct" => $pct($revenue, $revenuePrev),
                    "orders_pct" => $pct($orders, $ordersPrev),
                    "avg_pct" => $pct($aov, $aovPrev),
                ],
                "days" => $days,
                "branchId" => $branchId,
            ];

            echo JsonKit::json($resp, "KPI stats", 200);
        } catch (\Throwable $e) {
            echo JsonKit::fail("Hata: " . $e->getMessage(), 500);
        }
    }

    public function revenueByCategory()
    {
        PaymentController::revenueByCategory();
    }

    public function revenueByTable()
    {
        PaymentController::revenueByTable();
    }

    public function getAllUsers()
    {
        echo JsonKit::json(User::all(), "Kullanıcılar getirildi");
    }

    public function getBusinessHours(){
        BusinessHoursController::getBusinessHours();
    }

    public function getBranchHolidays(){
        BranchHolidaysController::getBranchHolidays();
    }

    public function saveSettings(){
        SettingsController::saveSettings();
    }
}
