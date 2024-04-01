<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePerusahaan extends Model
{
    use HasFactory;
    protected $table = 'profile_perusahaan';
    protected $fillable = [
        'nama_perusahaan',
        'deskripsi',
        'lokasi',
        'jam_masuk',
        'jam_pulang',
        'image',
    ];
}