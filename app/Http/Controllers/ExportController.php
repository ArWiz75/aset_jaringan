<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceProposal;
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
    // ===== PRIVATE HELPERS: Menghilangkan duplikasi filter query =====

    /**
     * Bangun query Device berdasarkan filter request yang sama
     * (dipakai oleh exportDevicesPdf, exportDevicesExcel, printDevices).
     */
    private function buildDeviceQuery(Request $request)
    {
        $query = Device::with('opdLocation:id,nama');

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

        return $query;
    }

    /**
     * Bangun query Device penggantian berdasarkan filter request.
     * (dipakai oleh printReplacement, exportReplacementPdf, exportReplacementExcel)
     */
    private function buildReplacementQuery(Request $request)
    {
        $query = Device::with('opdLocation:id,nama');

        $status = $request->filled('status') ? $request->status : 'Perlu Diganti';
        $query->where('status', $status);

        if ($request->filled('opd_location_id')) {
            $query->where('opd_location_id', $request->opd_location_id);
        }
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        return $query;
    }

    /**
     * Bangun query MaintenanceLog berdasarkan filter request.
     * (dipakai oleh exportMaintenancePdf, exportMaintenanceExcel, printMaintenance)
     */
    private function buildMaintenanceQuery(Request $request)
    {
        $query = MaintenanceLog::with(['device:id,merk,nomor_seri,opd_location_id', 'device.opdLocation:id,nama', 'user:id,name']);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query;
    }

    /**
     * Bangun query DeviceProposal berdasarkan filter request.
     * (dipakai oleh printProposal, exportProposalPdf, exportProposalExcel)
     */
    private function buildProposalQuery(Request $request)
    {
        $query = DeviceProposal::with('opdLocation:id,nama');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('urgensi')) {
            $query->where('urgensi', $request->urgensi);
        }
        if ($request->filled('opd_location_id')) {
            $query->where('opd_location_id', $request->opd_location_id);
        }
        if ($request->filled('tipe_perangkat')) {
            $query->where('tipe_perangkat', $request->tipe_perangkat);
        }

        return $query;
    }

    // ===== DEVICES =====

    public function exportDevicesPdf(Request $request)
    {
        $devices  = $this->buildDeviceQuery($request)->orderBy('merk')->get();
        $location = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;

        $pdf = Pdf::loadView('exports.devices-pdf', compact('devices', 'location'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-perangkat-' . date('Y-m-d') . '.pdf');
    }

    public function exportDevicesExcel(Request $request)
    {
        $devices = $this->buildDeviceQuery($request)->orderBy('merk')->get();

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
        $logs = $this->buildMaintenanceQuery($request)->orderBy('tanggal', 'desc')->get();

        $pdf = Pdf::loadView('exports.maintenance-pdf', compact('logs'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-maintenance-' . date('Y-m-d') . '.pdf');
    }

    public function exportMaintenanceExcel(Request $request)
    {
        $logs = $this->buildMaintenanceQuery($request)->orderBy('tanggal', 'desc')->get();

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
        $devices  = $this->buildDeviceQuery($request)->orderBy('merk')->get();
        $location = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;

        return view('exports.devices-print', compact('devices', 'location'));
    }

    public function printMaintenance(Request $request)
    {
        $logs = $this->buildMaintenanceQuery($request)->orderBy('tanggal', 'desc')->get();
        return view('exports.maintenance-print', compact('logs'));
    }

    /**
     * Laporan Cetak Khusus Rekomendasi Penggantian & Perencanaan Pengadaan Perangkat
     */
    public function printReplacement(Request $request)
    {
        $devices    = $this->buildReplacementQuery($request)->orderBy('opd_location_id')->orderBy('merk')->get();
        $location   = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;
        $totalBiaya = $devices->sum('estimasi_biaya');
        $totalOpd   = $devices->pluck('opd_location_id')->unique()->count();

        return view('exports.replacement-print', compact('devices', 'location', 'totalBiaya', 'totalOpd'));
    }

    /**
     * Export PDF Rekomendasi Penggantian & Pengadaan Perangkat
     */
    public function exportReplacementPdf(Request $request)
    {
        $devices    = $this->buildReplacementQuery($request)->orderBy('opd_location_id')->orderBy('merk')->get();
        $location   = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;
        $totalBiaya = $devices->sum('estimasi_biaya');
        $totalOpd   = $devices->pluck('opd_location_id')->unique()->count();

        $pdf = Pdf::loadView('exports.replacement-pdf', compact('devices', 'location', 'totalBiaya', 'totalOpd'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-usulan-penggantian-perangkat-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Excel Perencanaan Pengadaan Perangkat Pengganti
     */
    public function exportReplacementExcel(Request $request)
    {
        $devices = $this->buildReplacementQuery($request)->orderBy('opd_location_id')->orderBy('merk')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rencana Penggantian Aset');

        // Header Title
        $sheet->setCellValue('A1', 'USULAN PERENCANAAN PENGGANTIAN DAN PENGADAAN PERANGKAT JARINGAN');
        $sheet->setCellValue('A2', 'DINAS KOMUNIKASI DAN INFORMATIKA - Tanggal Cetak: ' . date('d F Y'));
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setSize(10)->getColor()->setRGB('64748B');

        // Table Header
        $headers = [
            'No',
            'Lokasi OPD',
            'Ruang / Titik Pasang',
            'Perangkat Saat Ini',
            'Tipe',
            'No. Seri',
            'IP Address',
            'Tgl Pasang / Umur',
            'Kondisi Status',
            'Alasan Penggantian (Pertimbangan Teknis)',
            'Usulan / Rekomendasi Pengganti',
            'Estimasi Biaya (Rp)'
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $col++;
        }

        $headerRange = 'A4:L4';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('1E293B');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $row = 5;
        $totalBiaya = 0;
        foreach ($devices as $index => $device) {
            $perangkatText = $device->merk . ($device->model ? ' (' . $device->model . ')' : '');
            $umurText = ($device->tanggal_install ? $device->tanggal_install->format('d/m/Y') : '-') . 
                        ($device->umur_perangkat ? ' (' . $device->umur_perangkat . ')' : '');

            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $device->opdLocation->nama ?? '-');
            $sheet->setCellValue('C' . $row, $device->lokasi_pemasangan ?? '-');
            $sheet->setCellValue('D' . $row, $perangkatText);
            $sheet->setCellValue('E' . $row, $device->tipe);
            $sheet->setCellValue('F' . $row, $device->nomor_seri ?? '-');
            $sheet->setCellValue('G' . $row, $device->ip_address ?? '-');
            $sheet->setCellValue('H' . $row, $umurText);
            $sheet->setCellValue('I' . $row, $device->status);
            $sheet->setCellValue('J' . $row, $device->alasan_penggantian ?? $device->keterangan ?? '-');
            $sheet->setCellValue('K' . $row, $device->rekomendasi_pengganti ?? '-');
            $sheet->setCellValue('L' . $row, (float)($device->estimasi_biaya ?? 0));

            $totalBiaya += (float)($device->estimasi_biaya ?? 0);
            $row++;
        }

        // Summary Row
        $sheet->setCellValue('A' . $row, 'TOTAL ESTIMASI KEBUTUHAN BIAYA');
        $sheet->mergeCells('A' . $row . ':K' . $row);
        $sheet->setCellValue('L' . $row, $totalBiaya);
        $sheet->getStyle('A' . $row . ':L' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':K' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A' . $row . ':L' . $row)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('F1F5F9');

        // Format Currency Column L
        $sheet->getStyle('L5:L' . $row)->getNumberFormat()
            ->setFormatCode('"Rp "#,##0');

        // Auto-size columns
        foreach (range('A', 'L') as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        // Border
        $dataRange = 'A4:L' . $row;
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-pengadaan-penggantian-' . date('Y-m-d') . '.xlsx';
        $tempFile = storage_path('app/' . $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    /**
     * Laporan Cetak Resmi Rekomendasi / Usulan Penambahan Perangkat Baru
     */
    public function printProposal(Request $request)
    {
        $proposals  = $this->buildProposalQuery($request)->orderBy('opd_location_id')->orderBy('urgensi')->get();
        $location   = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;
        $totalBiaya = $proposals->sum('estimasi_biaya');
        $totalUnit  = $proposals->sum('jumlah');
        $totalOpd   = $proposals->pluck('opd_location_id')->unique()->count();
        $emptyOpds  = OpdLocation::withCount('devices')->having('devices_count', 0)->get(['id', 'nama', 'kecamatan']);

        return view('exports.device-proposal-print', compact('proposals', 'location', 'totalBiaya', 'totalUnit', 'totalOpd', 'emptyOpds'));
    }

    /**
     * Export PDF Rekomendasi / Usulan Penambahan Perangkat Baru
     */
    public function exportProposalPdf(Request $request)
    {
        $proposals  = $this->buildProposalQuery($request)->orderBy('opd_location_id')->orderBy('urgensi')->get();
        $location   = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;
        $totalBiaya = $proposals->sum('estimasi_biaya');
        $totalUnit  = $proposals->sum('jumlah');
        $totalOpd   = $proposals->pluck('opd_location_id')->unique()->count();
        $emptyOpds  = OpdLocation::withCount('devices')->having('devices_count', 0)->get(['id', 'nama', 'kecamatan']);

        $pdf = Pdf::loadView('exports.device-proposal-pdf', compact('proposals', 'location', 'totalBiaya', 'totalUnit', 'totalOpd', 'emptyOpds'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-usulan-penambahan-perangkat-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Excel Rekomendasi / Usulan Penambahan Perangkat Baru
     */
    public function exportProposalExcel(Request $request)
    {
        $proposals = $this->buildProposalQuery($request)->orderBy('opd_location_id')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Usulan Penambahan Perangkat');

        // Header Title
        $sheet->setCellValue('A1', 'DAFTAR REKOMENDASI DAN USULAN PENAMBAHAN PERANGKAT JARINGAN');
        $sheet->setCellValue('A2', 'DINAS KOMUNIKASI DAN INFORMATIKA - Tanggal: ' . date('d F Y'));
        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A2:K2');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setSize(10)->getColor()->setRGB('64748B');

        // Table Header
        $headers = [
            'No',
            'Lokasi OPD',
            'Ruang / Titik Pasang',
            'Tipe Perangkat',
            'Jumlah (Unit)',
            'Urgensi',
            'Alasan Kebutuhan / Justifikasi Teknis',
            'Rekomendasi Spesifikasi / Merk & Model',
            'Estimasi Biaya (Rp)',
            'Status Usulan',
            'Pengusul & Catatan'
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $sheet->getStyle($col . '4')->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
            $sheet->getStyle($col . '4')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('059669'); // Emerald / Green theme
            $sheet->getStyle($col . '4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $col++;
        }

        // Data Rows
        $row = 5;
        $totalBiaya = 0;
        $totalUnit = 0;

        foreach ($proposals as $idx => $p) {
            $sheet->setCellValue('A' . $row, $idx + 1);
            $sheet->setCellValue('B' . $row, $p->opdLocation->nama ?? '-');
            $sheet->setCellValue('C' . $row, $p->lokasi_ruang ?? '-');
            $sheet->setCellValue('D' . $row, $p->tipe_perangkat);
            $sheet->setCellValue('E' . $row, (int)$p->jumlah);
            $sheet->setCellValue('F' . $row, $p->urgensi);
            $sheet->setCellValue('G' . $row, $p->alasan_kebutuhan);
            $sheet->setCellValue('H' . $row, $p->rekomendasi_spesifikasi ?? '-');
            $sheet->setCellValue('I' . $row, (float)($p->estimasi_biaya ?? 0));
            $sheet->setCellValue('J' . $row, $p->status);
            $sheet->setCellValue('K' . $row, ($p->nama_pengusul ?? '-') . ($p->catatan ? ' (' . $p->catatan . ')' : ''));

            $totalUnit += (int)$p->jumlah;
            $totalBiaya += (float)($p->estimasi_biaya ?? 0);
            $row++;
        }

        // Summary Row
        $sheet->setCellValue('A' . $row, 'TOTAL UNIT & ANGGARAN');
        $sheet->mergeCells('A' . $row . ':D' . $row);
        $sheet->setCellValue('E' . $row, $totalUnit);
        $sheet->setCellValue('I' . $row, $totalBiaya);
        $sheet->getStyle('A' . $row . ':K' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A' . $row . ':K' . $row)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('ECFDF5');

        // Format Currency Column I
        $sheet->getStyle('I5:I' . $row)->getNumberFormat()
            ->setFormatCode('"Rp "#,##0');

        // Auto-size columns
        foreach (range('A', 'K') as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        // Border
        $dataRange = 'A4:K' . $row;
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-usulan-penambahan-perangkat-' . date('Y-m-d') . '.xlsx';
        $tempFile = storage_path('app/' . $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }
}

