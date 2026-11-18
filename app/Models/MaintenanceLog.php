<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'user_id',
        'jenis',
        'deskripsi',
        'tanggal',
        'biaya',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'biaya' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('dashboard_metrics_data');
            \Illuminate\Support\Facades\Cache::forget('maintenance_status_counts');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('dashboard_metrics_data');
            \Illuminate\Support\Facades\Cache::forget('maintenance_status_counts');
        });
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
