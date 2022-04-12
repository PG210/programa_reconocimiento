<?php

namespace App\Http\Controllers\Reconocimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reconocimientos\ReconocimientosModal;
use Illuminate\Support\Facades\DB;

class ReconocimientosController extends Controller
{
    public function enviar(){
        return view('reconocimientos.enviar');
    }

   public function reporteinsig(){
        return view('user.reporteinsignias');
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
   
}
