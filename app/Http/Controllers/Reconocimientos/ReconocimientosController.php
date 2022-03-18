<?php

namespace App\Http\Controllers\Reconocimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReconocimientosController extends Controller
{
    public function enviar(){
        
        return view('reconocimientos.enviar');
    }
}
