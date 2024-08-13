<?php

namespace App\Http\Controllers\VotacionController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EstadoVotModel\EstavotModel;
use Illuminate\Support\Facades\Auth;
use App\Models\EstadoVotModel\RegVotoModel;
use Maatwebsite\Excel\Facades\Excel; //excel votos
use App\Exports\VotosExcel; // excel votos
use App\Exports\VotosPendientes; //vtos pendientes
use App\Models\Usuarios\Usuarios; // para ver usuarios
use App\Models\Categorias\Comportamiento; // para categorias
use Carbon\Carbon;
use DB;
use Session;

class VotacionControl extends Controller
{
    public function habilitar(){
        $es = DB::table('estavotacion')->select('estado', 'estavotacion.id as ides', 'periodo', 'anio')->where('estado', '=', 1)->get();
        $esfil = DB::table('estavotacion')->select('anio')->distinct()->get();
        $total = DB::table('estavotacion')->where('estado', '=', 1)->count();
        $cat = DB::table('comportamiento_categ')->select('comportamiento_categ.descripcion', 'comportamiento_categ.id as idcat')->get();
        //verificar si hay votos 
        $users = Usuarios::join('cargo', 'users.id_cargo', '=', 'cargo.id')
                 ->select('users.id as idusu', 'name', 'apellido', 'cargo.nombre as cargo', 'postulado')
                 ->where('users.id', '!=', '1')
                 ->OrderBy('name', 'ASC')
                 ->get();
        //obtner las fechas (anio)
        $date = Carbon::now();
        $anio = $date->format('Y');
        return view('admin.votaciones')->with('cat', $cat)->with('es', $es)->with('anio', $anio)->with('total', $total)->with('esfil', $esfil)->with('users', $users);
    }

