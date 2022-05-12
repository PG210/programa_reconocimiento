<?php

namespace App\Http\Controllers\NotificacionController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModelNotify\Notificacion;
use DB;

class Notificar extends Controller
{
    public function estado($id){
        //$var=$request->idnoti;

        $categoria = Notificacion::findOrfail($id);//buscar el id del producto para actualizar                 
        $categoria->estado = 2;
        $categoria->save();
        //echo var_dump($id);
         return back();
         
    }
}
