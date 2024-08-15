<?php

namespace App\Http\Controllers\Reconocimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reconocimientos\ReconocimientosModal;
use App\Models\RecibeCatMoldel\RecibirCat;
use App\Models\ModelNotify\Notificacion;
use App\Models\ModelNotify\InsigniaNoti;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\Reconocimiento;//esta varia dependiendo el nombre del archivo 
use App\Mail\InsigniaEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Usuarios\Usuarios;
use App\Models\Insignias\PuntosModel; // para cambiar el nombre de los puntos 
use App\Models\Categorias\Comportamiento;
use App\Models\RecibeCatMoldel\Comentarios;
use App\Models\RecibeCatMoldel\Emoticones;
use App\Models\Insignias\InsigniasModel; 
use  Session;

class ReconocimientosController extends Controller
{
    public function enviar(){
      return redirect('/reconocimientos/usuario');
    }
   //filtrar todos los reconocimientos recibidos
   private function reconocimientosRecibidos($idlog, $fecini = null, $fecfin = null){
       $query = RecibirCat::where('catrecibida.id_user_recibe', '=', $idlog)
              ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
              ->join('users as usu', 'catrecibida.id_user_envia', '=', 'usu.id')
              ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
              ->join('categoria_reconoc', 'catrecibida.id_comportamiento', '=', 'categoria_reconoc.id')
              ->select('catrecibida.id as idcat', 'catrecibida.id_user_recibe', 'catrecibida.detalle as det', 'users.name as nomrecibe', 'usu.name as nomenvia', 'usu.apellido as apenvia', 'comportamiento_categ.descripcion as descat',
                        'categoria_reconoc.nombre as comportamiento', 'catrecibida.puntos', 'catrecibida.fecha', 'comportamiento_categ.rutaimagen as img', 'usu.imagen as fperfil');
        //comparar si existe las fechas inicial y final    
        if ($fecini && $fecfin) {
                $query->whereBetween('catrecibida.fecha', [$fecini, $fecfin]);
        }
      $detalle = $query->orderBy('catrecibida.fecha', 'DESC')->get();
      return $detalle;
   }
   //============= filtrar todos los comentarios ========
   private function comentariosEnc($idlog, $fecini = null){
    $fechanow = Carbon::now()->format('Y-m-d');
    $comentariosquery = Comentarios::join('catrecibida', 'comentarioshistoy.idrec', '=', 'catrecibida.id')
                  ->join('users', 'comentarioshistoy.idusu', '=', 'users.id')
                  ->where('catrecibida.id_user_recibe', $idlog)
                  ->select('comentarioshistoy.comentario', 'catrecibida.id as idrec', 'users.name as nombre', 'users.apellido as apellido', 'users.imagen', 'comentarioshistoy.idusu', 'comentarioshistoy.created_at as fec');

    $emoticonesquery = Emoticones::join('catrecibida', 'emoticones.idrec', '=', 'catrecibida.id')
                  ->where('catrecibida.id_user_recibe', $idlog)
                  ->select('emoticones.idrec', 'emoticones.idemot', 'emoticones.created_at', DB::raw('COUNT(*) as count'));
    if ($fecini) {
        $comentariosquery->whereBetween('comentarioshistoy.created_at', [$fecini, $fechanow]);
        $emoticonesquery->whereBetween('emoticones.created_at', [$fecini, $fechanow]);
    }
    $comentarios = $comentariosquery->orderBy('comentarioshistoy.created_at', 'DESC')->get();
    $emoticones = $emoticonesquery
                  ->groupBy('emoticones.idrec', 'emoticones.idemot', 'emoticones.created_at')
                  ->orderBy('emoticones.idrec')
                  ->orderBy('emoticones.idemot')
                  ->get();
    return [
              'comentarios' => $comentarios,
              'emoticones' => $emoticones
           ];
   }
   // total de reconocimientos recibidos
   public function totreconocimientos($idlog,  $mesActual=null, $anioActual=null){
          $recibidos = RecibirCat::where('catrecibida.id_user_recibe', '=', $idlog)
                        ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                        ->selectRaw('catrecibida.id_user_recibe, users.name as nombre, users.apellido as ape, 
                        SUM(cat1) as c1, SUM(cat2) as c2, SUM(cat3) as c3, SUM(cat4) AS c4, SUM(cat5) AS c5')
                        ->groupBy('id_user_recibe')
                        ->get();
          //============== reconocimientos recibidos en el mes actual ==============
          $rmes = RecibirCat::where('catrecibida.id_user_recibe', '=', $idlog)
                  ->whereMonth('catrecibida.created_at', $mesActual)
                  ->whereYear('catrecibida.created_at', $anioActual)
                  ->count();
          return [
                    'recibidos' => $recibidos,
                    'rmes' => $rmes
                ];
   }
   //=========================================
  private function usuReacciones($usu){
    $res = DB::table('emoticones')
        ->join('users', 'emoticones.iduser', '=', 'users.id')
        ->join('catrecibida', 'emoticones.idrec', '=', 'catrecibida.id')
        ->where('catrecibida.id_user_recibe', $usu)
        ->select('idrec', 'idemot', 'emoticon', 'iduser', 'users.name', 'users.apellido')
        ->orderBy('idrec')
        ->get();
    return $res;
   }
   //============= funcion para retornar los reconocimientos =============
   private function reporte_reconocimiento($idlog, $mesActual, $anioActual, $fecini=Null, $fecfin=Null){
        $recquery = ReconocimientosModal::where('insignia_obtenida.id_usuario', '=', $idlog)
                      ->join('insignia','insignia_obtenida.id_insignia','=','insignia.id')
                      ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                      ->select('insignia.puntos as puntosin', 'insignia_obtenida.id as idinsig',
                        'insignia.name as nominsig', 'insignia_obtenida.fecha', 'insignia_obtenida.created_at', 'insignia_obtenida.puntos_acumulados', 
                        'insignia.descripcion as catinsign', 'insignia.rutaimagen as imginsig',
                        'premios.descripcion as nompremio', 'premios.rutaimagen as imgpremio', 'premios.name as despremio', 'insignia_obtenida.entregado');
        if ($fecini) {
          $recquery->whereBetween('insignia_obtenida.created_at', [$fecini, $fecfin]);
        }
        $rec = $recquery->orderBy('insignia_obtenida.created_at', 'DESC')->get();
        //=== total de insignias obtenidas en el mes ===========
        $inmes = ReconocimientosModal::where('insignia_obtenida.id_usuario', '=', $idlog)
                      ->whereMonth('created_at', $mesActual)
                      ->whereYear('created_at', $anioActual)
                      ->count();
        // =========== insignias a obtener ===================
        $insobtener = InsigniasModel::join('premios', 'id_premio', '=', 'premios.id')
                      ->select('insignia.id', 'insignia.name', 'insignia.descripcion', 'insignia.rutaimagen as imgin', 'insignia.puntos', 'premios.name as despre')
                      ->orderBy('insignia.id', 'ASC')->get();
        return [
                'rec' => $rec,
                'inmes' => $inmes,
                'insobtener' => $insobtener
              ];
    }
   //=========================================
   public function reporteinsig(){
        //consultar reconocimientos recibidos
        $mesActual = Carbon::now()->month;
        $mesActualNombre = Carbon::now()->format('F');
        $anioActual = Carbon::now()->year;
        $fecha = Carbon::now()->format('Y-m-d');
        $idlog=auth()->id();
        $nompuntos = PuntosModel::findOrFail(1);
        $fecini = '';
        $fecfin = '';
        //variables 
        $esta=0;
        $recibidos="sin datos";
        $categoria="sin datos";
        $detalle=[];
        $puntos="sin datos";
        $comentarios = '';
        $usureac = '';
        $emoticones = '';
        $rmes = '';
        // retornar las recompensas 
        $reconocimientosquery = $this->reporte_reconocimiento($idlog, $mesActual, $anioActual);
        $reconocimientos = $reconocimientosquery['rec'];
        $inmes = $reconocimientosquery['inmes'];
        $insobtener = $reconocimientosquery['insobtener'];
        //validdar que existan datos
        $dval=RecibirCat::where('catrecibida.id_user_recibe', '=', $idlog)->count();
        if($dval!=0){
                    $esta=1;
                    $categoria=Comportamiento::all();
                    //============ informacion de tarjetas ==========
                    $recibidosquery =  $this->totreconocimientos($idlog, $mesActual, $anioActual);
                    $recibidos = $recibidosquery['recibidos'];
                    $rmes = $recibidosquery['rmes'];
                    //================================================
                    $detalle = $this->reconocimientosRecibidos($idlog);
                    $resultado = $this->comentariosEnc($idlog);
                    $comentarios = $resultado['comentarios'];
                    $emoticones = $resultado['emoticones'];
                    //========= obtener todas las reacciones ================
                    $usureac = $this->usuReacciones($idlog);       
        }//llave cierre del div
        return view('user.reporteinsignias')->with(['recibidos' => $recibidos, 'categoria' => $categoria, 'detalle' => $detalle, 'fecini' => $fecini, 'fecfin' => $fecfin,
          'reconocimientos' => $reconocimientos, 'esta' => $esta, 'nompuntos' => $nompuntos, 'fecha' => $fecha, 'usureac' => $usureac, 'comentarios' => $comentarios, 'emoticones' => $emoticones,
          'rmes' => $rmes, 'mes' => $mesActualNombre, 'inmes' => $inmes, 'insobtener'=>$insobtener]);
      
  }

//filtrar los dfatos de los reconocimientos obtenidos por fecha
public function filtrarReconocimientos(Request $request){
  $fecini = $request->fecini;
  $fecfin = $request->fecfin;
  $idlog=auth()->id();
  //==============================
  $mesActual = Carbon::now()->month;
  $mesActualNombre = Carbon::now()->format('F');
  $anioActual = Carbon::now()->year;
  $fecha = Carbon::now()->format('Y-m-d');
  $nompuntos = PuntosModel::findOrFail(1);
  $esta = 0;
  //=== obtener los reconocimientos ===
  $reconocimientosquery = $this->reporte_reconocimiento($idlog, $mesActual, $anioActual, $fecini, $fecfin);
  $reconocimientos = $reconocimientosquery['rec'];
  $inmes = $reconocimientosquery['inmes'];
  $insobtener = $reconocimientosquery['insobtener'];
  //=============================
  $dval = RecibirCat::where('catrecibida.id_user_recibe', '=', $idlog)->count();
  if($dval !=0 ){
     $esta = 1;
     $categoria=Comportamiento::all();
     $recibidosquery =  $this->totreconocimientos($idlog, $mesActual, $anioActual);
     $recibidos = $recibidosquery['recibidos'];
     $rmes = $recibidosquery['rmes'];
     //====================
     $detalle = $this->reconocimientosRecibidos($idlog, $fecini, $fecfin);
     $resultado = $this->comentariosEnc($idlog, $fecini);
     $comentarios = $resultado['comentarios'];
     $emoticones = $resultado['emoticones'];
     $usureac = $this->usuReacciones($idlog);

     return view('user.reporteinsignias')->with(['recibidos' => $recibidos, 'categoria' => $categoria, 'detalle' => $detalle, 'fecini' => $fecini, 'fecfin' => $fecfin, 'reconocimientos' => $reconocimientos,
      'esta' => $esta, 'nompuntos' => $nompuntos, 'fecha' => $fecha, 'usureac' => $usureac, 'comentarios' => $comentarios, 'emoticones' => $emoticones, 'rmes' => $rmes, 'mes' => $mesActualNombre, 'inmes' => $inmes, 'insobtener'=>$insobtener]);
    
  }
  return back();
}
   
 /* public function listarrec(){
      $valcateg=Comportamiento::count();
      $nompuntos = PuntosModel::findOrFail(1); // nombre para los puntos
      $uselogeado=auth()->id(); 
      if($valcateg){//valida que por lo menos haya 5 categorias registradas puesto que las tablas donde se asignan los puntos a categoria solamente esta para 5 campos
              $v=Comportamiento::count();
            if($v>1){
              $b=1;
              $categoria=Comportamiento::where('comportamiento_categ.descripcion', '!=', 'Default')->get();
            }else{
              $b=0;
              $categoria=Comportamiento::get();
            }
            $usuarios=Usuarios::where('users.id', '!=', $uselogeado)->where('users.id_rol', '!=', 1)->get();
            //$cat = DB::table('categoria_reconoc')->get();
            /////################################################
            //$contarusu=DB::table('users')->MAX('users.id');
            //$rand = range(2, $contarusu); //obtiene numeros sin repetirse
            //shuffle($rand); //intercala los numeros sin repetirse
            //$totdatos = DB::table('users')->count(); //contar los datos para iterar nuevo random
            //$totdatos = $totdatos-1;
            //$posrand = rand(0, $totdatos);
            //$numberid = $rand[0];         
            //$numberid = mt_Rand(1, $contarusu);
            //$val=DB::table('users')->where('users.id', '=', $numberid)->count();
            //if($val != 0){
            //      $c=1;
             //     $usuazar=DB::table('users')->where('users.id', '=', $numberid)->where('users.id', '!=', $uselogeado)->get();
             // }else{
             // $c=0;
             // $usuazar="sin datos";
          // }
          return view('reconocimientos.listrec')->with('usu', $usuarios)->with('categoria', $categoria)->with('b', $b)->with('nompuntos', $nompuntos);
            /////##############################################
      }else{//sino hay mas de 5 registros solamente retornara un mensaje registre categorias 
        Session::flash('messajeinfo', 'Por Favor Registre Almenos Cinco Categorias!'); 
        return back();
      }     
  }  */

public function listarrec(){
      $valcateg = Comportamiento::count();
      $nompuntos = PuntosModel::findOrFail(1); // nombre para los puntos
      $uselogeado = auth()->id(); 
      if ($valcateg > 0) { // Validar que haya al menos 5 categorías registradas  
          
          $categoria = Comportamiento::all(); // categorias
          $usuarios = Usuarios::where('id', '!=', $uselogeado)
                              ->where('id_rol', '!=', 1)
                              ->select('id', 'name', 'apellido', 'imagen')
                              ->get();
                              
          return view('reconocimientos.listrec')
                  ->with('usu', $usuarios)
                  ->with('categoria', $categoria)
                  ->with('nompuntos', $nompuntos);
      } else {
          // Si no hay más de 5 registros, retorna un mensaje para registrar categorías
          Session::flash('messajeinfo', '¡Por favor registre al menos cinco categorías!'); 
          return back();
      }
  }
  
  
  //funcion para reutilizar
  private function obtenerInsig($idinsig){
           return DB::table('insignia_obtenida')
                    ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                    ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                    ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                    ->join('comportamiento_categ', 'insignia.id_categoria', '=', 'comportamiento_categ.id')
                    ->where('insignia_obtenida.id', $idinsig)
                    ->select('insignia.name', 'insignia.descripcion as nivel',
                            'insignia.puntos as insigpuntos', 'insignia.rutaimagen as imginsig', 'premios.name as premionom', 'premios.descripcion as predes',
                            'premios.rutaimagen as preimagen', 'insignia_obtenida.fecha', 'users.name as nomrecibe', 'users.apellido as aperecibe', 'users.email as correocibe',
                            'comportamiento_categ.descripcion as catinsig')
                    ->first();
  }

  public function recocatguardar(Request $request){
          #======== tener en cuenta las categorias puesto que solamente pueden guardar hasta 5 
          #========= revisar el id que no se pase de 5 
          $idc=$request->idcat;
          $usurecibe = $request->input('usuariosSel');//ids de los usuario quien recibe el reconocimiento
          $date = Carbon::now();
          $listaIds = [];
          //consultar id en la base de datos
          $cat=DB::table('categoria_reconoc')->where('categoria_reconoc.id', '=', $idc)
                ->join('comportamiento_categ', 'id_comportamiento', '=', 'comportamiento_categ.id')
                ->select('categoria_reconoc.puntos', 'comportamiento_categ.id as idcom')
                ->first();
          //consultar las categorias para sacar los id
          $rescate=DB::table('comportamiento_categ')->get();
          $categoria = "cat$cat->idcom"; //referencia de donde guardar el puntaje cat1, cat2 ..
          //========== aqui se guarda los usuarios y categorias y el reconocomiento =====================
          $idlogeado=auth()->id();
         for($i = 0, $size = count($usurecibe); $i < $size; ++$i)  {
              $category = new RecibirCat();
              $category->id_user_recibe = $usurecibe[$i];
              $category->id_user_envia = $idlogeado;
              $category->id_categoria = $cat->idcom;
              $category->id_comportamiento = $idc;
              $category->puntos = $cat->puntos;
              $category->fecha = $date;
              $category->detalle = $request->input('detexto'); //ingresa el detalle de categoria
              $category->$categoria = 1; //aqui guarda el puntaje
              $category->save();
            //====================== aqui se debe guardar las notificaciones =====================
              $noti = new Notificacion();
              $noti->notinom = "Reconocimiento";
              $noti->notides = $request->input('detexto');
              $noti->fecha = $date;
              $noti->estado = "1";
              $noti->idnotifi = $category->id;//recupera la id guardada
              $noti->save();
              //=========================================================
              $listaIds[] = $category->id;
          }
         
          //=======================================Enviar correos======================
          foreach ($listaIds as $idbus) {
              $datosrec =DB::table('catrecibida')->where('catrecibida.id', $idbus)
                        ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                        ->join('categoria_reconoc', 'catrecibida.id_comportamiento', '=', 'categoria_reconoc.id')
                        ->join('users as recibe', 'catrecibida.id_user_recibe', '=', 'recibe.id')
                        ->join('users as envia', 'catrecibida.id_user_envia', '=', 'envia.id')
                        ->select('catrecibida.fecha', 'catrecibida.detalle', 'comportamiento_categ.descripcion as categoria', 
                        'catrecibida.puntos', 'categoria_reconoc.nombre as comportamiento', 'categoria_reconoc.rutaimagen', 
                        'envia.name as nomenvia', 'envia.apellido as apenvia', 'recibe.name as nomrecibe', 'recibe.apellido as aperecibe', 'recibe.email as correocibe')
                        ->first();
              Mail::to($datosrec->correocibe)->queue(new Reconocimiento($datosrec)); //envia mensajes
          }
          //==================aqui se debe verificar si gano una insignia========================================
      
        foreach ($usurecibe as $idser) {
          // puntos obtenidos por categoria seleccionada
          $puntosreco =DB::table('catrecibida')
                    ->where('catrecibida.id_user_recibe', '=', $idser)
                    ->where('catrecibida.id_categoria', '=', $cat->idcom)
                    ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                    ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                    ->selectRaw('comportamiento_categ.descripcion as nom, SUM(catrecibida.puntos) as p')
                    ->groupBy('id_categoria')
                    ->get();
          // puntos obtenidos la sumatoria de todas las categporias
          $puntostotales =DB::table('catrecibida')
                        ->where('catrecibida.id_user_recibe', '=', $idser)
                        ->selectRaw('SUM(catrecibida.puntos) as p')
                        ->get();
          // puntos totales de insignia de puntos  
          $insignia_puntos = DB::table('insignia')->where('insignia.tipo', '=', 1)->get();
          // puntos de insignia por cada categoria
           $puntosinsig = DB::table('insignia')->where('insignia.id_categoria', '=', $cat->idcom)->get();

        for($i = 0, $size = count($puntosinsig); $i < $size; ++$i) {
          if($puntosinsig[$i]->puntos == $puntosreco[0]->p){
                $idinsignia = DB::table('insignia')->where('insignia.puntos', '=', $puntosreco[0]->p)->select('insignia.id as id')->first();
                $inobtenida = new ReconocimientosModal();
                $inobtenida->id_insignia = $idinsignia->id;
                $inobtenida->id_usuario = $idser;
                $inobtenida->fecha =$date;
                $inobtenida->puntos_acumulados = $puntosreco[0]->p;
                $inobtenida->entregado =1;
                $inobtenida->save();

                //guardar la notificacion de insignia obtenida
                $Gnoty= new InsigniaNoti();
                $Gnoty->id_insignoti = $inobtenida->id;
                $Gnoty->estado = "1";
                $Gnoty->save();

                //enviar correo si gano una insignia
               $datosin = $this->obtenerInsig($inobtenida->id);
    
               Mail::to($datosin->correocibe)->queue(new InsigniaEmail($datosin)); //envia mensajes   

          }
            
         }
       } //cerrar el for
        //===================== recorrer los puntos de insignias totales ==========
        foreach($insignia_puntos as $insig){
          if($puntostotales[0]->p >= $insig->puntos){
              $validar_insignia = ReconocimientosModal::where('id_insignia', $insig->id)->where('id_usuario', $idser)->count();
              if($validar_insignia == 0){
                $insigobtenida = new ReconocimientosModal();
                $insigobtenida->id_insignia = $insig->id;
                $insigobtenida->id_usuario = $idser;
                $insigobtenida->fecha =$date;
                $insigobtenida->puntos_acumulados = $insig->puntos;
                $insigobtenida->entregado =1;
                $insigobtenida->save();
                
                //guardar la notificacion de insignia obtenida
                $Innoty= new InsigniaNoti();
                $Innoty->id_insignoti = $insigobtenida->id;
                $Innoty->estado = "1";
                $Innoty->save();

                $datosinsigniapuntos =  DB::table('insignia_obtenida')
                                        ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                                        ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                                        ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                                        ->where('insignia_obtenida.id', $insigobtenida->id)
                                        ->select('insignia.name', 'insignia.descripcion as nivel',
                                                'insignia.puntos as insigpuntos', 'insignia.rutaimagen as imginsig', 'premios.name as premionom', 'premios.descripcion as predes',
                                                'premios.rutaimagen as preimagen', 'insignia_obtenida.fecha', 'users.name as nomrecibe', 'users.apellido as aperecibe', 'users.email as correocibe')
                                        ->first();
    
               Mail::to($datosinsigniapuntos->correocibe)->queue(new InsigniaEmail($datosinsigniapuntos)); //envia mensajes
            }
          }
        }
        //sacar un aleatorio para sugerencia
        $us = auth()->id();
        foreach($usurecibe as $k){
          $usuazar = Usuarios::where('id', '!=', $k)
                    ->where('id_rol', '!=', '1')
                    ->where('id', '!=', $us)   // Filtrar por roles diferentes de 1
                    ->inRandomOrder()
                    ->limit(2)
                    ->get(); 
        }
      return response(json_decode($usuazar),200)->header('Content-type', 'text/plain');
      //return back();
    }

  //================ metricas ===================================
  private function obtenerPuntos($users){
    $recibidos = [];
    foreach($users as $usu){
      $info_usuario = DB::table('catrecibida')
                  ->where('catrecibida.id_user_recibe', '=', $usu->id)
                  ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                  ->selectRaw('catrecibida.id_user_recibe, users.name as nombre, users.apellido as ape, 
                    SUM(cat1) as c1, SUM(cat2) as c2, SUM(cat3) as c3, SUM(cat4) AS c4, SUM(cat5) AS c5, SUM(cat1+cat2+cat3+cat4+cat5) AS tot') 
                  ->get();
     // Agregar la información del usuario al array $recibidos
     $recibidos[] = $info_usuario;
    }
    if (!empty($recibidos)) {
      $recibidos = collect($recibidos);
      $recibidos = $recibidos->sortByDesc(function ($usuario) {
          return $usuario[0]->tot ?? 0; // Devuelve 0 si tot no está definido
      });
    }
    return $recibidos;
  }
  //============== metricas delñ ranking administrador ===============
  public function metricasranking(){
      $categoria=DB::table('comportamiento_categ')->select('id', 'descripcion')->get();
      $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
      
      //============ contar la informacion de insignias obtenidas
      $insig_recibidas = DB::table('insignia_obtenida')
                        ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                        ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                        ->select('insignia_obtenida.id_usuario', 'users.name as nombre', 'users.apellido as ape', 'insignia.id as idinsig', 'insignia.descripcion as des', 'insignia.name as insignom')
                        ->get();
     //============ llamar  a la funcion de puntos ============
     $recibidos = $this->obtenerPuntos($users);
    return  view('metricas.avance')->with('recibidos', $recibidos)->with('categoria', $categoria)->with('insignias', $insig_recibidas)->with('users', $users);
  }
  //===============================
  private function cambiarDatos($datos_iniciales){
    // Estructura de datos final
    $datos_finales = [];

    // Concatenar las matrices internas en una sola matriz
    foreach ($datos_iniciales as $matriz) {
        $datos_finales = array_merge($datos_finales, $matriz);
    }
    return $datos_finales;
  }
 //======================================== metricas para el usuario =====================
 public function metricasusers(){
  $usersnew = [];
  $id_usuario_logueado = auth()->id();
  #======= obtener los datos de puntos del usuario logeado ============
  $info_usuario = DB::table('catrecibida')
                  ->where('catrecibida.id_user_recibe', '=', $id_usuario_logueado)
                  ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                  ->selectRaw('catrecibida.id_user_recibe, users.name as nombre, users.apellido as ape, 
                    SUM(cat1) as c1, SUM(cat2) as c2, SUM(cat3) as c3, SUM(cat4) AS c4, SUM(cat5) AS c5, SUM(cat1+cat2+cat3+cat4+cat5) AS tot') 
                  ->get();
  
  $categoria = DB::table('comportamiento_categ')->select('id', 'descripcion')->get();
  $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
  $recibidos = $this->obtenerPuntos($users);
  $datos = json_decode($recibidos, TRUE); //llamado a la funcion
  //return $datos;
  //=======================
  function calcular_distancia($a, $b) {
        return abs($a - $b);
  }
  $valores_cercanos = [];
  foreach ($datos as $usuario) {
      foreach ($usuario as $datos_usuario) {
          if ($datos_usuario['id_user_recibe'] !== null) {
              $distancia = calcular_distancia($info_usuario[0]->tot, $datos_usuario['tot']);
              $valores_cercanos[$datos_usuario['id_user_recibe']] = $distancia;
          }
      }
  }
  asort($valores_cercanos);
  // Obtener los tres valores más cercanos
  $usuarios_cercanos = array_slice($valores_cercanos, 0, 6, true);
  //iterar sobre la nueva lista de usuarios
  /*foreach($usuarios_cercanos as $id_usuario => $valor){
    $usersnew_info = Usuarios::where('id', '=', $id_usuario)->select('id', 'name', 'apellido')->get();
    $usersnew[] = $usersnew_info;
  }*/
  // convertir datos 
  //$recibidosnew = $this->obtenerPuntos($usersnew);
  //return $recibidosnew;
  return  view('metricas.posicion')->with('recibidos', $recibidos)->with('categoria', $categoria)->with('cercanos', $usuarios_cercanos);
 }
 //==========================obtner los usuarios a los que reconocio=====================
  public function recenviados(){
    $iduser = auth()->id();
    $datos = RecibirCat::where('id_user_envia', $iduser)
             ->join('users', 'id_user_recibe', '=', 'users.id')
             ->join('categoria_reconoc', 'catrecibida.id_comportamiento', '=', 'categoria_reconoc.id')
             ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
             ->select('users.id as iduser', 'users.name', 'users.apellido', 'comportamiento_categ.descripcion as cate', 'comportamiento_categ.rutaimagen as imgcat', 'categoria_reconoc.nombre as comportamiento', 'users.apellido', 'fecha', 'catrecibida.puntos as puntaje', 'detalle')
             ->get();
    // agrupacion de datos
    $agrupados = collect($datos)->groupBy('iduser'); // agrupa los datos en una coleccion a traves de una id
    return view('metricas.recenviados')->with('agrupados', $agrupados);
  }

 //===================== reconocimientos enviados admin===========================
 private function obtenerPuntosEnvia($users){
  $recibidos = [];
  foreach($users as $usu){
    $info_usuario = DB::table('catrecibida')
                ->where('catrecibida.id_user_envia', '=', $usu->id)
                ->join('users', 'catrecibida.id_user_envia', '=', 'users.id')
                ->selectRaw('catrecibida.id_user_envia, users.name as nombre, users.apellido as ape, 
                  SUM(cat1) as c1, SUM(cat2) as c2, SUM(cat3) as c3, SUM(cat4) AS c4, SUM(cat5) AS c5, SUM(cat1+cat2+cat3+cat4+cat5) AS tot') 
                ->get();
   // Agregar la información del usuario al array $recibidos
   $recibidos[] = $info_usuario;
  }
    if (!empty($recibidos)) {
      $recibidos = collect($recibidos);
      $recibidos = $recibidos->sortByDesc(function ($usuario) {
          return $usuario[0]->tot ?? 0; // Devuelve 0 si tot no está definido
      });
    }
    return $recibidos;
  }
  //=============================================
  public function metricasEnvio(){
    $categoria = Comportamiento::all();
    $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();

    $recibidos = $this->obtenerPuntosEnvia($users);
    return view('metricas.adminenviados')->with('categoria', $categoria)->with('recibidos', $recibidos);
  }
  //============================================
}
