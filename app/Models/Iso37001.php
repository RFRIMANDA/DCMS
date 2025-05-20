<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iso37001 extends Model
{
    use HasFactory;

    protected $table = 'iso37001'; // Nama tabel di database

    protected $fillable = [
        'id_divisi',
        'nama_proses',
        'potensi',
        'skema',
        's',
        'p',
        'level',
        'tindakan',
        'acuan',
        's2',
        'p2',
        'level2',
        'mitigasi',
    ];

    // Jika ada kolom yang perlu dikonversi otomatis, tambahkan casts
    protected $casts = [
        's' => 'integer',
        'p' => 'integer',
        'level' => 'integer',
        's2' => 'integer',
        'p2' => 'integer',
        'level2' => 'integer',
    ];
}
