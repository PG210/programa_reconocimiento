<?php

namespace App\Http\Controllers\FiltrarCatController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class FiltrarCat extends Controller
{
    public function filtrar(Request $request){
       $id=$request->idcate;
       $bus=DB::table('categoria_reconoc')->where('id_comportamiento', '=', $id)->count();
        $info=DB::table('categoria_reconoc')->where('id_comportamiento', '=', $id)->get();
        return response(json_decode($info),200)->header('Content-type', 'text/plain');
    }
   public function comportamiento(Request $request){
       $id=$request->idcom;
       $com=DB::table('categoria_reconoc')->where('categoria_reconoc.id', '=', $id)->
            join('comportamiento_categ', 'categoria_reconoc.id_comportamiento', '=', 'comportamiento_categ.id')
            ->select('categoria_reconoc.id as idcom', 'categoria_reconoc.nombre as nomcat', 'comportamiento_categ.rutaimagen',
             'comportamiento_categ.descripcion', 'categoria_reconoc.puntos')
            ->get();
       return response(json_decode($com,JSON_UNESCAPED_UNICODE),200)->header('Content-type', 'text/plain');
   }
}
