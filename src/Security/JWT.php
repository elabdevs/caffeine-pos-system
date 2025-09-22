<?php
namespace App\Security;

final class JWT
{
    private static function b64uEnc(string $s): string {
        return rtrim(strtr(base64_encode($s), '+/', '-_'), '=');
    }
    private static function b64uDec(string $s): string {
        $pad = (4 - strlen($s) % 4) % 4;
        return base64_decode(strtr($s . str_repeat('=', $pad), '-_', '+/'));
    }

    public static function create(array $claims, int $ttl, string $secret, array $std = []): string
    {
        $now = time();

        $header  = ['alg' => 'HS256', 'typ' => 'JWT'];
        $defaults = [
            'iat' => $now,
            'exp' => $now + $ttl,
            'jti' => bin2hex(random_bytes(8)),
        ];
        $payload = array_merge($defaults, $std, $claims);

        $h = self::b64uEnc(json_encode($header,  JSON_UNESCAPED_SLASHES));
        $p = self::b64uEnc(json_encode($payload, JSON_UNESCAPED_SLASHES));
        $sig = hash_hmac('sha256', "$h.$p", $secret, true);
        $s = self::b64uEnc($sig);

        return "$h.$p.$s";
    }

    public static function verify(string $jwt, string $secret, int $leeway = 60): array
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return ['valid' => false, 'error' => 'malformed'];
        }
        [$h64, $p64, $s64] = $parts;

        $header  = json_decode(self::b64uDec($h64), true);
        $payload = json_decode(self::b64uDec($p64), true);
        $sig     = self::b64uDec($s64);

        if (!is_array($header) || ($header['alg'] ?? null) !== 'HS256') {
            return ['valid' => false, 'error' => 'alg_not_allowed'];
        }
        if (!is_array($payload) || !is_string($sig)) {
            return ['valid' => false, 'error' => 'decode_failed'];
        }

        $expected = hash_hmac('sha256', "$h64.$p64", $secret, true);
        if (!hash_equals($expected, $sig)) {
            return ['valid' => false, 'error' => 'signature_invalid'];
        }

        $now = time();
        if (isset($payload['nbf']) && $payload['nbf'] > $now + $leeway) {
            return ['valid' => false, 'error' => 'not_before'];
        }
        if (isset($payload['iat']) && $payload['iat'] > $now + $leeway) {
            return ['valid' => false, 'error' => 'issued_in_future'];
        }
        if (isset($payload['exp']) && $payload['exp'] < $now - $leeway) {
            return ['valid' => false, 'error' => 'expired'];
        }

        return ['valid' => true, 'payload' => $payload];
    }
}
