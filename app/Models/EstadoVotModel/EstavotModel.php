<?php

namespace App\Models\EstadoVotModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstavotModel extends Model
{
    protected $table = 'estavotacion';
    protected $primaryKey = 'id';//tiene que hacer referencia a la llave primaria  

    public function RegVotoModel()
    {
        return $this->hasMany(RegVotoModel::class, 'id_estado', 'id');
    }
}

