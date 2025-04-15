<?php

namespace App\Models\Comunicacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pildora extends Model
{
    protected $table = 'pildoras';
    protected $fillable = [
        'asunto',
        'link',
        'descrip'
    ];

}
