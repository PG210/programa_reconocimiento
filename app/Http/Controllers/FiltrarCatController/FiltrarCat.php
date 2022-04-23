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

       
        /*$v=DB::table('comportamiento_categ')->count();
        if($v>1){
          $b=1;
          $categoria=DB::table('comportamiento_categ')->where('comportamiento_categ.descripcion', '!=', 'Default')->get();
        }else{
          $b=0;
          $categoria=DB::table('comportamiento_categ')->get();
        }
        $usu =DB::table('users')->where('users.id', '=', $id)->get();
        $cat =DB::table('categoria_reconoc')->get();
        return view('reconocimientos.listrec')->with('cat', $cat)->with('usu', $usu)->with('categoria', $categoria)->with('b', $b);
    */
    }
   public function comportamiento(Request $request){
       $id=$request->idcom;
       $com=DB::table('categoria_reconoc')->where('categoria_reconoc.id', '=', $id)->
            join('comportamiento_categ', 'categoria_reconoc.id_comportamiento', '=', 'comportamiento_categ.id')
            ->select('categoria_reconoc.id as idcom', 'categoria_reconoc.nombre as nomcat', 'categoria_reconoc.descripcion as descom', 'categoria_reconoc.rutaimagen',
            'categoria_reconoc.rutaimagen', 'comportamiento_categ.descripcion', 'comportamiento_categ.puntos')
            ->get();
       return response(json_decode($com,JSON_UNESCAPED_UNICODE),200)->header('Content-type', 'text/plain');
   }
}
