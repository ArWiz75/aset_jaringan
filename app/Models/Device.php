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
        'alasan_penggantian',
        'rekomendasi_pengganti',
        'estimasi_biaya',
        'keterangan',
        'foto_perangkat',
    ];

    protected $casts = [
        'tanggal_install' => 'date',
        'tanggal_rusak' => 'date',
        'estimasi_biaya' => 'decimal:2',
    ];

    /**
     * Scope query untuk perangkat yang perlu diganti.
     */
    public function scopePerluDiganti($query)
    {
        return $query->where('status', 'Perlu Diganti');
    }

    /**
     * Hitung umur perangkat dari tanggal install sampai sekarang (atau tanggal rusak jika ada).
     */
    public function getUmurPerangkatAttribute(): ?string
    {
        if (!$this->tanggal_install) {
            return null;
        }

        $endDate = $this->tanggal_rusak ?? now();
        $diffYears = $this->tanggal_install->diffInYears($endDate);
        $diffMonths = $this->tanggal_install->diffInMonths($endDate) % 12;

        if ($diffYears > 0 && $diffMonths > 0) {
            return "{$diffYears} thn {$diffMonths} bln";
        } elseif ($diffYears > 0) {
            return "{$diffYears} tahun";
        } elseif ($diffMonths > 0) {
            return "{$diffMonths} bulan";
        } else {
            $days = $this->tanggal_install->diffInDays($endDate);
            return "{$days} hari";
        }
    }

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
