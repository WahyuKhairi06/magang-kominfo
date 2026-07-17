<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PuskesmasSetting extends Model
{
    use HasFactory;

    protected $table = 'puskesmas_settings';

    protected $fillable = [
        'nama_puskesmas',
        'kabupaten_kota',
        'alamat',
        'no_telp',
        'email',
        'logo',
        'jam_senin_kamis',
        'jam_jumat',
        'jam_sabtu',
        'link_facebook',
        'link_instagram',
    ];
}
