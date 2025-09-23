<?php

namespace App\Controllers;

use App\Core\DB;
use App\Services\PrinterRouting;
use App\Services\TicketTemplate;
use App\Utils\JsonKit;
use RuntimeException;

class PrinterController
{
    public function index(): void
    {
        try {
            $db = new DB("printers");
            $pdo = $db->getConnection();
            $stmt = $pdo->query(
                'SELECT p.*, ps.name AS station_name, ps.branch_id AS station_branch_id FROM printers p LEFT JOIN prep_stations ps ON ps.id = p.station_id ORDER BY COALESCE(p.name, "") ASC, p.id ASC'
            );
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $items = [];
            foreach ($rows as $row) {
                $items[] = [
                    "id" => isset($row["id"]) ? (int) $row["id"] : null,
                    "name" => $row["name"] ?? "Printer #" . ($row["id"] ?? "?"),
                    "station_id" => isset($row["station_id"])
                        ? (int) $row["station_id"]
                        : null,
                    "station_name" => $row["station_name"] ?? null,
                    "branch_id" => isset($row["branch_id"])
                        ? (int) $row["branch_id"]
                        : (isset($row["station_branch_id"])
                            ? (int) $row["station_branch_id"]
                            : null),
                    "connector" => $row["connector"] ?? null,
                    "host" => $row["host"] ?? null,
                    "port" => $row["port"] ?? null,
                    "is_active" => isset($row["is_active"])
                        ? (int) $row["is_active"]
                        : null,
                ];
            }

            JsonKit::json(["items" => $items], "Printers listed", 200);
        } catch (\Throwable $e) {
            JsonKit::fail("Yazici listesi alinamadi: " . $e->getMessage(), 500);
        }
    }

    public function testPrint($printerId): void
    {
        $printerId = (int) $printerId;
        if ($printerId <= 0) {
            JsonKit::fail("Gecersiz yazici kimligi", 422);
            return;
        }

        try {
            $printerDb = new DB("printers");
            $printer = $printerDb->where("id", $printerId)->first();
            if (!$printer) {
                JsonKit::fail("Yazici bulunamadi", 404);
                return;
            }

            $pdo = $printerDb->getConnection();
            $stationId = isset($printer["station_id"])
                ? (int) $printer["station_id"]
                : 0;
            if ($stationId <= 0) {
                JsonKit::fail("Yazici icin bagli istasyon bulunamadi", 422);
                return;
            }

            $branchId = isset($printer["branch_id"])
                ? (int) $printer["branch_id"]
                : 0;
            if ($branchId <= 0) {
                $stmt = $pdo->prepare(
                    "SELECT branch_id FROM prep_stations WHERE id = :id LIMIT 1"
                );
                $stmt->execute([":id" => $stationId]);
                $branchId = (int) ($stmt->fetchColumn() ?: 0);
            }
            if ($branchId <= 0) {
                JsonKit::fail("Yazicinin subesi cozumlenemedi", 422);
                return;
            }

            $jobId = PrinterRouting::queueStationTicket(
                $pdo,
                $branchId,
                0,
                $stationId,
                [
                    ["name" => "Test Icecek", "qty" => 1, "note" => "Demo fis"],
                    ["name" => "Test Tatli", "qty" => 1, "note" => ""],
                ],
                "TEST"
            );

            JsonKit::json(
                ["job_id" => $jobId],
                "Test fisi kuyruga alindi",
                200
            );
        } catch (RuntimeException $e) {
            JsonKit::fail("Fis kuyruga eklenemedi: " . $e->getMessage(), 500);
        } catch (\Throwable $e) {
            JsonKit::fail("Test fisi gonderilemedi: " . $e->getMessage(), 500);
        }
    }

    public function getTemplate(): void
    {
        try {
            $template = TicketTemplate::getTemplate($_SESSION['branch_id']);
            JsonKit::json(
                [
                    "template" => $template,
                    "defaults" => TicketTemplate::getDefault(),
                    "preview" => TicketTemplate::generatePreview($template),
                ],
                "Fis sablonu",
                200
            );
        } catch (\Throwable $e) {
            JsonKit::fail("Fis sablonu alinamadi: " . $e->getMessage(), 500);
        }
    }

    public function updateTemplate(): void
    {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!is_array($input)) {
            JsonKit::fail("Gecersiz veri gonderildi", 422);
            return;
        }

        try {
            $template = TicketTemplate::saveTemplate($input, $_SESSION['branch_id']);
            JsonKit::json(
                [
                    "template" => $template,
                    "preview" => TicketTemplate::generatePreview($template),
                ],
                "Fis sablonu guncellendi",
                200
            );
        } catch (RuntimeException $e) {
            JsonKit::fail($e->getMessage(), 422);
        } catch (\Throwable $e) {
            JsonKit::fail(
                "Fis sablonu kaydedilemedi: " . $e->getMessage(),
                500
            );
        }
    }

    public function previewTemplate(): void
    {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!is_array($input)) {
            $input = [];
        }

        try {
            $preview = TicketTemplate::generatePreview($input);
            JsonKit::json(["preview" => $preview], "Fis sablonu onizleme", 200);
        } catch (\Throwable $e) {
            JsonKit::fail(
                "Fis sablonu onizleme olusturulamadi: " . $e->getMessage(),
                500
            );
        }
    }
}
