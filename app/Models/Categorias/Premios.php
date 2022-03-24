<?php

namespace App\Models\Categorias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premios extends Model
{
    protected $table = 'premios';
    protected $primaryKey = "id";//tiene que hacer referencia a la llave primaria 
}
