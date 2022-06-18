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
        $es = DB::table('estavotacion')->select('estado', 'estavotacion.id as ides', 'periodo', 'anio')->where('estado', '=', 1)->get();
        $esfil = DB::table('estavotacion')->select('anio')->distinct()->get();
        $total = DB::table('estavotacion')->where('estado', '=', 1)->count();
        //verificar si hay votos 
        //$val = DB::table('postulado')->count();
        //obtner las fechas (anio)
        $date = Carbon::now();
        $anio = $date->format('Y');
        return view('admin.votaciones')->with('es', $es)->with('anio', $anio)->with('total', $total)->with('esfil', $esfil);
    }

    public function vista_user(){
        $idlog= auth()->user()->id;
        //consultar a la tabla votaciones
        $vot = DB::table('estavotacion')->where('estado', '=', 1)->select('estavotacion.id as idvot', 'periodo', 'anio')->first();
        //end votaciones
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
                    ->where('id_estado', '=', $vot->idvot)->count();
            if($v!=0){
                    $b=1;
                    $voto =DB::table('postulado')
                          ->where('id_votante', '=', $idlog)
                          ->where('id_estado', '=', $vot->idvot)->select('postulado.id_votocat as idcat')->get();
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
              return view('user.vistavot')->with('usu', $usu)->with('cat', $cat)->with('b', $b)->with('vot', $vot);
    }

    public function hab_votacion(Request $request){
        $p = DB::table('estavotacion')->where('anio',$request->anio)->where('periodo', $request->per)->count();
        if($p==0){
            $reg = new EstavotModel();
            $reg->anio = $request->input('anio');;
            $reg->periodo = $request->input('per');
            $reg->estado =$request->input('val'); //1 es habilitado
            $reg->save();
        }else{
            Session::flash('errorhab', 'Seleccione un año y periodo diferente');
        }
        return back();
    }

    public function desvot($id, $val){
        $actu = EstavotModel::findOrfail($id);
        $actu->estado = $val;
        $actu->save();
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
          $vot = DB::table('estavotacion')->where('estado', '=', 1)->select('estavotacion.id as idvot', 'periodo', 'anio')->first();
          //end buscar estado
          $v = DB::table('postulado')
                ->where('id_votante', '=', $idlog)
                ->where('id_estado', '=', $vot->idvot)->count();
            if($v!=0){
                    $b=1;
                    $voto =DB::table('postulado')
                            ->where('id_votante', '=', $idlog)
                            ->where('id_estado', '=', $vot->idvot)->select('postulado.id_votocat as idcat')->get();
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
        return view('user.vistavot')->with('usu', $usu)->with('cat', $cat)->with('b', $b)->with('vot', $vot);
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
                    $reg->id_postulado = $request->idpos;
                    $reg->id_votante = $idlog;
                    $reg->id_votocat = $dato[$i];
                    $reg->fecha_voto = $date;
                    $reg->id_estado = $request->idvot;
                    $reg->save();
                    // print $dato[$i];
                }
        }else{
            Session::flash('error_voto', 'Selecciona una casilla de votación.');
        }
        
        return back();
    }

    //filtrar votos
    public function filtrar(Request $request){
        $con = DB::table('estavotacion')->where('anio', $request->aniofil)->where('periodo', $request->peri)->select('estavotacion.id as idestado')->count();
        if($con!=0){
            $filtrarval = DB::table('estavotacion')->where('anio', $request->aniofil)->where('periodo', $request->peri)->select('estavotacion.id as idestado')->get();
             $votoscon = DB::table('postulado')->where('postulado.id_estado', $filtrarval[0]->idestado)->count();
            if($votoscon!=0){
                $es = DB::table('estavotacion')->select('estado', 'estavotacion.id as ides', 'periodo', 'anio')->where('estado', '=', 1)->get();
                $esfil = DB::table('estavotacion')->select('anio')->distinct()->get();
                $total = DB::table('estavotacion')->where('estado', '=', 1)->count();
                //verificar si hay votos 
                //$val = DB::table('postulado')->count();
                $votos = DB::table('postulado')
                                ->where('postulado.id_estado', $filtrarval[0]->idestado)
                                ->join('users','postulado.id_postulado', '=', 'users.id')
                                ->join('comportamiento_categ','postulado.id_votocat', '=', 'comportamiento_categ.id')
                                ->join('roles','users.id_rol', '=', 'roles.id')
                                ->join('cargo','users.id_cargo', '=', 'cargo.id')
                                ->join('area','cargo.id_area', '=', 'area.id')
                                ->join('estavotacion', 'postulado.id_estado', '=', 'estavotacion.id')
                                ->selectRaw('users.id as idusu, users.name, estavotacion.anio,  estavotacion.periodo, users.apellido, users.imagen, roles.descripcion as rol,
                                            cargo.nombre as cargos, area.nombre as areas, count(postulado.id_votocat) as total')
                                ->groupBy('users.name')
                                ->orderBy('total','desc')
                                ->get();
                    $cat = RegVotoModel::where('postulado.id_estado', $filtrarval[0]->idestado)//se debe validar el periodo de votacion 
                            ->join('users','postulado.id_postulado', '=', 'users.id')
                        ->join('comportamiento_categ','postulado.id_votocat', '=', 'comportamiento_categ.id')
                        ->join('roles','users.id_rol', '=', 'roles.id')
                        ->join('cargo','users.id_cargo', '=', 'cargo.id')
                        ->join('area','cargo.id_area', '=', 'area.id')
                        ->select('id_postulado', 'id_votocat', 'comportamiento_categ.descripcion as categoria', 'users.name', 
                                    DB::raw( 'COUNT(postulado.id_votocat) as total'))
                        ->groupBy('id_postulado')
                        ->groupBy('id_votocat')
                        ->get();
                //obtner las fechas (anio)
                $date = Carbon::now();
                $anio = $date->format('Y');
                return view('admin.votaciones')->with('es', $es)->with('votos', $votos)->with('cat', $cat)->with('anio', $anio)->with('total', $total)->with('esfil', $esfil);
            }else{
                Session::flash('errorfitrar', 'No se encontraron registros para la busqueda.');
                return back();
            }
        }else{
            Session::flash('errorfitrar', 'No se encontraron registros para la busqueda.');
            return back();

        }
       
       
    }

    public function categoria(){
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
        return $cat;
        return view('admin.listavot');
    }
}
