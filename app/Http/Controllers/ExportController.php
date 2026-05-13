<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\MaintenanceLog;
use App\Models\OpdLocation;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportDevicesPdf(Request $request)
    {
        $query = Device::with('opdLocation');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }
        if ($request->filled('opd_location_id')) {
            $query->where('opd_location_id', $request->opd_location_id);
        }
        if ($request->filled('lokasi')) {
            $query->where('lokasi_pemasangan', $request->lokasi);
        }

        $devices = $query->orderBy('merk')->get();
        $location = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;

        $pdf = Pdf::loadView('exports.devices-pdf', compact('devices', 'location'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-perangkat-' . date('Y-m-d') . '.pdf');
    }

    public function exportDevicesExcel(Request $request)
    {
        $query = Device::with('opdLocation');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }
        if ($request->filled('opd_location_id')) {
            $query->where('opd_location_id', $request->opd_location_id);
        }
        if ($request->filled('lokasi')) {
            $query->where('lokasi_pemasangan', $request->lokasi);
        }

        $devices = $query->orderBy('merk')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Perangkat');

        // Header
        $headers = ['No', 'Merk', 'Tipe', 'Model', 'Nomor Seri', 'IP Address', 'Status', 'Lokasi OPD', 'Lokasi Pemasangan', 'Tanggal Install', 'Keterangan'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Style header
        $headerRange = 'A1:K1';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('334155');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Data
        $row = 2;
        foreach ($devices as $index => $device) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $device->merk);
            $sheet->setCellValue('C' . $row, $device->tipe);
            $sheet->setCellValue('D' . $row, $device->model);
            $sheet->setCellValue('E' . $row, $device->nomor_seri);
            $sheet->setCellValue('F' . $row, $device->ip_address);
            $sheet->setCellValue('G' . $row, $device->status);
            $sheet->setCellValue('H' . $row, $device->opdLocation->nama ?? '-');
            $sheet->setCellValue('I' . $row, $device->lokasi_pemasangan);
            $sheet->setCellValue('J' . $row, $device->tanggal_install ? $device->tanggal_install->format('d/m/Y') : '-');
            $sheet->setCellValue('K' . $row, $device->keterangan);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'K') as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        // Border
        $dataRange = 'A1:K' . ($row - 1);
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Include Denah if filtered by location
        if ($request->filled('opd_location_id')) {
            $location = OpdLocation::find($request->opd_location_id);
            if ($location && $location->denah_file) {
                $denahPath = storage_path('app/public/' . $location->denah_file);
                $ext = strtolower(pathinfo($denahPath, PATHINFO_EXTENSION));
                if (file_exists($denahPath) && in_array($ext, ['jpg', 'jpeg', 'png'])) {
                    $row += 1;
                    $sheet->setCellValue('A' . $row, 'DENAH GEDUNG / RUANGAN (' . $location->nama . ')');
                    $sheet->getStyle('A' . $row)->getFont()->setBold(true);
                    
                    $drawing = new Drawing();
                    $drawing->setName('Denah');
                    $drawing->setPath($denahPath);
                    $drawing->setHeight(300);
                    $drawing->setCoordinates('A' . ($row + 1));
                    $drawing->setWorksheet($sheet);
                }
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-perangkat-' . date('Y-m-d') . '.xlsx';
        $tempFile = storage_path('app/' . $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    public function exportMaintenancePdf(Request $request)
    {
        $query = MaintenanceLog::with(['device.opdLocation', 'user']);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $logs = $query->orderBy('tanggal', 'desc')->get();

        $pdf = Pdf::loadView('exports.maintenance-pdf', compact('logs'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-maintenance-' . date('Y-m-d') . '.pdf');
    }

    public function exportMaintenanceExcel(Request $request)
    {
        $query = MaintenanceLog::with(['device.opdLocation', 'user']);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $logs = $query->orderBy('tanggal', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Log Maintenance');

        $headers = ['No', 'Perangkat', 'Lokasi', 'Jenis', 'Deskripsi', 'Tanggal', 'Biaya', 'Status', 'Teknisi', 'Catatan'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        $headerRange = 'A1:J1';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('334155');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $row = 2;
        foreach ($logs as $index => $log) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, ($log->device->merk ?? '') . ' - ' . ($log->device->nomor_seri ?? ''));
            $sheet->setCellValue('C' . $row, $log->device->opdLocation->nama ?? '-');
            $sheet->setCellValue('D' . $row, $log->jenis);
            $sheet->setCellValue('E' . $row, $log->deskripsi);
            $sheet->setCellValue('F' . $row, $log->tanggal->format('d/m/Y'));
            $sheet->setCellValue('G' . $row, $log->biaya ? 'Rp ' . number_format($log->biaya, 0, ',', '.') : '-');
            $sheet->setCellValue('H' . $row, $log->status);
            $sheet->setCellValue('I' . $row, $log->user->name ?? '-');
            $sheet->setCellValue('J' . $row, $log->catatan);
            $row++;
        }

        foreach (range('A', 'J') as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        $dataRange = 'A1:J' . ($row - 1);
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-maintenance-' . date('Y-m-d') . '.xlsx';
        $tempFile = storage_path('app/' . $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    public function printDevices(Request $request)
    {
        $query = Device::with('opdLocation');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }
        if ($request->filled('opd_location_id')) {
            $query->where('opd_location_id', $request->opd_location_id);
        }
        if ($request->filled('lokasi')) {
            $query->where('lokasi_pemasangan', $request->lokasi);
        }

        $devices = $query->orderBy('merk')->get();
        $location = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;

        return view('exports.devices-print', compact('devices', 'location'));
    }

    public function printMaintenance(Request $request)
    {
        $query = MaintenanceLog::with(['device.opdLocation', 'user']);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $logs = $query->orderBy('tanggal', 'desc')->get();
        return view('exports.maintenance-print', compact('logs'));
    }
}
