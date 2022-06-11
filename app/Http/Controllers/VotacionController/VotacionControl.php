<?php

namespace App\Http\Controllers\VotacionController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EstadoVotModel\EstavotModel;
use Illuminate\Support\Facades\Auth;
use App\Models\EstadoVotModel\RegVotoModel;
use Carbon\Carbon;
use DB;
use Session;

class VotacionControl extends Controller
{
    public function habilitar(){
        $es = DB::table('estavotacion')->select('estado', 'estavotacion.id as ides')->get();
        //verificar si hay votos 
        $val = DB::table('postulado')->count();
        if($val!=0){
            $votos = DB::table('postulado')
                     ->join('users','postulado.id_postulado', '=', 'users.id')
                     ->join('comportamiento_categ','postulado.id_votocat', '=', 'comportamiento_categ.id')
                     ->join('roles','users.id_rol', '=', 'roles.id')
                     ->join('cargo','users.id_cargo', '=', 'cargo.id')
                     ->join('area','cargo.id_area', '=', 'area.id')
                     ->selectRaw('users.id as idusu, users.name, users.apellido, users.imagen, roles.descripcion as rol,
                                  cargo.nombre as cargos, area.nombre as areas, count(postulado.id_votocat) as total')
                     ->groupBy('users.name')
                     ->get();

        }
        $cat = RegVotoModel:://se debe validar el periodo de votacion 
                 join('users','postulado.id_postulado', '=', 'users.id')
                ->join('comportamiento_categ','postulado.id_votocat', '=', 'comportamiento_categ.id')
                ->join('roles','users.id_rol', '=', 'roles.id')
                ->join('cargo','users.id_cargo', '=', 'cargo.id')
                ->join('area','cargo.id_area', '=', 'area.id')
                ->select('id_postulado', 'id_votocat', 'comportamiento_categ.descripcion as categoria', 'users.name', 
                          DB::raw( 'COUNT(postulado.id_votocat) as total'))
                ->groupBy('id_postulado')
                ->groupBy('id_votocat')
                ->get();
        return view('admin.votaciones')->with('es', $es)->with('votos', $votos)->with('cat', $cat);
    }

    public function vista_user(){
        $idlog= auth()->user()->id;
        $usu=DB::table('users')->where('id_rol', '!=', 1)->where('users.id', '!=', $idlog)
             ->join('roles', 'users.id_rol', '=', 'roles.id')
             ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
             ->join('area', 'cargo.id_area', '=', 'area.id')
             ->select('users.name', 'users.apellido', 'users.imagen', 'users.id as idusu', 
                     'roles.descripcion as rol', 'cargo.nombre as cargos', 'area.nombre as areas')
            ->get();
          //aqui se debe colocar la validacion
               $v = DB::table('postulado')
                    ->where('id_votante', '=', $idlog)
                    ->where('periodo', '=', 'A')->where('anio', '=', '2022')->count();
            if($v!=0){
                    $b=1;
                    $voto =DB::table('postulado')
                          ->where('id_votante', '=', $idlog)
                          ->where('periodo', '=', 'A')->where('anio', '=', '2022')->select('postulado.id_votocat as idcat')->get();
                    //cat 
                    $categ = DB::table('comportamiento_categ')
                            ->select('comportamiento_categ.id as idcat')
                            ->get();
                    for($j=0; $j<count($voto); ++$j){
                         $varray[$j]=$voto[$j]->idcat;
                        }
                    for($x=0; $x<count($categ); ++$x){
                        $catrray[$x]=$categ[$x]->idcat;
                      }
                    $resultado = array_diff($catrray, $varray); //diferencia entre los dos arrays
                    $resul = array_values($resultado); //vuelve los indices a 0 y 1
                    if($resul!=NULL){
                        for($k=0; $k<count($resul); ++$k){
                            $cat[] =  DB::table('comportamiento_categ')->where('id', $resul[$k])->get();
                        }  
                    }else{
                        $b=2;
                        $cat=0;
                    }     
                }else{
                    $b=0;
                    $cat = DB::table('comportamiento_categ')
                    ->select('comportamiento_categ.id as idcat', 'comportamiento_categ.descripcion as catdes')
                    ->get();
                }

              //aqui finaliza la validacion  
              return view('user.vistavot')->with('usu', $usu)->with('cat', $cat)->with('b', $b);
    }

    public function hab_votacion($id, $estado){
        $cam = EstavotModel::findOrFail($id);
        $cam->estado=$estado;
        $cam->save();
        return back();
    }

    public function buscar(Request $request){
        $idlog= auth()->user()->id;
        $usu=DB::table('users')->where('id_rol', '!=', 1)->where('users.id', '!=', $idlog)
             ->where('users.name', 'like', $request->dato)
             ->join('roles', 'users.id_rol', '=', 'roles.id')
             ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
             ->join('area', 'cargo.id_area', '=', 'area.id')
             ->select('users.name', 'users.apellido', 'users.imagen', 'users.id as idusu', 
                     'roles.descripcion as rol', 'cargo.nombre as cargos', 'area.nombre as areas')
            ->get();
          //aqui se debe colocar la validacion
          $v = DB::table('postulado')
                ->where('id_votante', '=', $idlog)
                ->where('periodo', '=', 'A')->where('anio', '=', '2022')->count();
            if($v!=0){
                    $b=1;
                    $voto =DB::table('postulado')
                            ->where('id_votante', '=', $idlog)
                            ->where('periodo', '=', 'A')->where('anio', '=', '2022')->select('postulado.id_votocat as idcat')->get();
                    //cat 
                    $categ = DB::table('comportamiento_categ')
                            ->select('comportamiento_categ.id as idcat')
                            ->get();
                    for($j=0; $j<count($voto); ++$j){
                        $varray[$j]=$voto[$j]->idcat;
                        }
                    for($x=0; $x<count($categ); ++$x){
                        $catrray[$x]=$categ[$x]->idcat;
                        }
                    $resultado = array_diff($catrray, $varray); //diferencia entre los dos arrays
                    $resul = array_values($resultado); //vuelve los indices a 0 y 1
                    if($resul!=NULL){
                        for($k=0; $k<count($resul); ++$k){
                            $cat[] =  DB::table('comportamiento_categ')->where('id', $resul[$k])->get();
                        }  
                    }else{
                        $b=2;
                        $cat=0;
                    }     
                }else{
                    $b=0;
                    $cat = DB::table('comportamiento_categ')
                    ->select('comportamiento_categ.id as idcat', 'comportamiento_categ.descripcion as catdes')
                    ->get();
                }

                //aqui finaliza la validacion 
        return view('user.vistavot')->with('usu', $usu)->with('cat', $cat)->with('b', $b);
    }

    //funcion para votar 
    public function registrar(Request $request){
        if(isset($request->datos)){
            $date = Carbon::now();
            $idlog= auth()->user()->id;
            $dato = $request->datos;
            $tam = count($dato);
            //validar votos
                for ($i = 0; $i < $tam; ++$i){
                    $reg = new RegVotoModel();
                    $reg->id_postulado = 1;
                    $reg->id_votante = $idlog;
                    $reg->id_votocat = $dato[$i];
                    $reg->periodo = 'A';
                    $reg->anio = 2022;
                    $reg->fecha_voto = $date;
                    $reg->save();
                    // print $dato[$i];
                }
        }else{
            Session::flash('error_voto', 'Selecciona una casilla de votación.');
        }
        
        return back();
    }
}
