<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'opd_location_id',
        'lokasi_pemasangan',
        'merk',
        'tipe',
        'model',
        'nomor_seri',
        'ip_address',
        'status',
        'mikrotik_backup_config',
        'tanggal_install',
        'tanggal_rusak',
        'keterangan',
        'foto_perangkat',
    ];

    protected $casts = [
        'tanggal_install' => 'date',
        'tanggal_rusak' => 'date',
    ];

    /**
     * Get the mikrotik config with automatic decryption.
     * Falls back to plain text if decryption fails (for existing data).
     */
    public function getMikrotikBackupConfigAttribute($value)
    {
        if (!$value) return $value;
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    /**
     * Set the mikrotik config with automatic encryption.
     */
    public function setMikrotikBackupConfigAttribute($value)
    {
        $this->attributes['mikrotik_backup_config'] = $value ? encrypt($value) : $value;
    }

    public function opdLocation()
    {
        return $this->belongsTo(OpdLocation::class);
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }

    public function latestMaintenance()
    {
        return $this->hasOne(MaintenanceLog::class)->latestOfMany();
    }
}
