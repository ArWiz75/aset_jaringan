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
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    // ===== PRIVATE HELPERS: Menghilangkan duplikasi filter query =====

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

    private function buildMaintenanceQuery(Request $request)
    {
        $query = MaintenanceLog::with(['device:id,merk,model,nomor_seri,lokasi_pemasangan,opd_location_id', 'device.opdLocation:id,nama', 'user:id,name']);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query;
    }

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

    /**
     * Terapkan Header Instansi Resmi dan Pengaturan Cetak Standar pada Worksheet Excel
     */
    private function applyExcelStandardHeader(Worksheet $sheet, string $docTitle, string $lastCol, ?string $subTitle = null): void
    {
        // 1. Judul Instansi
        $sheet->setCellValue('A1', 'PEMERINTAH KABUPATEN JEMBRANA - DINAS KOMUNIKASI DAN INFORMATIKA');
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB('0F172A');
        $sheet->getRowDimension(1)->setRowHeight(20);

        // 2. Judul Dokumen
        $sheet->setCellValue('A2', strtoupper($docTitle));
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(13)->getColor()->setRGB('1E293B');
        $sheet->getRowDimension(2)->setRowHeight(22);

        // 3. Metadata Baris
        $metaText = $subTitle ?: ('Tanggal Cetak: ' . date('d/m/Y H:i') . ' WIB | Operator: ' . (auth()->user()?->name ?? 'Admin'));
        $sheet->setCellValue('A3', $metaText);
        $sheet->mergeCells("A3:{$lastCol}3");
        $sheet->getStyle('A3')->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('64748B');
        $sheet->getRowDimension(3)->setRowHeight(18);

        // Baris 4 spacer
        $sheet->getRowDimension(4)->setRowHeight(8);

        // Pengaturan Halaman Cetak (Print Setup A4 Landscape, Fit 1 Page Wide)
        $setup = $sheet->getPageSetup();
        $setup->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $setup->setPaperSize(PageSetup::PAPERSIZE_A4);
        $setup->setFitToWidth(1);
        $setup->setFitToHeight(0);
        $sheet->setShowGridlines(true);

        // Ulangi baris header tabel saat dicetak (baris 5)
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(5, 5);
    }

    /**
     * Terapkan styling baris header tabel pada Excel
     */
    private function styleTableHeader(Worksheet $sheet, string $lastCol, string $bgColor = '1E293B'): void
    {
        $range = "A5:{$lastCol}5";
        $sheet->getRowDimension(5)->setRowHeight(26);

        $sheet->getStyle($range)->getFont()->setBold(true)->setSize(9.5)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($range)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB($bgColor);
        $sheet->getStyle($range)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($range)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->getColor()->setRGB('0F172A');
    }

    // ===== DEVICES =====

    public function exportDevicesPdf(Request $request)
    {
        $devices  = $this->buildDeviceQuery($request)->orderBy('opd_location_id')->orderBy('merk')->get();
        $location = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;

        $pdf = Pdf::loadView('exports.devices-pdf', compact('devices', 'location'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-perangkat-' . date('Y-m-d') . '.pdf');
    }

    public function exportDevicesExcel(Request $request)
    {
        $devices  = $this->buildDeviceQuery($request)->orderBy('opd_location_id')->orderBy('merk')->get();
        $location = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Perangkat');

        $sub = 'Filter Lokasi: ' . ($location ? $location->nama : 'Semua Lokasi OPD') . ' | Tanggal Unduh: ' . date('d F Y') . ' | Operator: ' . (auth()->user()?->name ?? 'Admin');
        $this->applyExcelStandardHeader($sheet, 'Laporan Data Perangkat Jaringan', 'K', $sub);

        // Header Tabel di Baris 5
        $headers = [
            'A' => ['label' => 'No', 'width' => 6, 'align' => Alignment::HORIZONTAL_CENTER],
            'B' => ['label' => 'Lokasi OPD', 'width' => 26, 'align' => Alignment::HORIZONTAL_LEFT],
            'C' => ['label' => 'Titik Pemasangan', 'width' => 20, 'align' => Alignment::HORIZONTAL_LEFT],
            'D' => ['label' => 'Merk', 'width' => 16, 'align' => Alignment::HORIZONTAL_LEFT],
            'E' => ['label' => 'Model', 'width' => 16, 'align' => Alignment::HORIZONTAL_LEFT],
            'F' => ['label' => 'Tipe', 'width' => 13, 'align' => Alignment::HORIZONTAL_CENTER],
            'G' => ['label' => 'Nomor Seri', 'width' => 18, 'align' => Alignment::HORIZONTAL_CENTER],
            'H' => ['label' => 'IP Address', 'width' => 16, 'align' => Alignment::HORIZONTAL_CENTER],
            'I' => ['label' => 'Status', 'width' => 14, 'align' => Alignment::HORIZONTAL_CENTER],
            'J' => ['label' => 'Tgl Pasang', 'width' => 14, 'align' => Alignment::HORIZONTAL_CENTER],
            'K' => ['label' => 'Keterangan', 'width' => 30, 'align' => Alignment::HORIZONTAL_LEFT],
        ];

        foreach ($headers as $col => $conf) {
            $sheet->setCellValue($col . '5', $conf['label']);
            $sheet->getColumnDimension($col)->setWidth($conf['width']);
        }
        $this->styleTableHeader($sheet, 'K', '1E293B');

        // Data Rows
        $row = 6;
        foreach ($devices as $index => $device) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $device->opdLocation->nama ?? '-');
            $sheet->setCellValue('C' . $row, $device->lokasi_pemasangan ?? '-');
            $sheet->setCellValue('D' . $row, $device->merk);
            $sheet->setCellValue('E' . $row, $device->model ?? '-');
            $sheet->setCellValue('F' . $row, $device->tipe);
            $sheet->setCellValue('G' . $row, $device->nomor_seri ?? '-');
            $sheet->setCellValue('H' . $row, $device->ip_address ?? '-');
            $sheet->setCellValue('I' . $row, $device->status);
            $sheet->setCellValue('J' . $row, $device->tanggal_install ? $device->tanggal_install->format('d/m/Y') : '-');
            $sheet->setCellValue('K' . $row, $device->keterangan ?? '-');

            $sheet->getRowDimension($row)->setRowHeight(22);

            // Zebra style & alignment
            $rowRange = "A{$row}:K{$row}";
            if ($row % 2 === 0) {
                $sheet->getStyle($rowRange)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F8FAFC');
            }
            $row++;
        }

        // Alignments & Borders
        $lastDataRow = max(6, $row - 1);
        foreach ($headers as $col => $conf) {
            $sheet->getStyle("{$col}6:{$col}{$lastDataRow}")
                ->getAlignment()
                ->setHorizontal($conf['align'])
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setWrapText(in_array($col, ['B', 'C', 'K']));
        }

        $sheet->getStyle("A6:K{$lastDataRow}")->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->getColor()->setRGB('CBD5E1');

        // Summary Row
        $sheet->setCellValue("A{$row}", 'TOTAL PERANGKAT TERDATA');
        $sheet->mergeCells("A{$row}:H{$row}");
        $sheet->setCellValue("I{$row}", $devices->count() . ' Unit');
        $sheet->mergeCells("I{$row}:K{$row}");
        $sheet->getRowDimension($row)->setRowHeight(24);

        $sumRange = "A{$row}:K{$row}";
        $sheet->getStyle($sumRange)->getFont()->setBold(true);
        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("I{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($sumRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F1F5F9');
        $sheet->getStyle($sumRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('CBD5E1');
        $sheet->getStyle($sumRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_DOUBLE)->getColor()->setRGB('0F172A');

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

        $this->applyExcelStandardHeader($sheet, 'Laporan Riwayat Pemeliharaan Jaringan', 'J');

        // Headers
        $headers = [
            'A' => ['label' => 'No', 'width' => 6, 'align' => Alignment::HORIZONTAL_CENTER],
            'B' => ['label' => 'Perangkat & SN', 'width' => 24, 'align' => Alignment::HORIZONTAL_LEFT],
            'C' => ['label' => 'Lokasi OPD', 'width' => 24, 'align' => Alignment::HORIZONTAL_LEFT],
            'D' => ['label' => 'Jenis', 'width' => 15, 'align' => Alignment::HORIZONTAL_CENTER],
            'E' => ['label' => 'Deskripsi Permasalahan / Tindakan', 'width' => 38, 'align' => Alignment::HORIZONTAL_LEFT],
            'F' => ['label' => 'Tanggal', 'width' => 14, 'align' => Alignment::HORIZONTAL_CENTER],
            'G' => ['label' => 'Biaya (Rp)', 'width' => 18, 'align' => Alignment::HORIZONTAL_RIGHT],
            'H' => ['label' => 'Status', 'width' => 13, 'align' => Alignment::HORIZONTAL_CENTER],
            'I' => ['label' => 'Teknisi', 'width' => 18, 'align' => Alignment::HORIZONTAL_CENTER],
            'J' => ['label' => 'Catatan', 'width' => 26, 'align' => Alignment::HORIZONTAL_LEFT],
        ];

        foreach ($headers as $col => $conf) {
            $sheet->setCellValue($col . '5', $conf['label']);
            $sheet->getColumnDimension($col)->setWidth($conf['width']);
        }
        $this->styleTableHeader($sheet, 'J', '1E293B');

        $row = 6;
        $totalBiaya = 0;
        foreach ($logs as $index => $log) {
            $perangkatText = ($log->device->merk ?? '-') . ($log->device->model ? ' ' . $log->device->model : '') . "\nSN: " . ($log->device->nomor_seri ?? '-');
            $biayaVal = (float)($log->biaya ?? 0);
            $totalBiaya += $biayaVal;

            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $perangkatText);
            $sheet->setCellValue('C' . $row, $log->device->opdLocation->nama ?? '-');
            $sheet->setCellValue('D' . $row, $log->jenis);
            $sheet->setCellValue('E' . $row, $log->deskripsi);
            $sheet->setCellValue('F' . $row, $log->tanggal ? $log->tanggal->format('d/m/Y') : '-');
            $sheet->setCellValue('G' . $row, $biayaVal);
            $sheet->setCellValue('H' . $row, $log->status);
            $sheet->setCellValue('I' . $row, $log->user->name ?? '-');
            $sheet->setCellValue('J' . $row, $log->catatan ?? '-');

            $sheet->getRowDimension($row)->setRowHeight(24);

            if ($row % 2 === 0) {
                $sheet->getStyle("A{$row}:J{$row}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F8FAFC');
            }
            $row++;
        }

        $lastDataRow = max(6, $row - 1);
        foreach ($headers as $col => $conf) {
            $sheet->getStyle("{$col}6:{$col}{$lastDataRow}")
                ->getAlignment()
                ->setHorizontal($conf['align'])
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setWrapText(in_array($col, ['B', 'C', 'E', 'J']));
        }

        // Format Currency Column G
        $sheet->getStyle("G6:G{$lastDataRow}")->getNumberFormat()
            ->setFormatCode('"Rp "#,##0');

        $sheet->getStyle("A6:J{$lastDataRow}")->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->getColor()->setRGB('CBD5E1');

        // Summary Row
        $sheet->setCellValue("A{$row}", 'TOTAL REALISASI BIAYA PEMELIHARAAN');
        $sheet->mergeCells("A{$row}:F{$row}");
        $sheet->setCellValue("G{$row}", $totalBiaya);
        $sheet->mergeCells("H{$row}:J{$row}");
        $sheet->getRowDimension($row)->setRowHeight(24);

        $sumRange = "A{$row}:J{$row}";
        $sheet->getStyle($sumRange)->getFont()->setBold(true);
        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("G{$row}")->getNumberFormat()->setFormatCode('"Rp "#,##0');
        $sheet->getStyle("G{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($sumRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F1F5F9');
        $sheet->getStyle($sumRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('CBD5E1');
        $sheet->getStyle($sumRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_DOUBLE)->getColor()->setRGB('0F172A');

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-maintenance-' . date('Y-m-d') . '.xlsx';
        $tempFile = storage_path('app/' . $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    public function printDevices(Request $request)
    {
        $devices  = $this->buildDeviceQuery($request)->orderBy('opd_location_id')->orderBy('merk')->get();
        $location = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;

        return view('exports.devices-print', compact('devices', 'location'));
    }

    public function printMaintenance(Request $request)
    {
        $logs = $this->buildMaintenanceQuery($request)->orderBy('tanggal', 'desc')->get();
        return view('exports.maintenance-print', compact('logs'));
    }

    public function printReplacement(Request $request)
    {
        $devices    = $this->buildReplacementQuery($request)->orderBy('opd_location_id')->orderBy('merk')->get();
        $location   = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;
        $totalBiaya = $devices->sum('estimasi_biaya');
        $totalOpd   = $devices->pluck('opd_location_id')->unique()->count();

        return view('exports.replacement-print', compact('devices', 'location', 'totalBiaya', 'totalOpd'));
    }

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

    public function exportReplacementExcel(Request $request)
    {
        $devices  = $this->buildReplacementQuery($request)->orderBy('opd_location_id')->orderBy('merk')->get();
        $location = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rencana Penggantian Aset');

        $sub = 'Filter Lokasi: ' . ($location ? $location->nama : 'Semua Lokasi OPD') . ' | Tanggal Unduh: ' . date('d F Y') . ' | Operator: ' . (auth()->user()?->name ?? 'Admin');
        $this->applyExcelStandardHeader($sheet, 'Usulan Perencanaan Penggantian & Pengadaan Perangkat', 'L', $sub);

        $headers = [
            'A' => ['label' => 'No', 'width' => 6, 'align' => Alignment::HORIZONTAL_CENTER],
            'B' => ['label' => 'Lokasi OPD', 'width' => 24, 'align' => Alignment::HORIZONTAL_LEFT],
            'C' => ['label' => 'Ruang / Titik Pasang', 'width' => 20, 'align' => Alignment::HORIZONTAL_LEFT],
            'D' => ['label' => 'Perangkat Saat Ini', 'width' => 22, 'align' => Alignment::HORIZONTAL_LEFT],
            'E' => ['label' => 'Tipe', 'width' => 14, 'align' => Alignment::HORIZONTAL_CENTER],
            'F' => ['label' => 'No. Seri', 'width' => 16, 'align' => Alignment::HORIZONTAL_CENTER],
            'G' => ['label' => 'IP Address', 'width' => 16, 'align' => Alignment::HORIZONTAL_CENTER],
            'H' => ['label' => 'Tgl Pasang / Umur', 'width' => 18, 'align' => Alignment::HORIZONTAL_CENTER],
            'I' => ['label' => 'Kondisi Status', 'width' => 15, 'align' => Alignment::HORIZONTAL_CENTER],
            'J' => ['label' => 'Alasan Penggantian (Pertimbangan Teknis)', 'width' => 38, 'align' => Alignment::HORIZONTAL_LEFT],
            'K' => ['label' => 'Usulan / Rekomendasi Pengganti', 'width' => 26, 'align' => Alignment::HORIZONTAL_LEFT],
            'L' => ['label' => 'Estimasi Biaya (Rp)', 'width' => 19, 'align' => Alignment::HORIZONTAL_RIGHT],
        ];

        foreach ($headers as $col => $conf) {
            $sheet->setCellValue($col . '5', $conf['label']);
            $sheet->getColumnDimension($col)->setWidth($conf['width']);
        }
        $this->styleTableHeader($sheet, 'L', '1E293B');

        $row = 6;
        $totalBiaya = 0;
        foreach ($devices as $index => $device) {
            $perangkatText = $device->merk . ($device->model ? ' (' . $device->model . ')' : '');
            $umurText = ($device->tanggal_install ? $device->tanggal_install->format('d/m/Y') : '-') .
                        ($device->umur_perangkat ? "\n(" . $device->umur_perangkat . ')' : '');
            $biayaVal = (float)($device->estimasi_biaya ?? 0);
            $totalBiaya += $biayaVal;

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
            $sheet->setCellValue('L' . $row, $biayaVal);

            $sheet->getRowDimension($row)->setRowHeight(24);

            if ($row % 2 === 0) {
                $sheet->getStyle("A{$row}:L{$row}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F8FAFC');
            }
            $row++;
        }

        $lastDataRow = max(6, $row - 1);
        foreach ($headers as $col => $conf) {
            $sheet->getStyle("{$col}6:{$col}{$lastDataRow}")
                ->getAlignment()
                ->setHorizontal($conf['align'])
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setWrapText(in_array($col, ['B', 'C', 'D', 'H', 'J', 'K']));
        }

        // Format Currency Column L
        $sheet->getStyle("L6:L{$lastDataRow}")->getNumberFormat()
            ->setFormatCode('"Rp "#,##0');

        $sheet->getStyle("A6:L{$lastDataRow}")->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->getColor()->setRGB('CBD5E1');

        // Summary Row
        $sheet->setCellValue("A{$row}", 'TOTAL ESTIMASI KEBUTUHAN BIAYA PENGADAAN');
        $sheet->mergeCells("A{$row}:K{$row}");
        $sheet->setCellValue("L{$row}", $totalBiaya);
        $sheet->getRowDimension($row)->setRowHeight(24);

        $sumRange = "A{$row}:L{$row}";
        $sheet->getStyle($sumRange)->getFont()->setBold(true);
        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("L{$row}")->getNumberFormat()->setFormatCode('"Rp "#,##0');
        $sheet->getStyle("L{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($sumRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F1F5F9');
        $sheet->getStyle($sumRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('CBD5E1');
        $sheet->getStyle($sumRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_DOUBLE)->getColor()->setRGB('0F172A');

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-pengadaan-penggantian-' . date('Y-m-d') . '.xlsx';
        $tempFile = storage_path('app/' . $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    public function printProposal(Request $request)
    {
        $proposals  = $this->buildProposalQuery($request)->orderBy('opd_location_id')->orderBy('urgensi')->get();
        $location   = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;
        $totalBiaya = $proposals->sum('estimasi_biaya');
        $totalUnit  = $proposals->sum('jumlah');
        $totalOpd   = $proposals->pluck('opd_location_id')->unique()->count();
        $emptyOpds  = OpdLocation::whereDoesntHave('devices')->get(['id', 'nama', 'kecamatan']);

        return view('exports.device-proposal-print', compact('proposals', 'location', 'totalBiaya', 'totalUnit', 'totalOpd', 'emptyOpds'));
    }

    public function exportProposalPdf(Request $request)
    {
        $proposals  = $this->buildProposalQuery($request)->orderBy('opd_location_id')->orderBy('urgensi')->get();
        $location   = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;
        $totalBiaya = $proposals->sum('estimasi_biaya');
        $totalUnit  = $proposals->sum('jumlah');
        $totalOpd   = $proposals->pluck('opd_location_id')->unique()->count();
        $emptyOpds  = OpdLocation::whereDoesntHave('devices')->get(['id', 'nama', 'kecamatan']);

        $pdf = Pdf::loadView('exports.device-proposal-pdf', compact('proposals', 'location', 'totalBiaya', 'totalUnit', 'totalOpd', 'emptyOpds'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-usulan-penambahan-perangkat-' . date('Y-m-d') . '.pdf');
    }

    public function exportProposalExcel(Request $request)
    {
        $proposals = $this->buildProposalQuery($request)->orderBy('opd_location_id')->get();
        $location  = $request->filled('opd_location_id') ? OpdLocation::find($request->opd_location_id) : null;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Usulan Pengadaan');

        $sub = 'Filter Lokasi: ' . ($location ? $location->nama : 'Semua Lokasi OPD') . ' | Tanggal Unduh: ' . date('d F Y') . ' | Operator: ' . (auth()->user()?->name ?? 'Admin');
        $this->applyExcelStandardHeader($sheet, 'Daftar Usulan Pengadaan & Penambahan Perangkat Baru', 'K', $sub);

        $headers = [
            'A' => ['label' => 'No', 'width' => 6, 'align' => Alignment::HORIZONTAL_CENTER],
            'B' => ['label' => 'Lokasi OPD', 'width' => 24, 'align' => Alignment::HORIZONTAL_LEFT],
            'C' => ['label' => 'Ruang Pasang', 'width' => 18, 'align' => Alignment::HORIZONTAL_LEFT],
            'D' => ['label' => 'Tipe Perangkat', 'width' => 16, 'align' => Alignment::HORIZONTAL_CENTER],
            'E' => ['label' => 'Jumlah (Unit)', 'width' => 14, 'align' => Alignment::HORIZONTAL_CENTER],
            'F' => ['label' => 'Urgensi', 'width' => 13, 'align' => Alignment::HORIZONTAL_CENTER],
            'G' => ['label' => 'Alasan Kebutuhan / Justifikasi Teknis', 'width' => 38, 'align' => Alignment::HORIZONTAL_LEFT],
            'H' => ['label' => 'Rekomendasi Spesifikasi / Merk', 'width' => 26, 'align' => Alignment::HORIZONTAL_LEFT],
            'I' => ['label' => 'Estimasi Biaya (Rp)', 'width' => 19, 'align' => Alignment::HORIZONTAL_RIGHT],
            'J' => ['label' => 'Status Usulan', 'width' => 15, 'align' => Alignment::HORIZONTAL_CENTER],
            'K' => ['label' => 'Pengusul & Catatan', 'width' => 26, 'align' => Alignment::HORIZONTAL_LEFT],
        ];

        foreach ($headers as $col => $conf) {
            $sheet->setCellValue($col . '5', $conf['label']);
            $sheet->getColumnDimension($col)->setWidth($conf['width']);
        }
        $this->styleTableHeader($sheet, 'K', '1E293B');

        $row = 6;
        $totalBiaya = 0;
        $totalUnit  = 0;

        foreach ($proposals as $idx => $p) {
            $unitVal = (int)$p->jumlah;
            $biayaVal = (float)($p->estimasi_biaya ?? 0);
            $totalUnit += $unitVal;
            $totalBiaya += $biayaVal;

            $sheet->setCellValue('A' . $row, $idx + 1);
            $sheet->setCellValue('B' . $row, $p->opdLocation->nama ?? '-');
            $sheet->setCellValue('C' . $row, $p->lokasi_ruang ?? '-');
            $sheet->setCellValue('D' . $row, $p->tipe_perangkat);
            $sheet->setCellValue('E' . $row, $unitVal);
            $sheet->setCellValue('F' . $row, $p->urgensi);
            $sheet->setCellValue('G' . $row, $p->alasan_kebutuhan);
            $sheet->setCellValue('H' . $row, $p->rekomendasi_spesifikasi ?? '-');
            $sheet->setCellValue('I' . $row, $biayaVal);
            $sheet->setCellValue('J' . $row, $p->status);
            $sheet->setCellValue('K' . $row, ($p->nama_pengusul ?? '-') . ($p->catatan ? ' (' . $p->catatan . ')' : ''));

            $sheet->getRowDimension($row)->setRowHeight(24);

            if ($row % 2 === 0) {
                $sheet->getStyle("A{$row}:K{$row}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F8FAFC');
            }
            $row++;
        }

        $lastDataRow = max(6, $row - 1);
        foreach ($headers as $col => $conf) {
            $sheet->getStyle("{$col}6:{$col}{$lastDataRow}")
                ->getAlignment()
                ->setHorizontal($conf['align'])
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setWrapText(in_array($col, ['B', 'C', 'G', 'H', 'K']));
        }

        // Format Currency Column I
        $sheet->getStyle("I6:I{$lastDataRow}")->getNumberFormat()
            ->setFormatCode('"Rp "#,##0');

        $sheet->getStyle("A6:K{$lastDataRow}")->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->getColor()->setRGB('CBD5E1');

        // Summary Row
        $sheet->setCellValue("A{$row}", 'TOTAL UNIT & ESTIMASI ANGGARAN');
        $sheet->mergeCells("A{$row}:D{$row}");
        $sheet->setCellValue("E{$row}", $totalUnit);
        $sheet->setCellValue("I{$row}", $totalBiaya);
        $sheet->getRowDimension($row)->setRowHeight(24);

        $sumRange = "A{$row}:K{$row}";
        $sheet->getStyle($sumRange)->getFont()->setBold(true);
        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("E{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("I{$row}")->getNumberFormat()->setFormatCode('"Rp "#,##0');
        $sheet->getStyle("I{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($sumRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F1F5F9');
        $sheet->getStyle($sumRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('CBD5E1');
        $sheet->getStyle($sumRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_DOUBLE)->getColor()->setRGB('0F172A');

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-usulan-penambahan-perangkat-' . date('Y-m-d') . '.xlsx';
        $tempFile = storage_path('app/' . $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }
}
