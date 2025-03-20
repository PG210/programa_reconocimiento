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
use App\Exports\MedallasExport;
use PDF;
use App\Models\Usuarios\Posicion;
//========== librerias para el servicio 
use App\Services\MicrosoftGraphService;
use App\Models\Token;

use App\Jobs\SendMailJob; 
use PhpParser\Node\Name;// Importa el job


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
        'catrecibida.id_user_envia',
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
  private function reconocimientosRecibidosDate($idlog, $fecini = Null, $fecfin = Null){
    $yearInicio = Carbon::now()->startOfYear();
    $yearFin = Carbon::now()->endOfYear(); 

    $query = RecibirCat::where('catrecibida.id_user_recibe', '=', $idlog)
            ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
            ->selectRaw('catrecibida.id_categoria as idcat, comportamiento_categ.descripcion as descat, COUNT(catrecibida.id_categoria) as total, DATE_FORMAT(catrecibida.created_at, "%M") as mes')
            ->orderByRaw("MONTH(catrecibida.created_at)"); 
    
    if ($fecini && $fecfin) {
          $query->whereBetween('catrecibida.created_at', [$fecini, $fecfin]);
    }else{
          $query->whereBetween('catrecibida.created_at', [$yearInicio, $yearFin]);
    }
    
    $query = $query->groupBy('mes', 'idcat', 'descat'); // Agrupamos por mes y id_categoria
    
    $resultados = $query->get();

    // Convertir los nombres de los meses a español
    foreach($resultados as $item) {
        $item->mes =ucfirst(Carbon::createFromFormat('F', $item->mes)->locale('es')->translatedFormat('F'));
    }
    
    return $resultados;
   
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
  public function totreconocimientos($idlog,  $mesActual = null, $anioActual = null, $fecini = null, $fecfin = null)
  {

    $recibidos = RecibirCat::where('catrecibida.id_user_recibe', $idlog)
                ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                ->selectRaw('
                    catrecibida.id_user_recibe, 
                    users.name as nombre, 
                    users.apellido as ape, 
                    SUM(cat1) as c1, 
                    SUM(cat2) as c2, 
                    SUM(cat3) as c3, 
                    SUM(cat4) as c4, 
                    SUM(cat5) as c5
                ')
                ->when(!empty($fecini) && !empty($fecfin), function ($query) use ($fecini, $fecfin) {
                    return $query->whereBetween('catrecibida.created_at', [$fecini, $fecfin]);
                })
                ->groupBy('catrecibida.id_user_recibe', 'users.name', 'users.apellido')
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
  // total de puntos acumulados para las insignias =======
  private function puntosInsignias($idlog, $fecini = Null, $fecfin = Null){
    $query = ReconocimientosModal::where('id_usuario', '=', $idlog)
             ->selectRaw('SUM(puntos_acumulados) as p');
    
    if($fecini && $fecfin){
      $query->whereBetween('created_at', [$fecini, $fecfin]);
    }
    $query = $query->first();

    //puntos para alcanzar la siguiente insignia
    $insig = InsigniasModel::where('puntos', '>', $query->p ?? 0)
             ->select('puntos')
             ->orderBy('puntos', 'ASC')->first();

    $dif = round(($insig->puntos ?? 0 ) - ($query->p ?? 0)); //resultado de los puntos para obtener otra insignia
    if ($dif < 0)
        $dif = 0;

    $data = [
           'pinsig' => $query,
           'insig' => $insig,
           'dif' => $dif
    ];

    return $data;
    
  }
  //=========== datos para linea de tiempo de insignias recibidas ===================
  private function insigniasRecibidasDate($idlog, $fecini = Null, $fecfin = Null){
    
    //$yearInicio = Carbon::now()->startOfYear();
    $yearInicio = Carbon::now()->subYear()->startOfYear(); //obtiene desde el año anterior 2024
    
    $yearFin = Carbon::now()->endOfYear();   

    $query = ReconocimientosModal::where('id_usuario', '=', $idlog)
            ->selectRaw('COUNT(id_insignia) as total, DATE_FORMAT(created_at, "%M") as mes');
    
    if ($fecini && $fecfin) {
          $query->whereBetween('created_at', [$fecini, $fecfin]);
    }else{
          $query->whereBetween('created_at', [$yearInicio, $yearFin]);
    } 
    
    $query = $query->groupBy('mes'); // Agrupamos por mes y id_categoria
    $query = $query->orderBy('mes'); // ordenar por mes     

    $resultados = $query->get();

    // Convertir los nombres de los meses a español
     foreach($resultados as $item) {
      $item->mes =ucfirst(Carbon::createFromFormat('F', $item->mes)->locale('es')->translatedFormat('F'));
     }
    
    return $resultados;
   
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
    $pinsig = '';
    $insig = '';
    $dif = 0;
    $grafinsig ='';
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
      //return $rectime;
      $morecat = $this->moreCat($idlog);
      $puntosInsignia = $this->puntosInsignias($idlog);
      $pinsig = $puntosInsignia['pinsig'];
      $insig = $puntosInsignia['insig'];
      $dif = $puntosInsignia['dif'];
      // datos para grafica de lineal de insignias
      $grafinsig = $this->insigniasRecibidasDate($idlog);
      
    } 
     
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
      'morecat' => $morecat,
      'pinsig' => $pinsig,
      'dif' => $dif,
      'grafinsig' => $grafinsig
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
      $recibidosquery =  $this->totreconocimientos($idlog, $mesActual, $anioActual, $fecini, $fecfin);
      $recibidos = $recibidosquery['recibidos'];
      $rmes = $recibidosquery['rmes'];
      //====================
      $detalle = $this->reconocimientosRecibidos($idlog, $fecini, $fecfin);
      $resultado = $this->comentariosEnc($idlog, $fecini);
      $comentarios = $resultado['comentarios'];
      $emoticones = $resultado['emoticones'];
      $usureac = $this->usuReacciones($idlog);

      $puntos = RecibirCat::where('id_user_recibe', '=', $idlog)
                ->whereBetween('created_at', [$fecini, $fecfin])
                ->selectRaw('SUM(puntos) as p')->first(); //puntos obtenidos

      $rectime = $this->reconocimientosRecibidosDate($idlog, $fecini, $fecfin); //reconocimientos recibidos en el tiempo
     
      $morecat = $this->moreCat($idlog, $fecini,
                                $fecfin, $fecini, $fecfin);
      
      $puntosInsignia = $this->puntosInsignias($idlog, $fecini, $fecfin);
      $pinsig = $puntosInsignia['pinsig'];
      $insig = $puntosInsignia['insig'];
      $dif = $puntosInsignia['dif'];

      // datos para grafica de lineal de insignias
      $grafinsig = $this->insigniasRecibidasDate($idlog, $fecini, $fecfin);
                             
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
        'morecat' => $morecat,
        'pinsig' => $pinsig,
        'dif' => $dif,
        'grafinsig' => $grafinsig
      ]);
    }
    return back();
  }

  public function listarrec($id = Null)
  {
    setlocale(LC_TIME, 'es_ES');

    $valcateg = Comportamiento::count();
    $nompuntos = PuntosModel::findOrFail(1); // nombre para los puntos
    $uselogeado = auth()->id();
    $fechaActual = Carbon::now()->translatedFormat('d F, Y');
    
    $datausu = Usuarios::where('id', '=', $id)->select('id', 'name', 'apellido')->get();
  
    if ($valcateg > 0) { // Validar que haya al menos 5 categorías registradas  

      $categoria = Comportamiento::all(); // categorias
      $usuarios = Usuarios::where('id', '!=', $uselogeado)
        ->where('id_rol', '!=', 1)
        ->where('id_rol', '!=', 4)
        ->select('id', 'name', 'apellido', 'imagen')
        ->orderBy('name', 'ASC')
        ->get();

      return view('reconocimientos.listrec')
          ->with('usu', $usuarios)
          ->with('categoria', $categoria)
          ->with('nompuntos', $nompuntos)
          ->with('fecha', $fechaActual)
          ->with('datausu', $datausu);
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

  // funcion que retorna el usuario con mas reconocimientos recibidos
  private function hightPeople($fecini = Null, $fecfin  = Null){
     //persona que recibio mas reconocimientos
    $query = DB::table('catrecibida')
                  ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                  ->selectRaw('id_user_recibe, users.name, users.apellido, COUNT(id_categoria) as tot');

        // Agregar condiciones de fecha si existen
    if ($fecini)
        $query->whereDate('catrecibida.created_at', '>=', $fecini);
    if ($fecfin)
        $query->whereDate('catrecibida.created_at', '<=', $fecfin);

    $query = $query->groupBy('id_user_recibe');
    $query = $query->orderByDesc('tot');
    $query = $query->first();

    return $query;
  }

  //funcion para retornar la categoria mas reconocida
  private function hightCat($fecini = Null, $fecfin = Null){
     //categoria mas reconocida
    $query = DB::table('catrecibida')
                  ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                  ->selectRaw('id_categoria, comportamiento_categ.descripcion as des,  COUNT(id_categoria) as tot');

    if ($fecini)
        $query->whereDate('catrecibida.created_at', '>=', $fecini);
    if ($fecfin)
        $query->whereDate('catrecibida.created_at', '<=', $fecfin);

    $query = $query->groupBy('id_categoria');
    $query = $query->orderByDesc('tot');
    $query = $query->first();

    return $query;
  }

  // Obtener el toatl de personas que no obtuvieron ningun reconocimiento
  private function usersTot(){
    $userstot = Usuarios::select('users.id')
                ->selectRaw('COUNT(catrecibida.id) as totalrec, users.id, users.name, users.apellido')
                ->where('users.id_rol', '!=', 1)
                ->leftJoin('catrecibida', function ($join) {
                    $join->on('users.id', '=', 'catrecibida.id_user_recibe');
                })
                ->groupBy('users.id')
                ->having('totalrec', '=', 0)
                ->orderBy('users.name', 'ASC')
                ->get();

    return $userstot;
  }
  
  //consultar el aumento o disminucion de reconocimientos en el periodo
  private function incrementTotal():float{
    // Consulta para el mes actual
    $currentMonthStart = now()->startOfMonth();
    $currentMonthEnd = now()->endOfMonth();

    $currentMonthData = Usuarios::select('users.id')
        ->selectRaw('COUNT(catrecibida.id) as totalrec')
        ->leftJoin('catrecibida', function ($join) use ($currentMonthStart, $currentMonthEnd) {
            $join->on('users.id', '=', 'catrecibida.id_user_recibe')
                ->whereBetween('catrecibida.created_at', [$currentMonthStart, $currentMonthEnd]);
        })
        ->groupBy('users.id')
        ->get();

    // Consulta para el mes anterior
    $lastMonthStart = now()->subMonth()->startOfMonth();
    $lastMonthEnd = now()->subMonth()->endOfMonth();
    $lastMonthData = Usuarios::select('users.id')
        ->selectRaw('COUNT(catrecibida.id) as totalrec')
        ->leftJoin('catrecibida', function ($join) use ($lastMonthStart, $lastMonthEnd) {
            $join->on('users.id', '=', 'catrecibida.id_user_recibe')
                ->whereBetween('catrecibida.created_at', [$lastMonthStart, $lastMonthEnd]);
        })
        ->groupBy('users.id')
        ->get();
    
    // Calcula el incremento en reconocimientos
    $currentTotal = $currentMonthData->sum('totalrec');
    $lastTotal = $lastMonthData->sum('totalrec');

    $increment = $lastTotal > 0 ? (($currentTotal - $lastTotal)/$lastTotal) * 100 : 0;
    $increment = round($increment, 2);
    return $increment;
  }

   //reconocimientos recibidos en el mes de cada año
  private function recMes($fecini = Null, $fecfin = Null) {
     $query = DB::table('catrecibida')
            ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
            ->selectRaw('COUNT(id_categoria) as tot, DATE_FORMAT(catrecibida.created_at, "%Y-%m") as mes');
            
      if ($fecini)
            $query->whereDate('catrecibida.created_at', '>=', $fecini);
      if ($fecfin) 
            $query->whereDate('catrecibida.created_at', '<=', $fecfin);
    
      $query = $query->groupBy('mes')->get();

    return $query;

  }

  //total de reconocimientos por categoria
  private function totCat($fecini = Null, $fecfin = Null) {

    $query = DB::table('catrecibida')
              ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
              ->selectRaw('id_categoria, comportamiento_categ.descripcion as des,  COUNT(id_categoria) as tot');
          
    if ($fecini)
          $query->whereDate('catrecibida.created_at', '>=', $fecini);
    if ($fecfin) 
          $query->whereDate('catrecibida.created_at', '<=', $fecfin);
    
    $query = $query->groupBy('id_categoria')->orderByDesc('tot')->get();

    return $query;
  }

  // dia mas activo
  private function recDia($fecini = Null, $fecfin = Null) {
     //dia mas activo
     $query = DB::table('catrecibida')
            ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
            ->selectRaw("
                COUNT(id_categoria) as tot, 
                HOUR(catrecibida.created_at) as hora,
                CASE WEEKDAY(catrecibida.created_at)
                    WHEN 0 THEN 'Lunes'
                    WHEN 1 THEN 'Martes'
                    WHEN 2 THEN 'Miércoles'
                    WHEN 3 THEN 'Jueves'
                    WHEN 4 THEN 'Viernes'
                    WHEN 5 THEN 'Sábado'
                    WHEN 6 THEN 'Domingo'
                END as dia
            ");
           // ->groupBy('dia', 'hora')
            //->orderByRaw("FIELD(dia, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'), hora")
            //->get();
    if ($fecini)
        $query->whereDate('catrecibida.created_at', '>=', $fecini);
    if ($fecfin)
        $query->whereDate('catrecibida.created_at', '<=', $fecfin);
    
    $query = $query->groupBy('dia', 'hora');
    $query = $query->orderByRaw("FIELD(dia, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'), hora")->get();
    
    return $query;
  }

  //================ generar insignias recibidas por los usuarios ==============
  private function obtenerInsigniasTot($fecini = Null, $fecfin = Null){
    $query = Usuarios::where('users.id_rol', '!=', 1)->select( 'users.name', 'users.apellido as ape', 'insignia_obtenida.created_at', DB::raw("
            SUM(CASE WHEN insignia.descripcion = 'Oro' THEN 1 ELSE 0 END) as oro,
            SUM(CASE WHEN insignia.descripcion = 'Plata' THEN 1 ELSE 0 END) as plata,
            SUM(CASE WHEN insignia.descripcion = 'Bronce' THEN 1 ELSE 0 END) as bronce,
            (
                SUM(CASE WHEN insignia.descripcion = 'oro' THEN 1 ELSE 0 END) +
                SUM(CASE WHEN insignia.descripcion = 'plata' THEN 1 ELSE 0 END) +
                SUM(CASE WHEN insignia.descripcion = 'bronce' THEN 1 ELSE 0 END)
            ) as total
        "))
        ->leftJoin('insignia_obtenida', 'users.id', '=', 'insignia_obtenida.id_usuario')
        ->leftJoin('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id');
    
    if ($fecini) {
          $query->where(function($q) use ($fecini) {
              $q->whereDate('insignia_obtenida.created_at', '>=', $fecini)
                ->orWhereNull('insignia_obtenida.created_at');
          });
      }
    
    if ($fecfin) {
        $query->where(function($q) use ($fecfin) {
            $q->whereDate('insignia_obtenida.created_at', '<=', $fecfin)
              ->orWhereNull('insignia_obtenida.created_at');
        });
    }
      
    $query = $query->groupBy('users.id', 'users.name');
    $query = $query->orderByDesc('total');
    $data = $query->get();

    return $data;
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
    //============ llamar  a la funcion de puntos ============
    $recibidos = $this->obtenerPuntos($users);

    $hightpeople = $this->hightPeople();
    
    $hightcat = $this->hightCat();
   
    $userstot = $this->usersTot();
    
    $increment = $this->incrementTotal();
    
    $recmes = $this->recMes();
    
    $totcat = $this->totCat();
   
    $recdia = $this->recDia();

    $insigrecibidas = $this->obtenerInsigniasTot();
    
    //return $insigrecibidas;
    return  view('metricas.avance')->with([
            'recibidos' => $recibidos,
            'categoria' => $categoria,
            'fecini' => $fecini,
            'fecfin' => $fecfin,
            'fecha'  => $fecha,
            'hightpeople' => $hightpeople,
            'hightcat' => $hightcat,
            'userstot' => $userstot,
            'increment' => $increment,
            'recmes' => $recmes,
            'totcat' => $totcat,
            'recdia' => $recdia,
            'insigrecibidas' =>$insigrecibidas 
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

  // consultar la cantidad de categorias recibidas por el usuario 
  private function totForCategory($idlog){
    $query = DB::table('comportamiento_categ')
            ->leftJoin('catrecibida', function ($join) use ($idlog) {
                $join->on('comportamiento_categ.id', '=', 'catrecibida.id_categoria')
                    ->where('catrecibida.id_user_recibe', '=', $idlog);
            })
            ->leftJoin('users', 'catrecibida.id_user_recibe', '=', 'users.id')
            ->where('users.id', '=', $idlog) // Filtrar solo por el usuario logueado
            ->selectRaw('
                comportamiento_categ.id AS id_categoria, 
                comportamiento_categ.descripcion AS nombre_categoria, 
                users.id AS id_usuario, 
                users.name AS nombre_usuario, 
                users.apellido AS apellido_usuario, 
                COUNT(catrecibida.id_categoria) AS total
            ')
     ->groupBy('comportamiento_categ.id', 'comportamiento_categ.descripcion', 'users.id', 'users.name', 'users.apellido');
            
     $mincat = (clone $query)->orderBy('total', 'ASC')->first();
  
     $maxcat = (clone $query)->orderBy('total', 'DESC')->first();

     $data = [
              'mincat' => $mincat,
              'maxcat' => $maxcat
            ];

     return $data;
  }
  //======================================== metricas para el usuario =====================
  public function metricasusers()
  {
    $id_usuario_logueado = auth()->id();
    $tacumulado = 0;
    $posactual = 0;
    #======= obtener los datos de puntos del usuario logeado ============
    $info_usuario = DB::table('catrecibida')
                  ->where('catrecibida.id_user_recibe', '=', $id_usuario_logueado)
                  ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                  ->selectRaw('catrecibida.id_user_recibe, users.name as nombre, users.apellido as ape, 
                                SUM(cat1) as c1, SUM(cat2) as c2, SUM(cat3) as c3, SUM(cat4) AS c4, SUM(cat5) AS c5, SUM(cat1+cat2+cat3+cat4+cat5) AS tot')
                  ->first();
    //minima categoria que tiene reconocimientos
    $totforcat = $this->totForCategory($id_usuario_logueado);

    $mincat = $totforcat['mincat']; 

    $maxcat = $totforcat['maxcat']; //maxima categoria

    $categoria = DB::table('comportamiento_categ')->select('id', 'descripcion')->get();
    $users = Usuarios::where('id_rol', '!=', 1)->select('id', 'name', 'apellido')->get();
    $recibidos = $this->obtenerPuntos($users);
    $datos = json_decode($recibidos, TRUE); //llamado a la funcion
    //return $recibidos;
    //=======================
    function calcular_distancia($a, $b)
    {
      return abs($a - $b);
    }
    $valores_cercanos = [];
    foreach ($datos as $usuario) {
      foreach ($usuario as $datos_usuario) {
        if ($datos_usuario['id_user_recibe'] !== null) {
          $distancia = calcular_distancia($info_usuario->tot, $datos_usuario['tot']);
          $valores_cercanos[$datos_usuario['id_user_recibe']] = $distancia;
        }
      }
    }
    arsort($valores_cercanos); //odenar de mayor a menor
    // Obtener los tres valores más cercanos
    $usuarios_cercanos = array_slice($valores_cercanos, 0, 6, true);
  
    //obtener los usuarios
    $ids_usuarios = array_keys($usuarios_cercanos);

    $data = DB::table('users')
                    ->leftJoin('catrecibida', 'users.id', '=', 'catrecibida.id_user_recibe')
                    ->whereIn('users.id', $ids_usuarios)
                    ->selectRaw('users.id, users.name as nombre, users.apellido as ape, 
                                COALESCE(SUM(catrecibida.cat1), 0) as c1, 
                                COALESCE(SUM(catrecibida.cat2), 0) as c2, 
                                COALESCE(SUM(catrecibida.cat3), 0) as c3, 
                                COALESCE(SUM(catrecibida.cat4), 0) as c4, 
                                COALESCE(SUM(catrecibida.cat5), 0) as c5, 
                                COALESCE(SUM(catrecibida.cat1 + catrecibida.cat2 + catrecibida.cat3 + catrecibida.cat4 + catrecibida.cat5), 0) AS tot')
                    ->groupBy('users.id', 'users.name', 'users.apellido')
                    ->orderBy('tot', 'DESC')
                    ->get();
    //buscar la posición del usuario logeado de mayor a menor
    $datarray = $data->toArray();
    $posicion = array_search($id_usuario_logueado, array_column($datarray, 'id'));
    
     //buscar la posicion en el tiempo con la informacion de la base de datos
     $dbposicion = Posicion::where('idusu', $id_usuario_logueado)->first();
     if($dbposicion){
       $posactual = $dbposicion->posactual - $posicion;
     }

    //guardar la posicion
    if($posicion >= 0){
      $posicionExistente = Posicion::where('idusu', $id_usuario_logueado)->first();
      if ($posicionExistente) {
          $posicionExistente->posactual = $posicion;
          $posicionExistente->save();
      } else {
          Posicion::create([
            'idusu' => $id_usuario_logueado,
            'posactual' => $posicion
        ]);
      }
    }

    //buscar el proximo valor mas cercano para ver una subida de nivel en porcentaje
    if($posicion-1 > 0){
       $poscercana = $posicion-1;
    }else{
      $poscercana = 0;
    }
    //porcentaje para info
    if (isset($datarray[$poscercana])) {
      $tacumulado = round(($info_usuario->tot * 100)/$datarray[$poscercana]->tot, 2);
    }
 
    return  view('metricas.posicion', compact('categoria', 'categoria', 'data', 'mincat', 'maxcat', 'posicion', 'tacumulado', 'posactual'));
  }
  //============== reconocimientos enviados ============
  private function reconocimientosEnviadosDate($idlog, $fecini = Null, $fecfin = Null ){
        $yearInicio = Carbon::now()->startOfYear();
        $yearFin = Carbon::now()->endOfYear();    

        $query = RecibirCat::where('catrecibida.id_user_envia', '=', $idlog)
                 ->whereBetween('catrecibida.created_at', [$yearInicio, $yearFin])
                 ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                 ->selectRaw('catrecibida.id_categoria as idcat, comportamiento_categ.descripcion as descat, COUNT(catrecibida.id_categoria) as total,  DATE_FORMAT(catrecibida.created_at, "%M") as mes');

        if ($fecini && $fecfin) {
          $query->whereBetween('catrecibida.created_at', [$fecini, $fecfin]);
        }

        $query = $query->groupBy('mes', 'idcat', 'descat'); // Agrupamos por mes y id_categoria
        $query = $query->orderByRaw("MONTH(catrecibida.created_at)");    
       
        $resultados = $query->get();
         // Convertir los nombres de los meses a español
        foreach($resultados as $item) {
            $item->mes =ucfirst(Carbon::createFromFormat('F', $item->mes)->locale('es')->translatedFormat('F'));
        }

        return $resultados;
        
  }

  //============ reconocimientos enviados este mes =================
  private function reconocimientoEnMes($idlog){

    $mesInicio = Carbon::now()->startOfMonth();
    $mesFin = Carbon::now()->endOfMonth(); 

    $query = RecibirCat::where('id_user_envia', '=', $idlog)
             ->whereBetween('created_at', [$mesInicio, $mesFin])
             ->selectRaw('COUNT(id_categoria) as total')
             ->first();
    return $query;
  }

  //================ puntos por categoria ======================================
  private function puntosCategoria($idlog){
    
    $query = DB::table('comportamiento_categ')
              ->leftJoin('catrecibida', 'comportamiento_categ.id', 'catrecibida.id_categoria')
              ->where('catrecibida.id_user_envia', '=', $idlog)
              ->selectRaw('catrecibida.id_categoria, comportamiento_categ.descripcion as nomcat, COUNT(catrecibida.id_categoria) as total, SUM(catrecibida.puntos) as puntos')
              ->groupBy('comportamiento_categ.id')
              ->orderBy('total', 'DESC')
              ->get();

    return $query;
  }
  //==========================obtner los usuarios a los que reconocio=====================
  public function recenviados()
  {
    $iduser = auth()->id();
    $mesFin = Carbon::now()->endOfMonth(); // Último día del mes, 23:59:59
   
    $datos = RecibirCat::where('id_user_envia', $iduser)
      ->join('users', 'id_user_recibe', '=', 'users.id')
      ->join('categoria_reconoc', 'catrecibida.id_comportamiento', '=', 'categoria_reconoc.id')
      ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
      ->select('users.id as iduser', 'users.name', 'users.apellido', 'comportamiento_categ.descripcion as cate', 'comportamiento_categ.rutaimagen as imgcat', 'categoria_reconoc.nombre as comportamiento', 'users.apellido', 'fecha', 'catrecibida.puntos as puntaje', 'detalle')
      ->orderBy('users.name', 'ASC')
      ->get();
    //return $datos;
    // agrupacion de datos
    $agrupados = collect($datos)->groupBy('iduser'); // agrupa los datos en una coleccion a traves de una id
    $recenvia = $this->reconocimientosEnviadosDate($iduser);

    $totmes = $this->reconocimientoEnMes($iduser); //total de reconocimientos en el mes

    $puntoscat = $this->puntosCategoria($iduser); //obtener el total de puntos por categoria
    
    //return $recenvia; 
    return view('metricas.recenviados', compact('agrupados', 'recenvia', 'totmes', 'puntoscat'));
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

  //================== persona que envio mas reconocimientos ==============
  private function moreRecPeople($fecini = Null, $fecfin  = Null){
    //persona que recibio mas reconocimientos
   $query = DB::table('catrecibida')
                 ->join('users', 'catrecibida.id_user_envia', '=', 'users.id')
                 ->selectRaw('id_user_envia, users.name, users.apellido, COUNT(id_categoria) as tot');

       // Agregar condiciones de fecha si existen
   if ($fecini)
       $query->whereDate('catrecibida.created_at', '>=', $fecini);
   if ($fecfin)
       $query->whereDate('catrecibida.created_at', '<=', $fecfin);

   $query = $query->groupBy('id_user_envia');
   $query = $query->orderByDesc('tot');
   $query = $query->first();

   return $query;
  }

  //usuarios que no han enviado ningun reconocimiento:
  private function userNoRec(){
    $userstot = Usuarios::select('users.id')
                ->selectRaw('COUNT(catrecibida.id) as totalrec, users.id, users.name, users.apellido')
                ->where('users.id_rol', '!=', 1)
                ->leftJoin('catrecibida', function ($join) {
                    $join->on('users.id', '=', 'catrecibida.id_user_envia');
                })
                ->groupBy('users.id')
                ->having('totalrec', '=', 0)
                ->orderBy('users.name', 'ASC')
                ->get();

    return $userstot;
  }

  //================= crecimiento o decrecimiento de los reconocimientos enviados ========00
  private function incrementTotalEnviados():float{
    // Consulta para el mes actual
    $currentMonthStart = now()->startOfMonth();
    $currentMonthEnd = now()->endOfMonth();

    $currentMonthData = Usuarios::select('users.id')
        ->selectRaw('COUNT(catrecibida.id) as totalrec')
        ->leftJoin('catrecibida', function ($join) use ($currentMonthStart, $currentMonthEnd) {
            $join->on('users.id', '=', 'catrecibida.id_user_recibe')
                ->whereBetween('catrecibida.created_at', [$currentMonthStart, $currentMonthEnd]);
        })
        ->groupBy('users.id')
        ->get();

    // Consulta para el mes anterior
    $lastMonthStart = now()->subMonth()->startOfMonth();
    $lastMonthEnd = now()->subMonth()->endOfMonth();
    $lastMonthData = Usuarios::select('users.id')
        ->selectRaw('COUNT(catrecibida.id) as totalrec')
        ->leftJoin('catrecibida', function ($join) use ($lastMonthStart, $lastMonthEnd) {
            $join->on('users.id', '=', 'catrecibida.id_user_recibe')
                ->whereBetween('catrecibida.created_at', [$lastMonthStart, $lastMonthEnd]);
        })
        ->groupBy('users.id')
        ->get();
    
    // Calcula el incremento en reconocimientos
    $currentTotal = $currentMonthData->sum('totalrec');
    $lastTotal = $lastMonthData->sum('totalrec');

    $increment = $lastTotal > 0 ? (($currentTotal - $lastTotal)/$lastTotal) * 100 : 0;
    $increment = round($increment, 2);
    return $increment;
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

    $morepeople = $this->moreRecPeople();
    
    $highcat = $this->hightCat();

    $usernotrec = $this->userNoRec();

    $increment = $this->incrementTotalEnviados();

    $recmes = $this->recMes();

    $totcat = $this->totCat();
   
    $recdia = $this->recDia();

    return view('metricas.adminenviados')->with([
            'categoria' => $categoria,
            'recibidos' => $recibidos,
            'fecini' => $fecini,
            'fecfin' => $fecfin,
            'fecha'  => $fecha,
            'morepeople' => $morepeople,
            'highcat' => $highcat, 
            'usernotrec' => $usernotrec,
            'increment' => $increment,
            'recmes' => $recmes,
            'totcat' => $totcat,
            'recdia' => $recdia
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
      $tipo = $request->reportetipo;
      //retornar los usuarios
      $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
      //validar si las fechas tiene valores
      if ($fecini && $fecfin)
          $data = $this->obtenerPuntos($users, $fecini, $fecfin);
      else
          $data = $this->obtenerPuntos($users);

      //verificar si existe informacion en la data
      if (!empty($data)){
        if($tipo == 1){
          $datcate = $this->nomCate();
          return Excel::download(new RecObtenidos($data, $datcate), 'reporte_reconocimientos_obtenidos.xlsx');
        }else{
          // Generar el PDF
          $ncat = DB::table('comportamiento_categ')->select('descripcion')->get();
          $pdf = PDF::loadView('pdf.reporteobtenidos', compact('data', 'ncat'));
          return $pdf->download('reporte.pdf');
        }
      }else
          return redirect('/metricas/ranking');
    }
  
    public function downloadGetInsignias(Request $request){
    //return $request;
    $tipo = $request->reportetipo02;
    $fecini = $request->fecinifil02;
    $fecfin = $request->fecfinfil02;
    
    if ($fecini && $fecfin){
      $data = $this->obtenerInsigniasTot($fecini, $fecfin);
    }else{
      $data = $this->obtenerInsigniasTot();
    }
     
    if(!empty($data)){
          if($tipo == 1){
            $dataformat = array_map(function ($item) {
                        return [
                            $item['name'],
                            $item['ape'],
                            $item['oro'],
                            $item['plata'],
                            $item['bronce'],
                            $item['total']
                        ];
                    }, $data->toArray());
              return Excel::download(new MedallasExport($dataformat), 'insignias_obtenidas.xlsx');
            
          }else{
            $pdf = PDF::loadView('pdf.reporteinsig', compact('data'));
            return $pdf->download('reporte_usuarios_con_insignias.pdf');
          }
      }else{
        return back();
      }
    //return $usuariosConInsignias;
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
        if($request->reportetipo == 1){
          return Excel::download(new RecObtenidos($data, $datcate), 'reporte_reconocimientos_enviados.xlsx');
        }else{
          $pdf = PDF::loadView('pdf.reportenviados', compact('data', 'datcate'));
          return $pdf->download('reporte_reconocimientos_enviados.pdf');
        }
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

    $hightpeople = $this->hightPeople($fecini, $fecfin);
   
    $hightcat = $this->hightCat($fecini, $fecfin);
   
    $userstot = $this->usersTot();
    
    $increment = $this->incrementTotal();
    
    $recmes = $this->recMes($fecini, $fecfin);
    
    $totcat = $this->totCat($fecini, $fecfin);
   
    $recdia = $this->recDia($fecini, $fecfin);

    $insigrecibidas = $this->obtenerInsigniasTot($fecini, $fecfin);
    
    return  view('metricas.avance')->with([
            'recibidos' => $recibidos,
            'categoria' => $categoria,            
            'fecini' => $fecini,
            'fecfin' => $fecfin,
            'fecha'  => $fecha,
            'hightpeople' => $hightpeople,
            'hightcat' => $hightcat,
            'userstot' => $userstot,
            'increment' => $increment,
            'recmes' => $recmes,
            'totcat' => $totcat,
            'recdia' => $recdia,
            'insigrecibidas' => $insigrecibidas
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

    $morepeople = $this->moreRecPeople($fecini, $fecfin);
    
    $highcat = $this->hightCat($fecini, $fecfin);

    $usernotrec = $this->userNoRec();

    $increment = $this->incrementTotalEnviados();

    $recmes = $this->recMes($fecini, $fecfin);
    
    $totcat = $this->totCat($fecini, $fecfin);
   
    $recdia = $this->recDia($fecini, $fecfin);
    //retorno de los datos
    return  view('metricas.adminenviados')->with([
                'categoria' => $categoria,
                'recibidos' => $recibidos,
                'fecini' => $fecini,
                'fecfin' => $fecfin,
                'fecha'  => $fecha,
                'morepeople' => $morepeople,
                'highcat' => $highcat, 
                'usernotrec' => $usernotrec,
                'increment' => $increment,
                'recmes' => $recmes,
                'totcat' => $totcat,
                'recdia' => $recdia
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
  //persona con mas pungtos
  private function topPuntos($fecini = null, $fecfin = null){

    $query= RecibirCat::join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                ->selectRaw('catrecibida.id_user_recibe, users.name, users.apellido, SUM(puntos) as total')
                ->groupBy('id_user_recibe')
                ->orderBy('total', 'DESC');

    if ($fecini) 
        $query->whereDate('catrecibida.created_at', '>=', $fecini);
    if ($fecfin) 
        $query->whereDate('catrecibida.created_at', '<=', $fecfin);
    
    $topuntos = $query->first();
    
    return $topuntos;
  }
  //========= personas que obtuvieron menos puntos 0 ========
  private function menosPuntos($fecini = null, $fecfin = null){

    $query = Usuarios::selectRaw('COUNT(catrecibida.puntos) as totalpuntos, users.id, users.name, users.apellido')
                ->where('users.id_rol', '!=', 1)
                ->leftJoin('catrecibida', function ($join) {
                    $join->on('users.id', '=', 'catrecibida.id_user_recibe');
                })
                ->groupBy('users.id')
                ->having('totalpuntos', '=', 0);
    
    if ($fecini) 
          $query->whereDate('catrecibida.created_at', '>=', $fecini);
    if ($fecfin) 
          $query->whereDate('catrecibida.created_at', '<=', $fecfin);
            
    $user = $query->orderBy('users.name', 'ASC')->get();

    return $user;
  }
  //=============================== funcion para vista total de puntos ============
  public function metricasPuntos(){
    $fecini = '';
    $fecfin = '';
    $fecha = Carbon::now()->format('Y-m-d');

    $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
    $puntos = $this->puntosTotal($users);

    //persona con mas puntos
    $topuntos = $this->topPuntos();

    //personas con menos puntos
    $downpuntos = $this->menosPuntos();

    //incremento
    $incrementTotal = $this->incrementTotal();

    //return $incrementTotal;
    
    return view('metricas.puntos')->with([
      'recibidos' => $puntos,
      'fecini' => $fecini,
      'fecfin' => $fecfin,
      'fecha'  => $fecha,
      'topuntos' => $topuntos,
      'downpuntos' => $downpuntos,
      'increment' => $incrementTotal
    ]);
  }

  //=================== filtrar la info en puntos obtenidos ======
  public function filterPuntos(Request $request){
    $fecini = $request->fecini;
    $fecfin = $request->fecfin;
    $fecha = Carbon::now()->format('Y-m-d');

    $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
    $puntos = $this->puntosTotal($users, $fecini, $fecfin);

    //persona con mas puntos
    $topuntos = $this->topPuntos($fecini, $fecfin);

    //personas con menos puntos
    $downpuntos = $this->menosPuntos($fecini, $fecfin);

    //incremento
    $incrementTotal = $this->incrementTotal();

    return view('metricas.puntos')->with([
      'recibidos' => $puntos,
      'fecini' => $fecini,
      'fecfin' => $fecfin,
      'fecha'  => $fecha,
      'topuntos' => $topuntos,
      'downpuntos' => $downpuntos,
      'increment' => $incrementTotal
    ]);
     
  }

  //==================== download puntos ========================
  public function downloadPuntos(Request $request){
    
    //obtener las fechas inicial y final
    $fecini = $request->fecinifil;
    $fecfin = $request->fecfinfil;
    $tipo = $request->reportetipo;
    $fecha = Carbon::now()->format('Y-m-d');
    //return $request;

    $users = Usuarios::where('id', '!=', 1)->select('id', 'name', 'apellido')->get();
    
     //validar si las fechas tiene valores
    if ($fecini && $fecfin)
       $data = $this->puntosTotal($users, $fecini, $fecfin);
    else
        $data = $this->puntosTotal($users);
    //validar si existen datos
    if (!empty($data)){
       if($tipo == 1){
          return Excel::download(new PuntosExport($data), 'reporte_total_puntos.xlsx');
       }else{
          // Generar el PDF
          $pdf = PDF::loadView('pdf.reportepuntos', compact('data'));
          return $pdf->download('reporte_puntos.pdf');
       }
     
      }else{
        return redirect('/metricas/puntos');
      }
    
  }


}
