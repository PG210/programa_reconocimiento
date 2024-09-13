<?php

namespace App\Models\Eventos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CumpleModel extends Model
{
    protected $table = 'cumpleanios';

    protected $fillable = [
        'imagen',
        'descrip',
    ];
}
