<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceProposalController;
use App\Http\Controllers\OpdLocationController;
use App\Http\Controllers\MaintenanceLogController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin-only routes (CRUD create/edit/delete)
    Route::middleware(['admin'])->group(function () {
        Route::get('/devices/create', [DeviceController::class, 'create'])->name('devices.create');
        Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
        Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
        Route::put('/devices/{device}', [DeviceController::class, 'update'])->name('devices.update');
        Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');
        Route::post('/devices/{device}/mark-replacement', [DeviceController::class, 'markReplacement'])->name('devices.mark-replacement');

        Route::get('/opd-locations/create', [OpdLocationController::class, 'create'])->name('opd-locations.create');
        Route::post('/opd-locations', [OpdLocationController::class, 'store'])->name('opd-locations.store');
        Route::get('/opd-locations/{opd_location}/edit', [OpdLocationController::class, 'edit'])->name('opd-locations.edit');
        Route::put('/opd-locations/{opd_location}', [OpdLocationController::class, 'update'])->name('opd-locations.update');
        Route::delete('/opd-locations/{opd_location}', [OpdLocationController::class, 'destroy'])->name('opd-locations.destroy');

        Route::get('/maintenance-logs/create', [MaintenanceLogController::class, 'create'])->name('maintenance-logs.create');
        Route::post('/maintenance-logs', [MaintenanceLogController::class, 'store'])->name('maintenance-logs.store');
        Route::get('/maintenance-logs/{maintenance_log}/edit', [MaintenanceLogController::class, 'edit'])->name('maintenance-logs.edit');
        Route::put('/maintenance-logs/{maintenance_log}', [MaintenanceLogController::class, 'update'])->name('maintenance-logs.update');
        Route::delete('/maintenance-logs/{maintenance_log}', [MaintenanceLogController::class, 'destroy'])->name('maintenance-logs.destroy');

        // Device Proposals (Admin action)
        Route::post('/device-proposals', [DeviceProposalController::class, 'store'])->name('device-proposals.store');
        Route::put('/device-proposals/{device_proposal}', [DeviceProposalController::class, 'update'])->name('device-proposals.update');
        Route::patch('/device-proposals/{device_proposal}/status', [DeviceProposalController::class, 'updateStatus'])->name('device-proposals.update-status');
        Route::delete('/device-proposals/{device_proposal}', [DeviceProposalController::class, 'destroy'])->name('device-proposals.destroy');
        Route::post('/opd-locations/{opd_location}/quick-propose', [DeviceProposalController::class, 'quickProposeEmptyOpd'])->name('device-proposals.quick-empty');
    });

    // View-only routes (accessible by both admin and viewer)
    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('devices.show');
    Route::get('/opd-locations', [OpdLocationController::class, 'index'])->name('opd-locations.index');
    Route::get('/opd-locations/{opd_location}', [OpdLocationController::class, 'show'])->name('opd-locations.show');
    Route::get('/maintenance-logs', [MaintenanceLogController::class, 'index'])->name('maintenance-logs.index');
    Route::get('/maintenance-logs/{maintenance_log}', [MaintenanceLogController::class, 'show'])->name('maintenance-logs.show');

    // Usulan Penambahan Perangkat (Index)
    Route::get('/device-proposals', [DeviceProposalController::class, 'index'])->name('device-proposals.index');

    // Export routes (accessible by both admin and viewer)
    Route::get('/export/devices/pdf', [ExportController::class, 'exportDevicesPdf'])->name('export.devices.pdf');
    Route::get('/export/devices/excel', [ExportController::class, 'exportDevicesExcel'])->name('export.devices.excel');
    Route::get('/export/devices/print', [ExportController::class, 'printDevices'])->name('export.devices.print');
    Route::get('/export/devices/replacement/print', [ExportController::class, 'printReplacement'])->name('export.devices.replacement.print');
    Route::get('/export/devices/replacement/pdf', [ExportController::class, 'exportReplacementPdf'])->name('export.devices.replacement.pdf');
    Route::get('/export/devices/replacement/excel', [ExportController::class, 'exportReplacementExcel'])->name('export.devices.replacement.excel');
    Route::get('/export/maintenance/pdf', [ExportController::class, 'exportMaintenancePdf'])->name('export.maintenance.pdf');
    Route::get('/export/maintenance/excel', [ExportController::class, 'exportMaintenanceExcel'])->name('export.maintenance.excel');
    Route::get('/export/maintenance/print', [ExportController::class, 'printMaintenance'])->name('export.maintenance.print');

    // Proposal Export routes
    Route::get('/export/proposals/print', [ExportController::class, 'printProposal'])->name('export.proposals.print');
    Route::get('/export/proposals/pdf', [ExportController::class, 'exportProposalPdf'])->name('export.proposals.pdf');
    Route::get('/export/proposals/excel', [ExportController::class, 'exportProposalExcel'])->name('export.proposals.excel');
});

require __DIR__.'/auth.php';
