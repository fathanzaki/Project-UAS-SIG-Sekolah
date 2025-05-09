<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'telepon',
        'email',
        'jenis_sekolah',
        'status_sekolah',
        'akreditasi',
        'website',
        'latitude',
        'longitude'
    ];

    // protected $casts = [
    //     'jenis_sekolah' => \App\Enums\JenisSekolah::class,
    //     'status_sekolah' => \App\Enums\StatusSekolah::class,
    // ];
}