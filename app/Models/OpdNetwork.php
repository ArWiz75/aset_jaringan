<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdNetwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'opd_location_id',
        'cluster',
        'provider',
        'upload',
        'download',
        'network_ip',
    ];

    public function opdLocation()
    {
        return $this->belongsTo(OpdLocation::class);
    }
}
