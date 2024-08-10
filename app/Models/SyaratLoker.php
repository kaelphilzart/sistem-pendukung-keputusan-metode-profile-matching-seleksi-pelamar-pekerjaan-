<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratLoker extends Model
{
    use HasFactory;
    protected $table = 'syarat_loker';
    protected $primaryKey = 'id';
    protected $fillable = ['id_loker', 
                            'syarat'];
}
