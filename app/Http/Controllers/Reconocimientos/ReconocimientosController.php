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
use App\Mail\Reconocimiento; //esta varia dependiendo el nombre del archivo 
use App\Mail\InsigniaEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Usuarios\Usuarios;
use App\Models\Insignias\PuntosModel; // para cambiar el nombre de los puntos 
use App\Models\Categorias\Comportamiento;
use App\Models\RecibeCatMoldel\Comentarios;
use App\Models\RecibeCatMoldel\Emoticones;
use App\Models\Insignias\InsigniasModel;
use Illuminate\Support\Facades\Session;
//=======================================
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RecObtenidos;
use App\Exports\PuntosExport;
//========== librerias para el servicio 
use App\Services\MicrosoftGraphService;
use App\Models\Token;

use App\Jobs\SendMailJob; // Importa el job


class ReconocimientosController extends Controller
{
  protected $graphService;

  public function __construct(MicrosoftGraphService $graphService)
  {
    $this->graphService = $graphService;
  }
  //============================================
  public function enviar()
  {
    return redirect('/reconocimientos/usuario');
  }
  //filtrar todos los reconocimientos recibidos
  private function reconocimientosRecibidos($idlog, $fecini = null, $fecfin = null)
  {
    $query = RecibirCat::where('catrecibida.id_user_recibe', '=', $idlog)
      ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
      ->join('users as usu', 'catrecibida.id_user_envia', '=', 'usu.id')
      ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
      ->join('categoria_reconoc', 'catrecibida.id_comportamiento', '=', 'categoria_reconoc.id')
      ->select(
        'catrecibida.id as idcat',
        'catrecibida.id_user_recibe',
        'catrecibida.detalle as det',
        'users.name as nomrecibe',
        'usu.name as nomenvia',
        'usu.apellido as apenvia',
        'comportamiento_categ.descripcion as descat',
        'categoria_reconoc.nombre as comportamiento',
        'catrecibida.puntos',
        'catrecibida.fecha',
        'comportamiento_categ.rutaimagen as img',
        'usu.imagen as fperfil'
      );
    //comparar si existe las fechas inicial y final    
    if ($fecini && $fecfin) {
      $query->whereBetween('catrecibida.fecha', [$fecini, $fecfin]);
    }
    $detalle = $query->orderBy('catrecibida.fecha', 'DESC')->get();
    return $detalle;
  }
  //funcion para obtener los reconocimientos recibidos agrupados en mes y categoria
  private function reconocimientosRecibidosDate($idlog){
    $anioActual = Carbon::now()->year;
    $query = RecibirCat::where('catrecibida.id_user_recibe', '=', $idlog)
            ->whereYear('catrecibida.fecha', $anioActual)
            ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
            ->select(
                DB::raw('MONTH(catrecibida.fecha) as mes'),
                'catrecibida.id_categoria as idcat',
                'comportamiento_categ.descripcion as descat',
                DB::raw('COUNT(catrecibida.id_categoria) as total')
            )
            ->groupBy('mes', 'idcat', 'descat') // Agrupamos por mes y id_categoria
            ->orderBy('mes') // ordenar por mes
            ->get();
    
    return $query;
   
  }
  //============== funcion para obtener la categoria mas votada ===========
  private function moreCat($idlog, $monthStart = null, $monthEnd = null, $quarterStart = null, $quarterEnd = null){
      //$anio = Carbon::now()->year;
     
      $query = DB::table('catrecibida')
                            ->where('id_user_recibe', '=', $idlog)
                            ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                            ->select('id_categoria', 'comportamiento_categ.descripcion as nomcat', DB::raw('COUNT(id_categoria) as total'))
                            //->whereYear('catrecibida.fecha', $anio)
                            ->when(!empty($monthStart) && !empty($monthEnd), function ($query) use ($monthStart, $monthEnd) {
                                  $query->whereBetween('catrecibida.created_at', [$monthStart, $monthEnd]);
                            })
                            ->groupBy('id_categoria')
                            ->orderByDesc('total')
                            ->first();
      //buscar la persona que mas te reconocio
      $userenvia = DB::table('catrecibida')
                            ->where('id_user_recibe', '=', $idlog)
                            ->join('users', 'catrecibida.id_user_envia', '=', 'users.id')
                            ->select('id_user_envia', 'users.name as nombre', 'users.apellido', DB::raw('COUNT(id_user_envia) as total'))
                            //->whereYear('catrecibida.fecha', $anio)
                            ->when(!empty($monthStart) && !empty($monthEnd), function ($query) use ($monthStart, $monthEnd) {
                                  $query->whereBetween('catrecibida.created_at', [$monthStart, $monthEnd]);
                              })
                            ->groupBy('id_user_Envia')
                            ->orderByDesc('total')
                            ->first();

      //porcentaje de reconocimientos recibidos en el mes
      if(!$monthStart){
          //mese actual
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
  
        //trimestre
        $quarterStart = Carbon::now()->startOfQuarter(); // Inicio del trimestre
        $quarterEnd = Carbon::now()->endOfQuarter(); // Fin del trimestre
      }
    
      // Obtener el total de reconocimientos por usuario en el mes actual
      $users = Usuarios::select('users.id')
                ->selectRaw('COUNT(catrecibida.id) as totalrec')
                ->leftJoin('catrecibida', function ($join) use ($monthStart, $monthEnd) {
                    $join->on('users.id', '=', 'catrecibida.id_user_recibe')
                        ->whereBetween('catrecibida.created_at', [$monthStart, $monthEnd]);
                })
                ->groupBy('users.id')
                ->orderByDesc('totalrec')
                ->get();
      // Convertir en un array indexado para encontrar la posición del usuario
      $rankUsers = $users->pluck('totalrec', 'id')->toArray();
      $userPosition = array_search($idlog, array_keys($rankUsers));

      // Calcular el percentil
      //Solo el (L/N)*100% de los usuarios tienen un valor superior a valor del usuario. Esto indica que un usuario con un valor de x está en una posición relativamente alta en la distribución de los valores.
      $totalUsers = count($rankUsers);
      $userPercentil = round(100 - (($userPosition / $totalUsers) * 100), 1);
      
      //obtener el top de posicion
      $usertop = Usuarios::select('users.id')
                          ->selectRaw('COUNT(catrecibida.id) as totalrec')
                          ->leftJoin('catrecibida', function ($join) use ($quarterStart, $quarterEnd) {
                              $join->on('users.id', '=', 'catrecibida.id_user_recibe')
                                  ->whereBetween('catrecibida.created_at', [$quarterStart, $quarterEnd]);
                          })
                          ->groupBy('users.id')
                          ->orderByDesc('totalrec')
                          ->get();
      
      
      // Convertir en un array indexado para encontrar la posición del usuario
      $ranktop = $usertop->pluck('totalrec', 'id')->toArray();
      $rankedUserIds = array_keys($ranktop); // IDs ordenados

      $userPositionTop = array_search($idlog, $rankedUserIds);
      $totalUsersTop = count($rankedUserIds);

      // Calcular el percentil
      $userPercentile = round(100 - (($userPositionTop / $totalUsersTop) * 100), 2);
      
      $topX = 100 - floor($userPercentile); //top exacto donde se encuentra para el usuario
      
      $datos = [
        'morecat' => $query,
        'userenvia' => $userenvia,
        'percentil' => $userPercentil,
        'topx' => $topX
      ];
      
      return $datos;
  }
  //============= filtrar todos los comentarios ========
  private function comentariosEnc($idlog, $fecini = null)
  {
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
  public function totreconocimientos($idlog,  $mesActual = null, $anioActual = null)
  {
    $recibidos = RecibirCat::where('catrecibida.id_user_recibe', '=', $idlog)
                //->when(!empty($mesActual),  function ($query) use ($mesActual, $anioActual) {
                 //     $query->whereBetween('catrecibida.created_at', [$mesActual, $anioActual]);
                 //   })
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
  private function usuReacciones($usu)
  {
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
  private function reporte_reconocimiento($idlog, $mesActual, $anioActual, $fecini = Null, $fecfin = Null)
  {
    $recquery = ReconocimientosModal::where('insignia_obtenida.id_usuario', '=', $idlog)
      ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
      ->join('premios', 'insignia.id_premio', '=', 'premios.id')
      ->select(
        'insignia.puntos as puntosin',
        'insignia_obtenida.id as idinsig',
        'insignia.name as nominsig',
        'insignia_obtenida.fecha',
        'insignia_obtenida.created_at',
        'insignia_obtenida.puntos_acumulados',
        'insignia.descripcion as catinsign',
        'insignia.rutaimagen as imginsig',
        'premios.descripcion as nompremio',
        'premios.rutaimagen as imgpremio',
        'premios.name as despremio',
        'insignia_obtenida.entregado'
      );
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
  public function reporteinsig()
  {
    //consultar reconocimientos recibidos
    $mesActual = Carbon::now()->month;
    $mesActualNombre = Carbon::now()->format('F');
    $anioActual = Carbon::now()->year;
    $fecha = Carbon::now()->format('Y-m-d');
    $idlog = auth()->id();
    $nompuntos = PuntosModel::findOrFail(1); //nombre de los puntos
    //return $nompuntos;
    $fecini = '';
    $fecfin = '';
    //variables 
    $esta = 0;
    $recibidos = "sin datos";
    $categoria = "sin datos";
    $detalle = [];
    $comentarios = '';
    $usureac = '';
    $emoticones = '';
    $rmes = '';
    $puntos = 0;
    $rectime = '';
    $morecat = '';
    // retornar las recompensas 
    $reconocimientosquery = $this->reporte_reconocimiento($idlog, $mesActual, $anioActual);
    $reconocimientos = $reconocimientosquery['rec'];
    $inmes = $reconocimientosquery['inmes'];
    $insobtener = $reconocimientosquery['insobtener'];
    //validdar que existan datos
    $dval = RecibirCat::where('catrecibida.id_user_recibe', '=', $idlog)->count();
    if ($dval != 0) {
      $esta = 1;
      $categoria = Comportamiento::all();
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
      $puntos = RecibirCat::where('id_user_recibe', '=', $idlog)->selectRaw('SUM(puntos) as p')->first(); //puntos obtenidos
      $rectime = $this->reconocimientosRecibidosDate($idlog); //reconocimientos recibidos en el tiempo
      
      
      $morecat = $this->moreCat($idlog);
      //return $morecat;

    } //llave cierre del div
    return view('user.reporteinsignias')->with([
      'recibidos' => $recibidos,
      'categoria' => $categoria,
      'detalle' => $detalle,
      'fecini' => $fecini,
      'fecfin' => $fecfin,
      'reconocimientos' => $reconocimientos,
      'esta' => $esta,
      'nompuntos' => $nompuntos,
      'fecha' => $fecha,
      'usureac' => $usureac,
      'comentarios' => $comentarios,
      'emoticones' => $emoticones,
      'rmes' => $rmes,
      'mes' => $mesActualNombre,
      'inmes' => $inmes,
      'insobtener' => $insobtener,
      'puntos' => $puntos,
      'rectime' => $rectime,
      'morecat' => $morecat
    ]);
  }

  //filtrar los dfatos de los reconocimientos obtenidos por fecha
  public function filtrarReconocimientos(Request $request)
  {
    $fecini = $request->fecini;
    $fecfin = $request->fecfin;
    $idlog = auth()->id();
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
    if ($dval != 0) {
      $esta = 1;
      $categoria = Comportamiento::all();
      $recibidosquery =  $this->totreconocimientos($idlog, $fecini, $fecfin);
      $recibidos = $recibidosquery['recibidos'];
      $rmes = $recibidosquery['rmes'];
      //====================
      $detalle = $this->reconocimientosRecibidos($idlog, $fecini, $fecfin);
      $resultado = $this->comentariosEnc($idlog, $fecini);
      $comentarios = $resultado['comentarios'];
      $emoticones = $resultado['emoticones'];
      $usureac = $this->usuReacciones($idlog);

      $puntos = RecibirCat::where('id_user_recibe', '=', $idlog)->selectRaw('SUM(puntos) as p')->first(); //puntos obtenidos
      $rectime = $this->reconocimientosRecibidosDate($idlog); //reconocimientos recibidos en el tiempo
     
      $morecat = $this->moreCat($idlog, $fecini,
                                $fecfin, $fecini, $fecfin);
      //return $recibidos;
      return view('user.reporteinsignias')->with([
        'recibidos' => $recibidos,
        'categoria' => $categoria,
        'detalle' => $detalle,
        'fecini' => $fecini,
        'fecfin' => $fecfin,
        'reconocimientos' => $reconocimientos,
        'esta' => $esta,
        'nompuntos' => $nompuntos,
        'fecha' => $fecha,
        'usureac' => $usureac,
        'comentarios' => $comentarios,
        'emoticones' => $emoticones,
        'rmes' => $rmes,
        'mes' => $mesActualNombre,
        'inmes' => $inmes,
        'insobtener' => $insobtener,
        'puntos' => $puntos,
        'rectime' => $rectime,
        'morecat' => $morecat

      ]);
    }
    return back();
  }

  public function listarrec()
  {
    setlocale(LC_TIME, 'es_ES');

    $valcateg = Comportamiento::count();
    $nompuntos = PuntosModel::findOrFail(1); // nombre para los puntos
    $uselogeado = auth()->id();
    $fechaActual = Carbon::now()->translatedFormat('d F, Y');

    if ($valcateg > 0) { // Validar que haya al menos 5 categorías registradas  

      $categoria = Comportamiento::all(); // categorias
      $usuarios = Usuarios::where('id', '!=', $uselogeado)
        ->where('id_rol', '!=', 1)
        ->select('id', 'name', 'apellido', 'imagen')
        ->get();

      return view('reconocimientos.listrec')
        ->with('usu', $usuarios)
        ->with('categoria', $categoria)
        ->with('nompuntos', $nompuntos)
        ->with('fecha', $fechaActual);
    } else {
      // Si no hay más de 5 registros, retorna un mensaje para registrar categorías
      Session::flash('messajeinfo', '¡Por favor registre al menos cinco categorías!');
      return back();
    }
  }


  //funcion para reutilizar
  private function obtenerInsig($idinsig)
  {
    return DB::table('insignia_obtenida')
      ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
      ->join('premios', 'insignia.id_premio', '=', 'premios.id')
      ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
      ->join('comportamiento_categ', 'insignia.id_categoria', '=', 'comportamiento_categ.id')
      ->where('insignia_obtenida.id', $idinsig)
      ->select(
        'insignia.name',
        'insignia.descripcion as nivel',
        'insignia.puntos as insigpuntos',
        'insignia.rutaimagen as imginsig',
        'premios.name as premionom',
        'premios.descripcion as predes',
        'premios.rutaimagen as preimagen',
        'insignia_obtenida.fecha',
        'users.name as nomrecibe',
        'users.apellido as aperecibe',
        'users.email as correocibe',
        'comportamiento_categ.descripcion as catinsig'
      )
      ->first();
  }

  // funcion para enviar correos y reutilizar
  /*
private function sendMail($destino, $data, $descrip, $valor){
      $ultimoToken = Token::latest()->first(); //token desde la base de datos
      $accessToken = $ultimoToken->access_token; //recuperar token
      if (!$accessToken) {
          //refrescar token
          return false;
      }
      // Renderiza la vista Blade con el contenido HTML
      if($valor == 1){
        $content = view('correos.reconocimiento', [
            'datosrec' => $data, // valores para la vista de correo
        ])->render();
      }elseif($valor == 2){
        $content = view('correos.insignias', [  
            'datosin' => $data, // valores para la vista de correo
        ])->render();
      }
      // enviar correo
      $result = $this->graphService->sendMail(
          $descrip,
          $content,
          $destino
      );
      if($result['status'] === 'success') {
          return true;
      } else {
          return false;
      }
  }*/



  // Función para enviar correos y reutilizar
  private function sendMail($destino, $data, $descrip, $valor)
  {
    // Renderiza la vista Blade con el contenido HTML
    if ($valor == 1) {
      $content = view('correos.reconocimiento', [
        'datosrec' => $data, // valores para la vista de correo
      ])->render();
    } elseif ($valor == 2) {
      $content = view('correos.insignias', [
        'datosin' => $data, // valores para la vista de correo
      ])->render();
    }

    // Despacha el job a la cola
    SendMailJob::dispatch($descrip, $content, $destino);

    return true; // Puedes ajustar la respuesta según necesites
  }


  public function recocatguardar(Request $request)
  {
    #======== tener en cuenta las categorias puesto que solamente pueden guardar hasta 5 
    #========= revisar el id que no se pase de 5 
    $idc = $request->idcat;
    $usurecibe = $request->input('usuariosSel'); //ids de los usuario quien recibe el reconocimiento
    $date = Carbon::now();
    $listaIds = [];
    //consultar id en la base de datos
    $cat = DB::table('categoria_reconoc')->where('categoria_reconoc.id', '=', $idc)
      ->join('comportamiento_categ', 'id_comportamiento', '=', 'comportamiento_categ.id')
      ->select('categoria_reconoc.puntos', 'comportamiento_categ.id as idcom')
      ->first();
    //consultar las categorias para sacar los id
    $rescate = DB::table('comportamiento_categ')->get();
    $categoria = "cat$cat->idcom"; //referencia de donde guardar el puntaje cat1, cat2 ..
    //========== aqui se guarda los usuarios y categorias y el reconocomiento =====================
    $idlogeado = auth()->id();
    for ($i = 0, $size = count($usurecibe); $i < $size; ++$i) {
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
      $noti->idnotifi = $category->id; //recupera la id guardada
      $noti->save();
      //=========================================================
      $listaIds[] = $category->id;
    }

    //=======================================Enviar correos======================
    foreach ($listaIds as $idbus) {
      $datosrec = DB::table('catrecibida')->where('catrecibida.id', $idbus)
        ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
        ->join('categoria_reconoc', 'catrecibida.id_comportamiento', '=', 'categoria_reconoc.id')
        ->join('users as recibe', 'catrecibida.id_user_recibe', '=', 'recibe.id')
        ->join('users as envia', 'catrecibida.id_user_envia', '=', 'envia.id')
        ->select(
          'catrecibida.fecha',
          'catrecibida.detalle',
          'comportamiento_categ.descripcion as categoria',
          'catrecibida.puntos',
          'categoria_reconoc.nombre as comportamiento',
          'categoria_reconoc.rutaimagen',
          'envia.name as nomenvia',
          'envia.apellido as apenvia',
          'recibe.name as nomrecibe',
          'recibe.apellido as aperecibe',
          'recibe.email as correocibe'
        )
        ->first();
      // Mail::to($datosrec->correocibe)->queue(new Reconocimiento($datosrec)); //envia mensajes
      $descrip = "Nuevo reconocimiento";
      $respuesta = $this->sendMail($datosrec->correocibe, $datosrec, $descrip, 1);
    }
    //==================aqui se debe verificar si gano una insignia========================================

    foreach ($usurecibe as $idser) {
      // puntos obtenidos por categoria seleccionada
      $puntosreco = DB::table('catrecibida')
        ->where('catrecibida.id_user_recibe', '=', $idser)
        ->where('catrecibida.id_categoria', '=', $cat->idcom)
        ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
        ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
        ->selectRaw('comportamiento_categ.descripcion as nom, SUM(catrecibida.puntos) as p')
        ->groupBy('id_categoria')
        ->get();
      // puntos obtenidos la sumatoria de todas las categporias
      $puntostotales = DB::table('catrecibida')
        ->where('catrecibida.id_user_recibe', '=', $idser)
        ->selectRaw('SUM(catrecibida.puntos) as p')
        ->get();
      // puntos totales de insignia de puntos  
      $insignia_puntos = DB::table('insignia')->where('insignia.tipo', '=', 1)->get();
      // puntos de insignia por cada categoria
      $puntosinsig = DB::table('insignia')->where('insignia.id_categoria', '=', $cat->idcom)->get();

      for ($i = 0, $size = count($puntosinsig); $i < $size; ++$i) {
        if ($puntosinsig[$i]->puntos == $puntosreco[0]->p) {
          $idinsignia = DB::table('insignia')->where('insignia.puntos', '=', $puntosreco[0]->p)->select('insignia.id as id')->first();
          $inobtenida = new ReconocimientosModal();
          $inobtenida->id_insignia = $idinsignia->id;
          $inobtenida->id_usuario = $idser;
          $inobtenida->fecha = $date;
          $inobtenida->puntos_acumulados = $puntosreco[0]->p;
          $inobtenida->entregado = 1;
          $inobtenida->save();

          //guardar la notificacion de insignia obtenida
          $Gnoty = new InsigniaNoti();
          $Gnoty->id_insignoti = $inobtenida->id;
          $Gnoty->estado = "1";
          $Gnoty->save();

          //enviar correo si gano una insignia
          $datosin = $this->obtenerInsig($inobtenida->id);

          // Mail::to($datosin->correocibe)->queue(new InsigniaEmail($datosin)); //envia mensajes
          $descrip = "Ganaste una insignia";
          $this->sendMail($datosin->correocibe, $datosin, $descrip, 2);
        }
      }
    } //cerrar el for
    //===================== recorrer los puntos de insignias totales ==========
    foreach ($insignia_puntos as $insig) {
      if ($puntostotales[0]->p >= $insig->puntos) {
        $validar_insignia = ReconocimientosModal::where('id_insignia', $insig->id)->where('id_usuario', $idser)->count();
        if ($validar_insignia == 0) {
          $insigobtenida = new ReconocimientosModal();
          $insigobtenida->id_insignia = $insig->id;
          $insigobtenida->id_usuario = $idser;
          $insigobtenida->fecha = $date;
          $insigobtenida->puntos_acumulados = $insig->puntos;
          $insigobtenida->entregado = 1;
          $insigobtenida->save();

          //guardar la notificacion de insignia obtenida
          $Innoty = new InsigniaNoti();
          $Innoty->id_insignoti = $insigobtenida->id;
          $Innoty->estado = "1";
          $Innoty->save();

          $datosinsigniapuntos =  DB::table('insignia_obtenida')
            ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
            ->join('premios', 'insignia.id_premio', '=', 'premios.id')
            ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
            ->where('insignia_obtenida.id', $insigobtenida->id)
            ->select(
              'insignia.name',
              'insignia.descripcion as nivel',
              'insignia.puntos as insigpuntos',
              'insignia.rutaimagen as imginsig',
              'premios.name as premionom',
              'premios.descripcion as predes',
              'premios.rutaimagen as preimagen',
              'insignia_obtenida.fecha',
              'users.name as nomrecibe',
              'users.apellido as aperecibe',
              'users.email as correocibe'
            )
            ->first();
          $descrip = "Ganaste una insignia";
          $this->sendMail($datosinsigniapuntos->correocibe, $datosinsigniapuntos, $descrip, 2);
          //Mail::to($datosinsigniapuntos->correocibe)->queue(new InsigniaEmail($datosinsigniapuntos)); //envia mensajes
        }
      }
    }
    //sacar un aleatorio para sugerencia
    $us = auth()->id();
    foreach ($usurecibe as $k) {
      $usuazar = Usuarios::where('id', '!=', $k)
        ->where('id_rol', '!=', '1')
        ->where('id', '!=', $us)   // Filtrar por roles diferentes de 1
        ->inRandomOrder()
        ->limit(2)
        ->get();
    }
    return response()->json(
      [
        'usuazar' => $usuazar,
        'respuesta' => $respuesta
      ]
    );
    // return response(json_decode(['usuazar' => $usuazar, 'respuesta' => $respuesta]),200)->header('Content-type', 'text/plain');
    //return back();
  }

  //================ metricas ===================================
  private function obtenerPuntos($users, $fecini = null, $fecfin = null)
  {
    $recibidos = [];
    foreach ($users as $usu) {
      $query = DB::table('catrecibida')
              ->where('catrecibida.id_user_recibe', '=', $usu->id)
              ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
              ->selectRaw('catrecibida.id_user_recibe, users.name as nombre, users.apellido as ape, 
                          SUM(cat1) as c1, SUM(cat2) as c2, SUM(cat3) as c3, SUM(cat4) AS c4, SUM(cat5) AS c5, SUM(cat1+cat2+cat3+cat4+cat5) AS tot, DATE(MIN(catrecibida.created_at)) as fecmin, DATE(MAX(catrecibida.created_at)) as fecmax');
      // Agregar la información del usuario al array $recibidos
      // Agregar condiciones de fecha si existen
      if ($fecini) {
        $query->whereDate('catrecibida.created_at', '>=', $fecini);
      }
      if ($fecfin) {
            $query->whereDate('catrecibida.created_at', '<=', $fecfin);
      }
      // Obtener los datos
      $info_usuario = $query->get();
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
  //============== funcion para retornar insignias ===================
  private function insigRecibidas($fecini = null, $fecfin = null){
    //============ contar la informacion de insignias obtenidas
    $query = DB::table('insignia_obtenida')
      ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
      ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
      ->select('insignia_obtenida.id_usuario', 'users.name as nombre', 'users.apellido as ape', 'insignia.id as idinsig', 'insignia.descripcion as des', 'insignia.name as insignom');
    
    // Agregar condiciones de fecha si existen
    if ($fecini) {
      $query->whereDate('insignia_obtenida.created_at', '>=', $fecini);
    }
    if ($fecfin) {
        $query->whereDate('insignia_obtenida.created_at', '<=', $fecfin);
    }

    // Ejecutar la consulta y obtener los resultados
    $insig_recibidas = $query->get();

    return $insig_recibidas;
  }
  //============== metricas del ranking administrador ===============
  public function metricasranking()
  {
    $fecini = '';
    $fecfin = '';
    $fecha = Carbon::now()->format('Y-m-d');
    $categoria = DB::table('comportamiento_categ')->select('id', 'descripcion')->get();
    $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
    //========== llamar a la funcion ============
    $insig_recibidas = $this->insigRecibidas();
    //============ llamar  a la funcion de puntos ============
    $recibidos = $this->obtenerPuntos($users);
    return  view('metricas.avance')->with([
            'recibidos' => $recibidos,
            'categoria' => $categoria,
            'insignias' => $insig_recibidas,
            'users' => $users,
            'fecini' => $fecini,
            'fecfin' => $fecfin,
            'fecha'  => $fecha,
        ]);
  }
  //===============================
  private function cambiarDatos($datos_iniciales)
  {
    // Estructura de datos final
    $datos_finales = [];

    // Concatenar las matrices internas en una sola matriz
    foreach ($datos_iniciales as $matriz) {
      $datos_finales = array_merge($datos_finales, $matriz);
    }
    return $datos_finales;
  }
  //======================================== metricas para el usuario =====================
  public function metricasusers()
  {
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
    function calcular_distancia($a, $b)
    {
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

    return  view('metricas.posicion')->with('recibidos', $recibidos)->with('categoria', $categoria)->with('cercanos', $usuarios_cercanos);
  }
  //==========================obtner los usuarios a los que reconocio=====================
  public function recenviados()
  {
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
  private function obtenerPuntosEnvia($users, $fecini = null, $fecfin = null)
  {
    $recibidos = [];
    foreach ($users as $usu) {
      $query = DB::table('catrecibida')
                     ->where('catrecibida.id_user_envia', '=', $usu->id)
                     ->join('users', 'catrecibida.id_user_envia', '=', 'users.id')
                     ->selectRaw('catrecibida.id_user_envia, users.name as nombre, users.apellido as ape, 
                     SUM(cat1) as c1, SUM(cat2) as c2, SUM(cat3) as c3, SUM(cat4) AS c4, SUM(cat5) AS c5, SUM(cat1+cat2+cat3+cat4+cat5) AS tot, DATE(MIN(catrecibida.created_at)) as fecmin, DATE(MAX(catrecibida.created_at)) as fecmax');
      // Agregar condiciones de fecha si existen
      if ($fecini) {
          $query->whereDate('catrecibida.created_at', '>=', $fecini);
      }if ($fecfin) {
          $query->whereDate('catrecibida.created_at', '<=', $fecfin);
      }

      // Obtener los datos
      $info_usuario = $query->get();
  
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

  //===========================================================================
  public function metricasEnvio()
  {
    $fecini = '';
    $fecfin = '';
    $fecha = Carbon::now()->format('Y-m-d');

    $categoria = Comportamiento::all();
    $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();

    $recibidos = $this->obtenerPuntosEnvia($users);
    
    return view('metricas.adminenviados')->with([
            'categoria' => $categoria,
            'recibidos' => $recibidos,
            'fecini' => $fecini,
            'fecfin' => $fecfin,
            'fecha'  => $fecha,
        ]);

  }
   //==================== funcion para el reposte de categorias ===============
  public function nomCate(){
    $categorias = DB::table('comportamiento_categ')->select('descripcion')->get();
    $dataArray = $categorias->pluck('descripcion')->toArray();
    $newItems = ["Nombre", "Apellido", "F/Inicial", "F/Final", "Total"];
    $datcate = array_merge($newItems, $dataArray); // Combinar
    return $datcate;
  } 
  //================= Descarga de excel con reporte total de reconocimientos recibidos por cada colaborador ===========================
  public function downloadGet(Request $request){
      //obtener las fechas inicial y final
      $fecini = $request->fecinifil;
      $fecfin = $request->fecfinfil;
      //retornar los usuarios
      $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
      //validar si las fechas tiene valores
      if ($fecini && $fecfin)
          $data = $this->obtenerPuntos($users, $fecini, $fecfin);
      else
          $data = $this->obtenerPuntos($users);

      //verificar si existe informacion en la data
      if (!empty($data)){
        $datcate = $this->nomCate();
        return Excel::download(new RecObtenidos($data, $datcate), 'reporte_reconocimientos_obtenidos.xlsx');
      }else
          return redirect('/metricas/ranking');
    }
  //================Reconocimientos que han enviado los usuarios======================
  public function downloadgive(Request $request){
      //obtener las fechas inicial y final
      $fecini = $request->fecinifil;
      $fecfin = $request->fecfinfil;
      //usuarios que enviaron puntos
      $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
      //validar si las fechas tiene valores
      if ($fecini && $fecfin)
          $data = $this->obtenerPuntosEnvia($users, $fecini, $fecfin);
      else
          $data = $this->obtenerPuntosEnvia($users);
  
      // validar si existe información de datos
      if (!empty($data)){
        $datcate = $this->nomCate();
        return Excel::download(new RecObtenidos($data, $datcate), 'reporte_reconocimientos_enviados.xlsx');
      }else
        return redirect('/reconocimientos/enviados/admin');
    }
  //===================== Filtro para reconocimientos obtenidos =======================
  public function filterReconocimientoTotal(Request $request){
    $fecini = $request->fecini;
    $fecfin = $request->fecfin;
    $fecha = Carbon::now()->format('Y-m-d');
    $categoria = DB::table('comportamiento_categ')->select('id', 'descripcion')->get();
    $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
    //============ llamar  a la funcion de puntos ============
    $recibidos = $this->obtenerPuntos($users, $fecini, $fecfin);
    //========== llamar a la funcion ============
    $insig_recibidas = $this->insigRecibidas($fecini, $fecfin);
    
    return  view('metricas.avance')->with([
            'recibidos' => $recibidos,
            'categoria' => $categoria,
            'insignias' => $insig_recibidas,
            'users' => $users,
            'fecini' => $fecini,
            'fecfin' => $fecfin,
            'fecha'  => $fecha,
        ]);
  }
  //==========================funcion para filtrar el total de recibidos===========================
  public function filterReconocimientoEnviadoTotal(Request $request){
    $fecini = $request->fecini;
    $fecfin = $request->fecfin;
    $fecha = Carbon::now()->format('Y-m-d');

    $categoria = Comportamiento::all();
    $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();

    $recibidos = $this->obtenerPuntosEnvia($users, $fecini, $fecfin);
    
    //retorno de los datos
    return  view('metricas.adminenviados')->with([
                'categoria' => $categoria,
                'recibidos' => $recibidos,
                'fecini' => $fecini,
                'fecfin' => $fecfin,
                'fecha'  => $fecha,
            ]);

  }
    //=========================obtener el total de puntos====================
    private function puntosTotal($users, $fecini = null, $fecfin = null){
      $recibidos = [];
      foreach ($users as $usu) {
        $query = DB::table('catrecibida')
                       ->where('catrecibida.id_user_recibe', '=', $usu->id)
                       ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                       ->selectRaw('catrecibida.id_user_recibe, users.name as nombre, users.apellido as ape, 
                       SUM(puntos) as puntostot, DATE(MIN(catrecibida.created_at)) as fecmin, DATE(MAX(catrecibida.created_at)) as fecmax')
                       ->orderBy('puntostot', 'desc');
        // Agregar condiciones de fecha si existen
        if ($fecini) {
            $query->whereDate('catrecibida.created_at', '>=', $fecini);
        }if ($fecfin) {
            $query->whereDate('catrecibida.created_at', '<=', $fecfin);
        }
  
        // Obtener los datos
        $info_usuario = $query->get();
    
        $recibidos[] = $info_usuario;
      }
  
      return $recibidos;
    }
  //=============================== funcion para vista total de puntos ============
  public function metricasPuntos(){
    $fecini = '';
    $fecfin = '';
    $fecha = Carbon::now()->format('Y-m-d');

    $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
    $puntos = $this->puntosTotal($users);
    //return $puntos;
    return view('metricas.puntos')->with([
      'recibidos' => $puntos,
      'fecini' => $fecini,
      'fecfin' => $fecfin,
      'fecha'  => $fecha
    ]);
  }

  //=================== filtrar la info en puntos obtenidos ======
  public function filterPuntos(Request $request){
    $fecini = $request->fecini;
    $fecfin = $request->fecfin;
    $fecha = Carbon::now()->format('Y-m-d');

    $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
    $puntos = $this->puntosTotal($users, $fecini, $fecfin);
    //return $puntos;
    return view('metricas.puntos')->with([
      'recibidos' => $puntos,
      'fecini' => $fecini,
      'fecfin' => $fecfin,
      'fecha'  => $fecha
    ]);
     
  }

  //==================== download puntos ========================
  public function downloadPuntos(Request $request){
    $fecini = $request->fecinifil;
    $fecfin = $request->fecfinfil;
    $fecha = Carbon::now()->format('Y-m-d');
    //return $request;

    $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
    
     //validar si las fechas tiene valores
    if ($fecini && $fecfin)
       $data = $this->puntosTotal($users, $fecini, $fecfin);
    else
        $data = $this->puntosTotal($users);
    //validar si existen datos
    if (!empty($data))
      return Excel::download(new PuntosExport($data), 'reporte_total_puntos.xlsx');
    else
      return redirect('/metricas/puntos');
    
  }

}
