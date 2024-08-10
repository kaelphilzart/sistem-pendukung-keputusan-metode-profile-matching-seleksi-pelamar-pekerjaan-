<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BobotGap extends Model
{
    use HasFactory;
    protected $table = 'bobot_gap';
    protected $primaryKey = 'id';
    protected $fillable = ['selisih', 'nilai_gap','keterangan_gap'];
}
