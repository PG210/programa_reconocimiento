<?php

namespace App\Models\Licencias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenciasModel extends Model
{
    protected $table = 'licencias';

    protected $fillable = [
        'numlicencia',
        'vencimiento',
    ];

    protected $dates = [
        'vencimiento',
    ];
}

