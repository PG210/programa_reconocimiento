<?php

namespace App\Http\Controllers\Reconocimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reconocimientos\ReconocimientosModal;
use App\Models\RecibeCatMoldel\RecibirCat;
use App\Models\ModelNotify\Notificacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use  Session;

class ReconocimientosController extends Controller
{
    public function enviar(){
        $idusu=auth()->id();
        $usu=DB::table('users')->where('users.id', '!=', $idusu)->get();
        return view('reconocimientos.enviar')->with('usu', $usu);
    }

   public function reporteinsig(){
        //consultar reconocimientos recibidos
        $idlog=auth()->id();
        //validdar que existan datos
        $dval=DB::table('catrecibida')->where('catrecibida.id_user_recibe', '=', $idlog)->count();
        if($dval!=0){
                    $esta=1;
                    $recibidos = DB::table('catrecibida')
                      ->where('catrecibida.id_user_recibe', '=', $idlog)
                      ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                      ->selectRaw('catrecibida.id_user_recibe, users.name as nombre, users.apellido as ape, 
                      SUM(cat1) as c1, SUM(cat2) as c2, SUM(cat3) as c3, SUM(cat4) AS c4, SUM(cat5) AS c5')
                      ->groupBy('id_user_recibe')
                      ->get();
                    $categoria=DB::table('comportamiento_categ')->get();
                    $detalle = DB::table('catrecibida')
                      ->where('catrecibida.id_user_recibe', '=', $idlog)
                      ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                      ->join('users as usu', 'catrecibida.id_user_envia', '=', 'usu.id')
                      ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                      ->join('categoria_reconoc', 'catrecibida.id_comportamiento', '=', 'categoria_reconoc.id')
                      ->select('catrecibida.id_user_recibe', 'catrecibida.detalle as det', 'users.name as nomrecibe', 'usu.name as nomenvia', 'usu.apellido as apenvia', 'comportamiento_categ.descripcion as descat',
                                'categoria_reconoc.nombre as comportamiento', 'catrecibida.puntos', 'catrecibida.fecha')
                      ->get();
                    $puntos =DB::table('catrecibida')
                    ->where('catrecibida.id_user_recibe', '=', $idlog)
                    ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                    ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                    ->selectRaw('comportamiento_categ.descripcion as nom, SUM(catrecibida.puntos) as p')
                    ->groupBy('id_categoria')
                    ->get();
            //return 
        }//llave cierre del div
        else{
          $esta=0;
          $recibidos="sin datos";
          $categoria="sin datos";
          $detalle="sin datos";
          $puntos="sin datos";
        }
        return view('user.reporteinsignias')->with('recibidos', $recibidos)->with('categoria', $categoria)->with('detalle', $detalle)->with('puntos', $puntos)->with('esta', $esta);
   }
           //////////
           //////////


   public function reporte_reconocimiento(){
        $idlog=auth()->id();
        //validar si una persona tiene insignias 
        $validar=DB::table('insignia_obtenida')->where('insignia_obtenida.id_usuario', '=', $idlog)->count();
       if($validar!=0){
              $b=1;
              $rec = DB::table('insignia_obtenida')->where('insignia_obtenida.id_usuario', '=', $idlog)
              ->join('insignia','insignia_obtenida.id_insignia','=','insignia.id')
              ->join('comportamiento_categ','insignia.id_categoria','=','comportamiento_categ.id')
              //se debe cambiar la categoria_reconoc por comportamiento_categ en la tabla de la base de datos
              ->join('users','insignia_obtenida.id_usuario','=','users.id')
              ->join('premios', 'insignia.id_premio', '=', 'premios.id')
              ->select('insignia.puntos as puntosin', 'insignia_obtenida.id as idinsig',
              'insignia.name as nominsig', 'insignia_obtenida.fecha', 'insignia_obtenida.puntos_acumulados', 
              'insignia.descripcion as catinsign', 'insignia.rutaimagen as imginsig',
                'premios.descripcion as nompremio', 'premios.rutaimagen as imgpremio', 'premios.name as despremio', 
                'users.name as nomusu', 'users.apellido as apeusu')
              ->get();
          //consultar las insignias para colocar la estrella
                  $insign = DB::table('insignia_obtenida')->where('insignia_obtenida.id_usuario', '=', $idlog)
                  ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                  ->join('insignia','insignia_obtenida.id_insignia','=','insignia.id')
                  ->selectRaw('insignia.name as nom, insignia.descripcion as des')
                  ->get();
                  //return $insign;

       }else{
       
          $rec="Sin datos";
          $insign="sin datos";
          $b=0;
       }

    return view('reconocimientos.listar')->with('rec',$rec)->with('insign',$insign)->with('b',$b);
}
  public function listarrec($id){
      $valcateg=DB::table('comportamiento_categ')->count();
      if($valcateg>=5){//valida que por lo menos haya 5 categorias registradas puesto que las tablas donde se asignan los puntos a categoria solamente esta para 5 campos
              $v=DB::table('comportamiento_categ')->count();
            if($v>1){
              $b=1;
              $categoria=DB::table('comportamiento_categ')->where('comportamiento_categ.descripcion', '!=', 'Default')->get();
            }else{
              $b=0;
              $categoria=DB::table('comportamiento_categ')->get();
            }
            $usu =DB::table('users')->where('users.id', '=', $id)->get();
            $cat =DB::table('categoria_reconoc')->get();
            /////################################################
            $contarusu=DB::table('users')->MAX('users.id');
            $uselogeado=auth()->id();
            $numberid = mt_Rand(1, $contarusu);
            $val=DB::table('users')->where('users.id', '=', $numberid)->count();
            if($numberid!=$uselogeado && $val!=0){
                  $c=1;
                  $usuazar=DB::table('users')->where('users.id', '=', $numberid)->get();
              }else{
              $c=0;
              $usuazar="sin datos";
          }
          return view('reconocimientos.listrec')->with('cat', $cat)->with('usu', $usu)->with('categoria', $categoria)->with('b', $b)->with('usuazar',$usuazar)->with('c',$c);
            /////##############################################
      }else{//sino hay mas de 5 registros solamente retornara un mensaje registre categorias 
        Session::flash('messajeinfo', 'Por Favor Registre Almenos Cinco Categorias!'); 
        return back();
      }
      
      
  }   

    public function recocatguardar(Request $request){
          $idc=$request->idcat;
          $usurecibe = $request->idusu; //id del usuario quien recibe el reconocimiento
          $date = Carbon::now();
         
          //consultar id en la base de datos

          $cat=DB::table('categoria_reconoc')->where('categoria_reconoc.id', '=', $idc)
                ->join('comportamiento_categ', 'id_comportamiento', '=', 'comportamiento_categ.id')
                ->select('comportamiento_categ.puntos', 'comportamiento_categ.id as idcom')
                ->first();
          //####################
          //###################
          //consultar las categorias para sacar los id
          $rescate=DB::table('comportamiento_categ')->get();
          //#####################
          $idlogeado=auth()->id();
          $category = new RecibirCat();
          $category->id_user_recibe = $request->input('idusu');
          $category->id_user_envia = $idlogeado;
          $category->id_categoria = $cat->idcom;
          $category->id_comportamiento = $idc;
          $category->puntos = $cat->puntos;
          $category->fecha = $date;
          $category->detalle = $request->input('detexto'); //ingresa el detalle de categoria
          if($rescate[0]->id== $cat->idcom){ //compara las categorias para saber donde guardar
            if($category->cat1 == null){
              $category->cat1 = 1;
            }
            else{
              $category->cat1 = $category->cat1+1;
            }
          }
          if($rescate[1]->id== $cat->idcom){ //compara las categorias para saber donde guardar
            if($category->cat2 == null){
              $category->cat2 = 1;
            }
            else{
              $category->cat2 = $category->cat2+1;
            }
          }
          if($rescate[2]->id== $cat->idcom){ //compara las categorias para saber donde guardar
            if($category->cat3 == null){
              $category->cat3 = 1;
            }
            else{
              $category->cat3 = $category->cat3+1;
            }
          }
          if($rescate[3]->id== $cat->idcom){ //compara las categorias para saber donde guardar
            if($category->cat4 == null){
              $category->cat4 = 1;
            }
            else{
              $category->cat4 = $category->cat4+1;
            }
          }
          if($rescate[4]->id== $cat->idcom){ //compara las categorias para saber donde guardar
            if($category->cat5 == null){
              $category->cat5 = 1;
            }
            else{
              $category->cat5 = $category->cat5+1;
            }
          }
          $category->save();
          /////////#################################################
          //guardar notificacion si ganó una recompennsa
          //$consul = DB::table('catrecibida')->where('id_user_recibe', $usurecibe)->
          $noti = new Notificacion();
          $noti->notinom = "Reconocimiento";
          $noti->notides = $request->input('detexto');
          $noti->fecha = $date;
          $noti->estado = "1";
          $noti->idnotifi = $category->id;//recupera la id guardada
          $noti->save();
          
          //finalizar guardar notificacion


          ///aqui se debe verificar si gano una insignia

     $puntosreco =DB::table('catrecibida')
                    ->where('catrecibida.id_user_recibe', '=', $usurecibe)
                    ->where('catrecibida.id_categoria', '=', $cat->idcom)
                    ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                    ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                    ->selectRaw('comportamiento_categ.descripcion as nom, SUM(catrecibida.puntos) as p')
                    ->groupBy('id_categoria')
                    ->get();
          
       $puntosinsig = DB::table('insignia')->where('insignia.id_categoria', '=', $cat->idcom)->get();

        for($i = 0, $size = count($puntosinsig); $i < $size; ++$i) {
          if($puntosinsig[$i]->puntos == $puntosreco[0]->p){
                $idinsignia = DB::table('insignia')->where('insignia.puntos', '=', $puntosreco[0]->p)->select('insignia.id as id')->first();
                //guardar la insignia
                //faltaria validar que haya un numero asociado a la o multiplo de la suma 
                //en las insignias con el numero de puntaje de las categorias es decir 
                // ejemplo 1200 puntaje de la insignia y la categoria de reconocimiento tiene 
                // 400 entonces recibiria una insignia cuando se obtenga 3 reconocimientos 
                // en la misma categoria
                //tambien se ve la nececsidad de asociar las insignias a una categoria determinada 
                //hasta el momento estan sueltas las insignias se puede ganar cualquier
                //insignia cuando se alcance le puntaje lo que no es recomendable
                $inobtenida = new ReconocimientosModal();
                $inobtenida->id_insignia = $idinsignia->id;
               // $inobtenida->id_categoria = $cat->idcom;
                $inobtenida->id_usuario = $usurecibe;
                $inobtenida->fecha =$date;
                $inobtenida->puntos_acumulados = $puntosreco[0]->p;
                $inobtenida->save();
          }
            
        }
        
          return back();
    }


}
