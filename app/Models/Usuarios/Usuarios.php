<?php

namespace App\Models\Usuarios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
   // protected $table = 'users';//crea un modelo la cual esta apuntando a la tabla categorias
   protected $table = 'users';
   protected $primaryKey = "id";//tiene que hacer referencia a la llave primaria  
   
}
