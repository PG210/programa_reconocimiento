<?php

namespace App\Models\Comunicacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComunicacionModel extends Model
{
    
    protected $table = 'comunicacion';
    #protected $primaryKey = "id";//tiene que hacer referencia a la llave primaria 
    protected $fillable = [
        'imagen',
        'descrip',
        'posicion',
        'colorletra',
        'colorfondo',
    ];

}
