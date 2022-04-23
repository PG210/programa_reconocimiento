<?php

namespace App\Models\Area;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
    protected $table = 'area';
    protected $primaryKey = "id";//tiene que hacer referencia a la llave primaria  
}
