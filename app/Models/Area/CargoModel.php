<?php

namespace App\Models\Area;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoModel extends Model
{
    protected $table = 'cargo';
    protected $primaryKey = "id";//tiene que hacer referencia a la llave primaria  
}
