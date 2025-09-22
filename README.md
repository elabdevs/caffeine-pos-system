# Caffeine POS Printing

This project now includes an end-to-end print queue that fans out orders to preparation stations and dispatches tickets to configured printers. Tickets can be tested locally via a lightweight ESC/POS emulator.

## Printer Emulator & Worker

1. Start the Node.js ESC/POS emulator:
   ```
   node printer-emulator/printer-emulator.js
   ```
2. In another terminal, run the PHP print worker:
   ```
   php bin/print_worker.php
   ```
3. (Optional) Queue a demo ticket:
   ```
   php bin/demo_print.php
   ```

When an order is created, the system groups items per station, enqueues jobs in `print_jobs`, and the worker prints them via `mike42/escpos-php`. Emulator output is saved under `printer-emulator/_prints/`.

## Environment

The following `.env` keys control default printer connection settings:

```
PRINTER_MODE=network
PRINTER_HOST=127.0.0.1
PRINTER_PORT=9100
PRINTER_TIMEOUT=3
```

Defaults fallback to the values above when the keys are missing.

## Admin UI

The **Printers** section in `settings/hardware` now lists configured devices and exposes a *Test Fisi* button that pushes a print job through the same queue handled by the worker.

## Ticket Template Editor

Visit the **Fis Sablonu** card on the hardware settings page to customise the header/footer lines, line width, item and note formats. The editor stores the layout in the `settings` table (`skey=print_ticket_template`) and every job rendered by the worker honours your configuration. You can always roll back to the defaults via the "Varsayilani yukle" button. A live preview on the hardware page shows the ticket using placeholder items so you can adjust without printing.