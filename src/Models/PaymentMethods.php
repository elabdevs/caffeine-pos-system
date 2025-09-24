<?php

namespace App\Models;

use App\Core\DB;
use Exception;

class PaymentMethods
{
    public static function save($data)
    {
        if (!isset($data['payment_methods']) || !is_array($data['payment_methods'])) {
            return false;
        }

        try {
            foreach ($data['payment_methods'] as $code => $active) {
                DB::table('payment_methods')
                    ->where('code', $code)
                    ->update([
                        'is_system_active' => $active ? 1 : 0,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            }
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage(), (int) $e->getCode(), $e);
        }

        return true;
    }
}
