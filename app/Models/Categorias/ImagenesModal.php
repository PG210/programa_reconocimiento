<?php

namespace App\Models\Categorias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenesModal extends Model
{
    protected $table = 'tipo_imagen';
    protected $primaryKey = "id";//tiene que hacer referencia a la llave primaria 
}
