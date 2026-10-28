<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'opd_location_id',
        'nama_pengusul',
        'tipe_perangkat',
        'jumlah',
        'lokasi_ruang',
        'urgensi',
        'alasan_kebutuhan',
        'rekomendasi_spesifikasi',
        'estimasi_biaya',
        'status',
        'catatan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'estimasi_biaya' => 'decimal:2',
    ];

    public function opdLocation()
    {
        return $this->belongsTo(OpdLocation::class);
    }

    /**
     * Scope filter status usulan aktif (belum terealisasi/ditolak)
     */
    public function scopePending($query)
    {
        return $query->whereIn('status', ['Diusulkan', 'Disetujui', 'Dalam Pengadaan']);
    }

    /**
     * Format Rupiah untuk estimasi biaya
     */
    public function getFormattedBiayaAttribute(): string
    {
        if (!$this->estimasi_biaya) {
            return '-';
        }
        return 'Rp ' . number_format($this->estimasi_biaya, 0, ',', '.');
    }

    /**
     * Warna badge urgensi
     */
    public function getUrgensiBadgeAttribute(): array
    {
        return match($this->urgensi) {
            'Tinggi' => ['bg' => 'bg-rose-500/15', 'text' => 'text-rose-600 dark:text-rose-400', 'border' => 'border-rose-500/30'],
            'Sedang' => ['bg' => 'bg-amber-500/15', 'text' => 'text-amber-600 dark:text-amber-400', 'border' => 'border-amber-500/30'],
            'Rendah' => ['bg' => 'bg-blue-500/15', 'text' => 'text-blue-600 dark:text-blue-400', 'border' => 'border-blue-500/30'],
            default  => ['bg' => 'bg-slate-500/15', 'text' => 'text-slate-600 dark:text-slate-400', 'border' => 'border-slate-500/30'],
        };
    }

    /**
     * Warna badge status
     */
    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'Diusulkan'        => ['bg' => 'bg-amber-500/15', 'text' => 'text-amber-600 dark:text-amber-400', 'border' => 'border-amber-500/30'],
            'Disetujui'        => ['bg' => 'bg-blue-500/15', 'text' => 'text-blue-600 dark:text-blue-400', 'border' => 'border-blue-500/30'],
            'Dalam Pengadaan'  => ['bg' => 'bg-purple-500/15', 'text' => 'text-purple-600 dark:text-purple-400', 'border' => 'border-purple-500/30'],
            'Terealisasi'      => ['bg' => 'bg-emerald-500/15', 'text' => 'text-emerald-600 dark:text-emerald-400', 'border' => 'border-emerald-500/30'],
            'Ditolak'          => ['bg' => 'bg-rose-500/15', 'text' => 'text-rose-600 dark:text-rose-400', 'border' => 'border-rose-500/30'],
            default            => ['bg' => 'bg-slate-500/15', 'text' => 'text-slate-600 dark:text-slate-400', 'border' => 'border-slate-500/30'],
        };
    }
}