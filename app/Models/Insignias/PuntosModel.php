<?php

namespace App\Models\Insignias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntosModel extends Model
{
    protected $table = 'puntosconfig';
    // Los campos que pueden ser llenados a través del método create o fill
    protected $fillable = [
        'descripcion',
    ];
}
