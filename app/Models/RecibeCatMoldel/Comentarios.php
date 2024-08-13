<?php

namespace App\Models\RecibeCatMoldel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    use HasFactory;

    protected $table = 'comentarioshistoy';
    protected $primaryKey = 'id';

    public function recibircat()
    {
        return $this->belongsTo(RecibirCat::class, 'idrec');
    }
}