<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;
    protected $table = 'sub_kriteria';
    protected $primaryKey = 'id';
    protected $fillable = ['id_kriteria','id_loker', 'kode_sub','nama_sub_kriteria','nilai_standar','input_pelamar','pengelompokan','perintah'];


    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id');
    }
}
