<?php

namespace App\Services;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\PrintConnector;
use RuntimeException;

class PrintManager
{
    public function printTicket(array $payload): void
    {
        $connectorType = strtolower((string) ($payload['connector'] ?? $payload['mode'] ?? $this->env('PRINTER_MODE', 'network')));
        $host = (string) ($payload['host'] ?? $this->env('PRINTER_HOST', '127.0.0.1'));
        $port = (int) ($payload['port'] ?? $this->env('PRINTER_PORT', 9100));
        $timeout = (int) ($payload['timeout'] ?? $this->env('PRINTER_TIMEOUT', 3));

        $ticket = $payload['payload_json'] ?? $payload['payload'] ?? null;
        if (is_string($ticket)) {
            $decoded = json_decode($ticket, true);
            $ticket = is_array($decoded) ? $decoded : null;
        }

        if (!is_array($ticket)) {
            throw new RuntimeException('Print payload missing or invalid.');
        }

        $connector = $this->createConnector($connectorType, $host, $port, $timeout, $payload);
        $printer = new Printer($connector);

        try {
            $printer->initialize();
            $template = TicketTemplate::getTemplate();
            $this->renderTicket($printer, $ticket, $template, (int) ($payload['branch_id'] ?? 0));
            $printer->cut();
        } finally {
            try {
                $printer->close();
            } catch (\Throwable $e) {
                // no-op
            }
        }
    }

    private function createConnector(string $type, string $host, int $port, int $timeout, array $payload): PrintConnector
    {
        switch ($type) {
            case 'dummy':
                return new DummyPrintConnector();
            case 'cups':
                $printerName = (string) ($payload['printer_name'] ?? $host ?? 'Printer');
                $profile = $payload['cups_profile'] ?? [];
                if (!is_array($profile)) {
                    $profile = [$profile];
                }
                return new CupsPrintConnector($printerName, $profile);
            case 'network':
            default:
                return new NetworkPrintConnector($host, $port, $timeout);
        }
    }

    private function renderTicket(Printer $printer, array $ticket, array $template, int $branchId = 0): void
    {
        $lineWidth = $this->sanitizeLineWidth($template['line_width'] ?? 32);
        $meta = is_array($ticket['meta'] ?? null) ? $ticket['meta'] : [];
        $meta['table'] = $ticket['table'] ?? ($meta['table'] ?? '');
        if (!isset($meta['branch_id']) && $branchId > 0) {
            $meta['branch_id'] = $branchId;
        }

        $title = (string) ($template['title'] ?? ($ticket['title'] ?? ''));
        if ($title === '') {
            $title = (string) ($ticket['title'] ?? 'Ticket');
        }
        if (!empty($template['uppercase_title'])) {
            $title = mb_strtoupper($title, 'UTF-8');
        }

        if ($title !== '') {
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $this->printWrapped($printer, $title, $lineWidth);
            $printer->setEmphasis(false);
        }

        $headerLines = $template['header_lines'] ?? [];
        if ($headerLines) {
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            foreach ($headerLines as $line) {
                $this->printWrapped($printer, (string) $line, $lineWidth);
            }
        }

        if (!empty($template['show_table']) && !empty($meta['table'])) {
            $label = $template['table_label'] ?? 'Masa';
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->printWrapped($printer, sprintf('%s: %s', $label, $meta['table']), $lineWidth);
        }

        $items = is_array($ticket['items'] ?? null) ? $ticket['items'] : [];
        if ($items) {
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            foreach ($items as $item) {
                $name = (string) ($item['name'] ?? '');
                $qtyValue = $item['qty'] ?? ($item['quantity'] ?? 1);
                $qty = (float) (is_numeric($qtyValue) ? $qtyValue : 1);
                $note = trim((string) ($item['note'] ?? ''));

                $context = [
                    'name'       => $name,
                    'qty'        => $this->formatQuantity($qty),
                    'qty_raw'    => $qty,
                    'note'       => $note,
                    'table'      => $meta['table'] ?? '',
                    'order_id'   => $meta['order_id'] ?? '',
                    'station_id' => $meta['station_id'] ?? '',
                    'branch_id'  => $meta['branch_id'] ?? '',
                ];

                $line = $this->applyFormat($template['item_format'] ?? '{qty} x {name}', $context);
                $this->printWrapped($printer, $line, $lineWidth);

                if ($note !== '' && ($template['note_format'] ?? '') !== '') {
                    $noteLine = $this->applyFormat($template['note_format'], $context);
                    $this->printWrapped($printer, $noteLine, $lineWidth);
                }

                $printer->text("\n");
            }
        }

        $footerLines = $template['footer_lines'] ?? [];
        $footerPayload = trim((string) ($ticket['footer'] ?? ''));
        if ($footerPayload !== '') {
            $footerLines[] = $footerPayload;
        }
        if ($footerLines) {
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            foreach ($footerLines as $line) {
                $this->printWrapped($printer, (string) $line, $lineWidth);
            }
        }

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->feed(1);
    }

    private function printWrapped(Printer $printer, string $text, int $lineWidth): void
    {
        $chunks = $this->wrapText($text, $lineWidth);
        foreach ($chunks as $chunk) {
            $printer->text($chunk . "\n");
        }
    }

    private function wrapText(string $text, int $lineWidth): array
    {
        $lines = preg_split("/\r?\n/", $text) ?: [''];
        $output = [];
        foreach ($lines as $line) {
            if ($line === '') {
                $output[] = '';
                continue;
            }
            $wrapped = wordwrap($line, $lineWidth, "\n", true);
            $output = array_merge($output, explode("\n", $wrapped));
        }
        if ($output === []) {
            $output[] = '';
        }
        return $output;
    }

    private function applyFormat(string $format, array $context): string
    {
        $replacements = [];
        foreach ($context as $key => $value) {
            $replacements['{' . $key . '}'] = (string) $value;
        }
        return strtr($format, $replacements);
    }

    private function formatQuantity(float $qty): string
    {
        $rounded = round($qty, 3);
        $text = rtrim(rtrim(number_format($rounded, 3, '.', ''), '0'), '.');
        return $text === '' ? '1' : $text;
    }

    private function sanitizeLineWidth($value): int
    {
        if (!is_numeric($value)) {
            return 32;
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

    private function env(string $key, $default = null)
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        return $value !== false && $value !== null ? $value : $default;
    }
}
