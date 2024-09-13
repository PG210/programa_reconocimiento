<?php

namespace App\Models\Eventos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntiguedadModel extends Model
{
    protected $table = 'antiguedad';

    protected $fillable = [
        'nombre',
        'tiempo',
        'imagen',
        'descrip',
    ];
}

