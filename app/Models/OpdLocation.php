<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'alamat',
        'kecamatan',
        'latitude',
        'longitude',
        'kontak_person',
        'telepon',
        'keterangan',
        'denah_file',
    ];

    // ===== RELATIONSHIPS =====

    public function networks()
    {
        return $this->hasMany(OpdNetwork::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function deviceProposals()
    {
        return $this->hasMany(DeviceProposal::class);
    }

    // ===== SCOPES =====

    /**
     * Scope: urutkan abjad case-insensitive.
     * Contoh: OpdLocation::alphabetical()->get()
     */
    public function scopeAlphabetical($query)
    {
        return $query->orderByRaw('LOWER(nama) ASC');
    }

    /**
     * Scope: OPD yang belum memiliki perangkat sama sekali.
     * Contoh: OpdLocation::empty()->get()
     */
    public function scopeEmpty($query)
    {
        return $query->withCount('devices')->having('devices_count', 0);
    }
}
