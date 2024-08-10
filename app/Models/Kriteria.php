<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $table = 'kriteria';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_kriteria', 'kode','persentase'];

    public function kualifikasi()
    {
        return $this->hasOne(Guru::class, 'id_kriteria'); 
    }
}
