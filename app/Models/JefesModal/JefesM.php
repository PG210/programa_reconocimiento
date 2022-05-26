<?php

namespace App\Models\JefesModal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JefesM extends Model
{   
    protected $table = 'jefes_tot';
    protected $primaryKey = 'id';//tiene que hacer referencia a la llave primaria 
}
