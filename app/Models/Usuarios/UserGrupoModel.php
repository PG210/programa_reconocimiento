<?php

namespace App\Models\Usuarios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGrupoModel extends Model
{
    use HasFactory;
    protected $table = 'usugrupos';
    protected $fillable = [
        'idgrupo',
        'idusu',
    ];

    public function grupo()
    {
        return $this->belongsTo(GrupoModel::class, 'idgrupo');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'idusu');
    }
}
