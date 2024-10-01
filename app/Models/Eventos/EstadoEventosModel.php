<?php

namespace App\Models\Eventos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoEventosModel extends Model
{
    protected $table = 'estadoeventos';

    protected $fillable = [
        'estado',
    ];
}
