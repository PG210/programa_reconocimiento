<?php

namespace App\Http\Controllers\NotificacionController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModelNotify\Notificacion;
use App\Models\ModelNotify\InsigniaNoti;
use Illuminate\Support\Facades\Auth;
use DB;

class Notificar extends Controller
{
    public function estado($id){
        //$var=$request->idnoti;
        $usu= auth()->user()->id;
        $val = DB::table('notificaciones')->where('notificaciones.id', '=', $id)->where('notificaciones.estado', '=', 1)->count();
        if($val==1){
            $categoria = Notificacion::findOrfail($id);//buscar el id del producto para actualizar                 
            $categoria->estado = 2;
            $categoria->save();
        }
        $nunnot =  DB::table('notificaciones')
                     ->join('catrecibida', 'notificaciones.idnotifi', '=', 'catrecibida.id')
                     ->where('catrecibida.id_user_recibe', $usu)
                     ->where('notificaciones.estado', '=', 1)->count();

         $insnot =  DB::table('noti_insignia')
                    ->join('insignia_obtenida', 'noti_insignia.id_insignoti', '=', 'insignia_obtenida.id')
                   ->where('insignia_obtenida.id_usuario', $usu)->where('noti_insignia.estado', 1)->count();
        $num = $nunnot+$insnot;
        
        return response(json_decode($num),200)->header('Content-type', 'text/plain');
         
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
   //leer notificaciones de insignias
    public function leer($id){
        $usu= auth()->user()->id;
        $valu = DB::table('noti_insignia')->where('noti_insignia.id', '=', $id)->where('noti_insignia.estado', '=', 1)->count();
       if($valu==1){
            $category = InsigniaNoti::findOrfail($id);//buscar el id del producto para actualizar                 
            $category->estado = 2;
            $category->save();
        }

        $nunnot =  DB::table('notificaciones')
                     ->join('catrecibida', 'notificaciones.idnotifi', '=', 'catrecibida.id')
                     ->where('catrecibida.id_user_recibe', $usu)
                     ->where('notificaciones.estado', '=', 1)->count();
        
        $insnot =  DB::table('noti_insignia')
                   ->join('insignia_obtenida', 'noti_insignia.id_insignoti', '=', 'insignia_obtenida.id')
                   ->where('insignia_obtenida.id_usuario', $usu)->where('noti_insignia.estado', 1)->count();
       
       $num = $nunnot+$insnot;
       return response(json_decode($num),200)->header('Content-type', 'text/plain');
         
    }

    //eliminar notificaciones de insignias
   public function elimarinsig($id){

        $usu= auth()->user()->id;
        DB::table('noti_insignia')->where('noti_insignia.id', '=', $id)->where('noti_insignia.estado', '=', 2)->delete();
         //consultar insignias que esten leidas
         $insigleida =  DB::table('noti_insignia')->join('insignia_obtenida', 'noti_insignia.id_insignoti', '=', 'insignia_obtenida.id')
                       ->where('insignia_obtenida.id_usuario', $usu)->where('noti_insignia.estado', 2)->count();
         if($insigleida!=0){
          $inleida =  DB::table('noti_insignia')
                    ->join('insignia_obtenida', 'noti_insignia.id_insignoti', '=', 'insignia_obtenida.id')
                    ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                    ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                    ->where('insignia_obtenida.id_usuario', $usu)->where('noti_insignia.estado', 2)
                    ->select('noti_insignia.id as idnotinsig', 'noti_insignia.estado', 'insignia.name', 'insignia.descripcion as nivel',
                           'insignia.puntos as insigpuntos', 'insignia.rutaimagen as imginsig', 'premios.name as premionom', 'premios.descripcion as predes',
                           'premios.rutaimagen as preimagen', 'insignia_obtenida.fecha')
                    ->get();

         } 
        return response(json_decode($inleida),200)->header('Content-type', 'text/plain');
   }


}
