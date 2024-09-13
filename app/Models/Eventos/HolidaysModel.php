<?php

namespace App\Models\Eventos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidaysModel extends Model
{
    protected $table = 'holidays';

    protected $fillable = [
        'emoticon',
        'idemot',
        'comentario',
        'iduser',
        'useraccion',
        'estado',
    ];
}
