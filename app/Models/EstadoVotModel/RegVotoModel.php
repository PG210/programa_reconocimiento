<?php

namespace App\Models\EstadoVotModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegVotoModel extends Model
{
    protected $table = 'postulado';
    protected $primaryKey = 'id';//tiene que hacer referencia a la llave primaria  


    public function Usuarios()
    {
        return $this->belongsTo(Usuarios::class, 'id_votante', 'id');
    }

    public function EstavotModel()
    {
        return $this->belongsTo(EstavotModel::class, 'id_estado', 'id');
    }
}
