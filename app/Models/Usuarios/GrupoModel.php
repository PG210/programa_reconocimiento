<?php

namespace App\Models\Usuarios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoModel extends Model
{
    protected $table = 'grupos';
    // Los campos que pueden ser llenados a través del método create o fill
    protected $fillable = [
        'descripcion',
    ];

}
