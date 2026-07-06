<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    //
    protected $fillable=[
        'nama_desa',
        'kecamatan'
    ];
}
