<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;
    protected $table = 'lowongan';
    protected $primaryKey = 'id';
    protected $fillable = ['lowongan','kuota','status', 'tanggal_mulai', 'tanggal_berakhir'];
}