    public function vista_user(){
        $idlog= auth()->user()->id;
        //consultar a la tabla votaciones
        $vot = DB::table('estavotacion')->where('estado', '=', 1)->select('estavotacion.id as idvot', 'periodo', 'anio')->first();
        //end votaciones
        $usu=Usuarios::where('id_rol', '!=', 1)
             ->where('users.id', '!=', $idlog)
             ->where('users.postulado', '1')
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
        $usu=Usuarios::where('id_rol', '!=', 1)->where('users.id', '!=', $idlog)
             ->where('users.name', 'like', $request->dato)
             ->where('users.postulado', '1')
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
            $tvotos = Comportamiento::count();
            $tvotados = RegVotoModel::where('id_estado', $request->idvot)
                            ->where('id_votante', $idlog)
                            ->count();
            $total = $tvotos-$tvotados; //calcular el total de votos pendientes

            Session::flash('error_voto', '¡Su voto ha sido registrado satisfactoriamente! votos pendientes: '.$total);
        }else{
            Session::flash('error_voto', 'Selecciona una casilla de votación.');
        }
        return back();
    }

    //filtrar votos
    public function filtrar(Request $request){

        $con = EStaVotModel::where('anio', $request->aniofil)->where('periodo', $request->peri)->count();
        if($con!=0){
            $filtrarval = EStaVotModel::where('anio', $request->aniofil)->where('periodo', $request->peri)->select('estavotacion.id as idestado')->get();
             $votoscon = RegVotoModel::where('postulado.id_estado', $filtrarval[0]->idestado)->count();
            if($votoscon!=0){
                $es = EStaVotModel::select('estado', 'estavotacion.id as ides', 'periodo', 'anio')->where('estado', '=', 1)->first();
                
                $votos = RegVotoModel::where('postulado.id_estado', $filtrarval[0]->idestado)
                                ->join('users','postulado.id_postulado', '=', 'users.id')
                                ->join('comportamiento_categ','postulado.id_votocat', '=', 'comportamiento_categ.id')
                                ->join('roles','users.id_rol', '=', 'roles.id')
                                ->join('cargo','users.id_cargo', '=', 'cargo.id')
                                ->join('area','cargo.id_area', '=', 'area.id')
                                ->selectRaw('users.id as idusu, users.name, users.apellido, users.imagen, roles.descripcion as rol,
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
                            ->groupBy('id_postulado', 'id_votocat')
                            ->orderBy('id_votocat', 'ASC')
                            ->get();
                $categorias = Comportamiento::OrderBy('id', 'ASC')->get();
                // consulta unida
                return view('admin.listavot')->with('categorias', $categorias)->with('votos', $votos)->with('cat', $cat)->with('es', $es);
            }else{
                Session::flash('errorfitrar', 'No se encontraron registros para la busqueda.');
                return back();
            }
        }else{
            Session::flash('errorfitrar', 'No se encontraron registros para la busqueda.');
            return back();

        }
       
       
    }

    public function categoria(Request $request){
        $cat = RegVotoModel:://se debe validar el periodo de votacion 
                 join('users','postulado.id_postulado', '=', 'users.id')
                ->join('comportamiento_categ','postulado.id_votocat', '=', 'comportamiento_categ.id')
                ->join('roles','users.id_rol', '=', 'roles.id')
                ->join('cargo','users.id_cargo', '=', 'cargo.id')
                ->join('area','cargo.id_area', '=', 'area.id')
                ->join('estavotacion', 'postulado.id_estado', '=', 'estavotacion.id')
                ->where('comportamiento_categ.id', $request->categoria)
                ->where('estavotacion.anio', $request->anio)->where('estavotacion.periodo', $request->per)
                ->select('id_postulado', 'id_votocat', 'estavotacion.anio', 'estavotacion.periodo', 'users.imagen',
                          'users.apellido', 'comportamiento_categ.descripcion as categoria', 'users.name', 'cargo.nombre as nomcar', 'area.nombre as areanom',
                            DB::raw( 'COUNT(postulado.id_votocat) as total'))
                ->groupBy('id_postulado')
                ->groupBy('id_votocat')
                ->get();
        return view('admin.votcat')->with('cat', $cat);

        /*
         ->select('id_postulado', 'id_votocat', 'comportamiento_categ.descripcion as categoria', 'users.name', 
                            DB::raw( 'COUNT(postulado.id_votocat) as total'))
                ->groupBy('id_postulado')
                ->groupBy('id_votocat')

        */
    }
    //=============== votaciones down ==========
    public function excelVotos(Request $request){
      $anio = $request->aniovot;
      $per = $request->pervot;
      $estadovot = $request->usuarios;
      $mensajeEx = '';
      if ($estadovot == 1){
         $tval1 =  RegVotoModel::join('users','postulado.id_postulado', '=', 'users.id')
                    ->join('estavotacion','postulado.id_estado', '=', 'estavotacion.id')
                    ->where('estavotacion.anio', $anio)//se debe validar el periodo de votacion 
                    ->where('estavotacion.periodo', $per)
                    ->count();
        if ($tval1 != 0)
        return Excel::download(new VotosExcel($anio, $per, $estadovot), 'usuarios_recibieron_votos.xlsx');
      }
      elseif ($estadovot == 2){
        $tcat = Comportamiento::count();
        $tval2 = RegVotoModel::join('users','postulado.id_votante', '=', 'users.id')
                        ->join('estavotacion','postulado.id_estado', '=', 'estavotacion.id')
                        ->where('estavotacion.anio', $anio)
                        ->where('estavotacion.periodo', $per)->count();
        if($tval2)
          return Excel::download(new VotosPendientes($anio, $per, $tcat), 'usuarios_que_votaron.xlsx');
      }
      elseif ($estadovot == 3){
        $estado = EstavotModel::where('anio',  $anio)->where('periodo', $per)->first();
        if($estado)
          return Excel::download(new VotosExcel($anio, $per, $estadovot), 'usuarios_que_no_votaron.xlsx');          
        }
        Session::flash('mensajeEx', '¡Lo sentimos!, no hay información para la solicitud.');
        return back();
    }

    // postular a los usuarios para votacion 
    public function postularVot(Request $request){
        $validatedData = $request->validate([
            'user' => 'required|array',
            'user.*' => 'required|integer|exists:users,id'
        ]);

        // Obtiene el array de IDs de usuarios  
        $userIds = $validatedData['user'];
        Usuarios::whereIn('id', $userIds)->update(['postulado' => 1]);
        // Actualiza el campo 'postulado' a 0 para todos los usuarios cuyos IDs no están en el array
        Usuarios::whereNotIn('id', $userIds)->update(['postulado' => 0]);

        return back();
    }
}
