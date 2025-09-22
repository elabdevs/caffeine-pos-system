<?php

namespace App\Services;

use App\Core\DB;
use RuntimeException;

class TicketTemplate
{
    private const SETTING_KEY = 'print_ticket_template';

    private static array $default = [
        'version'         => 1,
        'line_width'      => 32,
        'title'           => 'CAFFEINE',
        'uppercase_title' => true,
        'header_lines'    => ['--------------------------------'],
        'show_table'      => true,
        'table_label'     => 'Masa',
        'item_format'     => '{qty} x {name}',
        'note_format'     => '  Not: {note}',
        'footer_lines'    => ['Afiyet olsun'],
    ];

    public static function getDefault(): array
    {
        return self::$default;
    }

    public static function getTemplate(): array
    {
        $row = DB::table('settings')->where('skey', self::SETTING_KEY)->first();
        if (!$row || empty($row['svalue'])) {
            return self::$default;
        }

        $decoded = json_decode((string) $row['svalue'], true);
        if (!is_array($decoded)) {
            return self::$default;
        }

        return self::mergeWithDefault($decoded);
    }

    public static function saveTemplate(array $input): array
    {
        $normalized = self::mergeWithDefault($input);
        $encoded = json_encode($normalized, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($encoded === false) {
            throw new RuntimeException('Sablon kaydedilemedi.');
        }

        $settings = DB::table('settings');
        $existing = $settings->where('skey', self::SETTING_KEY)->first();
        if ($existing) {
            DB::table('settings')
                ->where('id', (int) $existing['id'])
                ->update(['svalue' => $encoded]);
        } else {
            DB::table('settings')->insert([
                'skey'   => self::SETTING_KEY,
                'svalue' => $encoded,
            ]);
        }

        return $normalized;
    }

    public static function generatePreview(array $input): array
    {
        $template = self::mergeWithDefault($input);
        $lineWidth = self::sanitizeLineWidth($template['line_width'] ?? 32);

        $meta = [
            'table'        => 'A12',
            'order_id'     => 'ORD-1024',
            'station_id'   => 'ST-01',
            'station_name' => 'Bar',
            'branch_id'    => 'BR-01',
        ];

        $items = [
            ['name' => 'Latte', 'qty' => 2, 'note' => 'Soya sutlu'],
            ['name' => 'Cheesecake', 'qty' => 1, 'note' => ''],
            ['name' => 'Cold Brew', 'qty' => 1, 'note' => 'Sekersiz'],
        ];

        return self::buildPreviewLines($template, $items, $meta, $lineWidth);
    }

    private static function mergeWithDefault(array $input): array
    {
        $template = self::$default;

        $template['title'] = self::sanitizeString($input['title'] ?? $template['title']);
        $template['uppercase_title'] = self::toBool($input['uppercase_title'] ?? $template['uppercase_title']);
        $template['header_lines'] = self::toStringArray($input['header_lines'] ?? $template['header_lines']);
        $template['show_table'] = self::toBool($input['show_table'] ?? $template['show_table']);
        $template['table_label'] = self::sanitizeString($input['table_label'] ?? $template['table_label']);
        $template['item_format'] = self::sanitizeFormat($input['item_format'] ?? $template['item_format'], '{qty} x {name}');
        $template['note_format'] = self::sanitizeFormat($input['note_format'] ?? $template['note_format'], '  Not: {note}', allowEmpty: true);
        $template['footer_lines'] = self::toStringArray($input['footer_lines'] ?? $template['footer_lines']);
        $template['line_width'] = self::sanitizeLineWidth($input['line_width'] ?? $template['line_width']);

        return $template;
    }

    private static function sanitizeString($value): string
    {
        $value = is_string($value) ? trim($value) : '';
        if ($value === '') {
            return '';
        }
        return self::limitLength($value, 128);
    }

    private static function toBool($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        if (is_string($value)) {
            return in_array(strtolower($value), ['1', 'true', 'on', 'yes'], true);
        }
        if (is_numeric($value)) {
            return (int) $value === 1;
        }
        return false;
    }

    private static function toStringArray($value): array
    {
        if (is_string($value)) {
            $value = explode("\n", $value);
        }
        if (!is_array($value)) {
            return [];
        }
        $result = [];
        foreach ($value as $item) {
            if (!is_string($item)) {
                continue;
            }
            $trimmed = trim($item);
            if ($trimmed !== '') {
                $result[] = self::limitLength($trimmed, 128);
            }
        }
        return $result;
    }

    private static function sanitizeFormat($value, string $fallback, bool $allowEmpty = false): string
    {
        $value = is_string($value) ? trim($value) : '';
        if ($value === '') {
            return $allowEmpty ? '' : $fallback;
        }
        return self::limitLength($value, 160);
    }

    private static function sanitizeLineWidth($value): int
    {
        if (!is_numeric($value)) {
            return self::$default['line_width'];
        }
        $width = (int) $value;
        if ($width < 16) {
            $width = 16;
        }
        if ($width > 64) {
            $width = 64;
        }
        return $width;
    }

    private static function buildPreviewLines(array $template, array $items, array $meta, int $lineWidth): array
    {
        $lines = [];

        $title = (string) ($template['title'] ?? '');
        if ($title !== '') {
            if (!empty($template['uppercase_title'])) {
                $title = self::uppercase($title);
            }
            foreach (self::wrapText($title, $lineWidth) as $chunk) {
                $lines[] = self::centerLine($chunk, $lineWidth);
            }
        }

        $headerLines = $template['header_lines'] ?? [];
        foreach ($headerLines as $headerLine) {
            foreach (self::wrapText((string) $headerLine, $lineWidth) as $chunk) {
                $lines[] = self::centerLine($chunk, $lineWidth);
            }
        }

        if (!empty($template['show_table'])) {
            $tableValue = trim((string) ($meta['table'] ?? ''));
            if ($tableValue !== '') {
                $label = $template['table_label'] ?? 'Masa';
                $tableText = sprintf('%s: %s', $label, $tableValue);
                foreach (self::wrapText($tableText, $lineWidth) as $chunk) {
                    $lines[] = $chunk;
                }
            }
        }

        if ($lines !== [] && $items !== []) {
            $lines[] = '';
        }

        $totalItems = count($items);
        foreach ($items as $index => $item) {
            $name = (string) ($item['name'] ?? '');
            $qtyValue = $item['qty'] ?? ($item['quantity'] ?? 1);
            $qty = (float) (is_numeric($qtyValue) ? $qtyValue : 1);
            $note = trim((string) ($item['note'] ?? ''));

            $context = [
                'name'         => $name,
                'qty'          => self::formatQuantity($qty),
                'qty_raw'      => $qty,
                'note'         => $note,
                'table'        => $meta['table'] ?? '',
                'order_id'     => $meta['order_id'] ?? '',
                'station_id'   => $meta['station_id'] ?? '',
                'station_name' => $meta['station_name'] ?? '',
                'branch_id'    => $meta['branch_id'] ?? '',
            ];

            $itemLine = self::applyFormat($template['item_format'] ?? '{qty} x {name}', $context);
            foreach (self::wrapText($itemLine, $lineWidth) as $chunk) {
                $lines[] = $chunk;
            }

            if ($note !== '' && ($template['note_format'] ?? '') !== '') {
                $noteLine = self::applyFormat($template['note_format'], $context);
                foreach (self::wrapText($noteLine, $lineWidth) as $chunk) {
                    $lines[] = $chunk;
                }
            }

            if ($index < $totalItems - 1) {
                $lines[] = '';
            }
        }

        $footerLines = $template['footer_lines'] ?? [];
        if ($footerLines) {
            if ($lines !== [] && end($lines) !== '') {
                $lines[] = '';
            }
            foreach ($footerLines as $footerLine) {
                foreach (self::wrapText((string) $footerLine, $lineWidth) as $chunk) {
                    $lines[] = self::centerLine($chunk, $lineWidth);
                }
            }
        }

        return array_map(static fn (string $line) => rtrim($line), $lines);
    }

    private static function wrapText(string $text, int $lineWidth): array
    {
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $parts = explode("\n", $text);
        $output = [];
        foreach ($parts as $part) {
            $part = trim($part);
            if ($part === '') {
                $output[] = '';
                continue;
            }
            $wrapped = wordwrap($part, $lineWidth, "\n", true);
            $output = array_merge($output, explode("\n", $wrapped));
        }
        return $output === [] ? [''] : $output;
    }

    private static function centerLine(string $line, int $lineWidth): string
    {
        $length = self::stringLength($line);
        if ($length >= $lineWidth) {
            return $line;
        }
        $pad = $lineWidth - $length;
        $left = intdiv($pad, 2);
        $right = $pad - $left;
        return str_repeat(' ', $left) . $line . str_repeat(' ', $right);
    }

    private static function applyFormat(string $format, array $context): string
    {
        $replacements = [];
        foreach ($context as $key => $value) {
            $replacements['{' . $key . '}'] = (string) $value;
        }
        return strtr($format, $replacements);
    }

    private static function formatQuantity(float $qty): string
    {
        $rounded = round($qty, 3);
        $text = rtrim(rtrim(number_format($rounded, 3, '.', ''), '0'), '.');
        return $text === '' ? '1' : $text;
    }

    private static function uppercase(string $value): string
    {
        return function_exists('mb_strtoupper') ? mb_strtoupper($value, 'UTF-8') : strtoupper($value);
    }

    private static function stringLength(string $value): int
    {
        return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
    }

    private static function limitLength(string $value, int $limit): string
    {
        if ($limit <= 0) {
            return $value;
        }
        if (function_exists('mb_substr')) {
            return mb_substr($value, 0, $limit);
        }
        return substr($value, 0, $limit);
    }
}
