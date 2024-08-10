<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamar extends Model
{
    use HasFactory;
    protected $table = 'lamar';
    protected $primaryKey = 'id';

    protected $fillable = ['id_pelamar', 'id_lowongan', 'status', 'nilai'];

    protected $casts = [
        'nilai' => 'array',
    ];
}
