<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiIsi extends Model
{
    use HasFactory;
    protected $table = 'nilai_isi';
    protected $primaryKey = 'id';
    protected $fillable = ['id_sub', 'keterangan_isi','nilai_isi'];
}
