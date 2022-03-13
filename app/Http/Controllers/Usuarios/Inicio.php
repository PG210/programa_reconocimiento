<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Inicio extends Controller
{
    public function index(){
        return view('usuario.inicio');
    }
}
