<?php

namespace App\Models\Categorias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria_reco extends Model
{
    protected $table = 'categoria_reconoc';
    protected $primaryKey = "id";//tiene que hacer referencia a la llave primaria  
}
