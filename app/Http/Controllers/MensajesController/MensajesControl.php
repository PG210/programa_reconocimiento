<?php

namespace App\Http\Controllers\MensajesController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MensajesControl extends Controller
{
    public function vista(){

        return view('mensajes.vista');
    }
}
