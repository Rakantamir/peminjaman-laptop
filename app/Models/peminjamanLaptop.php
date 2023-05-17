<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class peminjamanLaptop extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'nis',
        'nama',
        'rombel',
        'rayon',
    ];
}
