<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelamar extends Model
{
    use HasFactory;
    protected $table = 'pelamar';
    protected $primaryKey = 'id';
    protected $fillable = ['id_user', 'foto','nama_lengkap', 'alamat', 'tempat_lahir','tanggal_lahir',
                            'no_hp'];
}
