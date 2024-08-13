<?php

namespace App\Models\RecibeCatMoldel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecibirCat extends Model
{
    use HasFactory;

    protected $table = 'catrecibida';
    protected $primaryKey = 'id';

    public function comentarios()
    {
        return $this->hasMany(Comentarios::class, 'idrec');
    }
}
