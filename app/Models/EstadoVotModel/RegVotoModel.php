<?php

namespace App\Models\EstadoVotModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegVotoModel extends Model
{
    protected $table = 'postulado';
    protected $primaryKey = 'id';//tiene que hacer referencia a la llave primaria  
}
