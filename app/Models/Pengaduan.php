<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans';

    protected $fillable = [
        'nama',
        'no_hp',
        'isi_pengaduan',
        'kategori_ai',
        'urgensi_ai',
        'alasan_ai',
        'kategori_final',
        'urgensi_final',
        'is_overridden',
        'status_klasifikasi',
        'reviewed_by',
        'reviewed_at',
    ];
}
