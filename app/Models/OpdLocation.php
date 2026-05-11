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

    public function networks()
    {
        return $this->hasMany(OpdNetwork::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function activeDevicesCount()
    {
        return $this->devices()->where('status', 'Aktif')->count();
    }

    public function totalDevicesCount()
    {
        return $this->devices()->count();
    }
}
