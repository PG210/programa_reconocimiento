<?php

namespace App\Models\Eventos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarHolidayModel extends Model
{
    protected $table = 'comentarholiday';

    protected $fillable = [
        'comentario',
        'iduser',
        'useraccion',
        'tipo',
    ];
}
