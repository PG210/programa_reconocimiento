<?php

namespace App\Http\Controllers\NotificacionController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModelNotify\Notificacion;
use Illuminate\Support\Facades\Auth;
use DB;

class Notificar extends Controller
{
    public function estado($id){
        //$var=$request->idnoti;
        $val = DB::table('notificaciones')->where('notificaciones.id', '=', $id)->where('notificaciones.estado', '=', 1)->count();
        if($val==1){
            $categoria = Notificacion::findOrfail($id);//buscar el id del producto para actualizar                 
            $categoria->estado = 2;
            $categoria->save();
        }
        $nunnot =  DB::table('notificaciones')->where('notificaciones.estado', '=', 1)->count();
        return response(json_decode($nunnot),200)->header('Content-type', 'text/plain');
         
    }
    public function eliminar($id){
        $usu= auth()->user()->id;
        DB::table('notificaciones')->where('notificaciones.id', '=', $id)->where('notificaciones.estado', '=', 2)->delete();
       //consultar para devolver los datos
        $valeidos= DB::table('notificaciones')->join('catrecibida', 'notificaciones.idnotifi', '=', 'catrecibida.id')
                       ->where('catrecibida.id_user_recibe', $usu)->where('notificaciones.estado', 2)->count();
            if($valeidos!=0){
              $leidos =DB::table('notificaciones')
                    ->join('catrecibida', 'notificaciones.idnotifi', '=', 'catrecibida.id')
                    ->join('users', 'catrecibida.id_user_envia', '=', 'users.id')
                    ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                    ->join('categoria_reconoc', 'catrecibida.id_comportamiento', '=', 'categoria_reconoc.id')
                    ->where('catrecibida.id_user_recibe', $usu)->where('notificaciones.estado', 2)
                    ->select('notificaciones.id', 'notificaciones.notinom', 'notificaciones.notides', 'users.name', 
                            'users.apellido', 'users.imagen', 'notificaciones.fecha', 'comportamiento_categ.descripcion as categoria',
                            'categoria_reconoc.nombre as comportamiento', 'comportamiento_categ.puntos as catpuntos', 'categoria_reconoc.rutaimagen')
                    ->get();
            }
        return response(json_decode($leidos),200)->header('Content-type', 'text/plain');
    }
}
