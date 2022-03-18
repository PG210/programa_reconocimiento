<?php

namespace App\Models\Categorias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comportamiento extends Model
{
    protected $table = 'comportamiento_categ';
   protected $primaryKey = "id";//tiene que hacer referencia a la llave primaria  
}
