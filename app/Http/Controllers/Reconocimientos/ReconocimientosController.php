<?php

namespace App\Http\Controllers\Reconocimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reconocimientos\ReconocimientosModal;
use App\Models\RecibeCatMoldel\RecibirCat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReconocimientosController extends Controller
{
    public function enviar(){
        return view('reconocimientos.enviar');
    }

   public function reporteinsig(){
        //consultar reconocimientos recibidos
        $idlog=auth()->id();
        $recibidos = DB::table('catrecibida')->where('catrecibida.id_user_recibe', '=', $idlog)
                    ->join('users', 'catrecibida.id_user_envia', '=', 'users.id')
                    ->join('categoria_reconoc', 'catrecibida.id_categoria_rec', '=', 'categoria_reconoc.id')
                    ->select('users.name as nombre', 'users.apellido', 'users.imagen', 'categoria_reconoc.nombre as nomcat',
                     'categoria_reconoc.descripcion as descat', 'catrecibida.puntos', 'catrecibida.fecha', 'categoria_reconoc.rutaimagen as img')
                    ->get();
        return view('user.reporteinsignias')->with('recibido', $recibidos);
   }

   public function reporte_reconocimiento(){
    $rec = DB::table('reconocimiento')
    ->select(
     'reconocimiento.id as idre',
     'reconocimiento.id_user_logeado',
     'reconocimiento.fecha',
     'reconocimiento.puntos_acumulados',
     'insignia.id as idinsig',
     'insignia.name as insignia',
     'insignia.descripcion as desinsig',
     'insignia.puntos as pun_insig',
     'premios.id as idpre',
     'premios.name as nompre',
     'premios.descripcion as despre',
     'premios.puntos as punpre',
     'premios.rutaimagen as rutapre',
     'categoria_reconoc.id as idcat',
     'categoria_reconoc.nombre as nomcat',
     'categoria_reconoc.descripcion as descat',
     'categoria_reconoc.id_comportamiento',
     'categoria_reconoc.rutaimagen as rutca',
     'comportamiento_categ.id as idcom',
     'comportamiento_categ.descripcion as descom',
     'comportamiento_categ.puntos as puncom',
     'users.id as idus',
     'users.name as nomus',
     'users.apellido as apeus',
     'users.direccion as dirus'
    )
    ->join('categoria_reconoc','id_categoria','=','categoria_reconoc.id')
    ->join('comportamiento_categ','id_comportamiento','=','comportamiento_categ.id')
    ->join('insignia','id_insignia','=','insignia.id')
    ->join('premios','id_premio','=','premios.id')
    ->join('users','id_user_logeado','=','users.id')
    ->get();
    return view('reconocimientos.listar')->with('rec',$rec);
}
  public function listarrec($id){
      $usu =DB::table('users')->where('users.id', '=', $id)->get();
      $cat =DB::table('categoria_reconoc')->get();
      return view('reconocimientos.listrec')->with('cat', $cat)->with('usu', $usu);
  }   

    public function recocatguardar(Request $request){
    $idc=$request->idcat;
    $date = Carbon::now();
    //consultar id en la base de datos
     $cat=DB::table('categoria_reconoc')->where('categoria_reconoc.id', '=', $idc)
          ->join('comportamiento_categ', 'id_comportamiento', '=', 'comportamiento_categ.id')
          ->select('comportamiento_categ.puntos')
          ->first();
    //####################
    $idlogeado=auth()->id();
    $category = new RecibirCat();
    $category->id_user_recibe = $request->input('idusu');
    $category->id_user_envia = $idlogeado;
    $category->id_categoria_rec = $idc;
    $category->puntos = $cat->puntos;
    $category->fecha = $date;
    $category->save();
    return back();
    }

}
