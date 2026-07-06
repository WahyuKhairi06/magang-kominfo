<?php

namespace App\Models;
use App\Models\KategoriHalaman;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'pertanyaan',
        'jawaban'
    ];
}