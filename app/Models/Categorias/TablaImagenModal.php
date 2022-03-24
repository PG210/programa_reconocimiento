<?php

namespace App\Models\Categorias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaImagenModal extends Model
{
    protected $table = 'imagen';
    protected $primaryKey = "id";//tiene que hacer referencia a la llave primaria 
}
