<?php

namespace App\Models\Usuarios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posicion extends Model
{
    protected $table = 'posicion';
    protected $primaryKey = 'id';
    protected $fillable = ['idusu', 'posactual'];
}
