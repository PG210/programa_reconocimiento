<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuarios\Usuarios;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Area\AreaModel;
use App\Models\Area\CargoModel;
use App\Models\Usuarios\GrupoModel;
use App\Models\Usuarios\UserGrupoModel;
use App\Models\RecibeCatMoldel\Emoticones;
use App\Models\RecibeCatMoldel\Comentarios;
use App\Mail\ReaccionesComentarios; //instanciar para enviar correos
use Illuminate\Support\Facades\Mail; // enviar mails
use Illuminate\Support\Facades\Session;
use App\Models\Comunicacion\ComunicacionModel;
// librerias para eliminar
use App\Models\RecibeCatMoldel\RecibirCat;
use App\Models\Reconocimientos\ReconocimientosModal;
use App\Models\JefesModal\JefesM;
use App\Models\ModelNotify\Notificacion;
use App\Models\ModelNotify\InsigniaNoti;
use App\Models\EstadoVotModel\RegVotoModel;

use App\Services\MicrosoftGraphService;
use App\Models\Token;
//==========
use App\Models\User;
use App\Jobs\SendMailJob; // Importa el job
// importar para manejar las licencias
use App\Models\Licencias\LicenciasModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Eventos\CumpleModel; // cumpleanios
use App\Models\Eventos\AntiguedadModel; // para antiguedad
use App\Models\Eventos\HolidaysModel;
use App\Models\Eventos\ComentarHolidayModel; // guardar los comentarios de los usuarios
use App\Models\Eventos\EstadoEventosModel;
use App\Models\Comunicacion\Pildora;

Carbon::setLocale('es');

class Inicio extends Controller
{
    protected $graphService;

    public function __construct(MicrosoftGraphService $graphService)
    {
        $this->graphService = $graphService;
    }

    //funcion para enviar los mensajes
    // funcion para enviar correos y reutilizar
    private function sendMail($destino, $data, $descrip, $valor)
    {
        // Renderiza la vista Blade con el contenido HTML
        $content = view('correos.notificacion', [
            'datos' => $data, // valores para la vista de correo
            'val' => $valor
        ])->render();

        // Despacha el job a la cola
        SendMailJob::dispatch($descrip, $content, $destino);
        return true; // Puedes ajustar la respuesta según necesites
    }
    // funcion para  enviar correos de holidays
    private function sendMailHolidays($destino, $data, $descrip)
    {
        // Renderiza la vista Blade con el contenido HTML
        $content = view('correos.holidays', [
            'datos' => $data, // valores para la vista de correo
        ])->render();
        // Despacha el job a la cola
        SendMailJob::dispatch($descrip, $content, $destino);
        return true; // Puedes ajustar la respuesta según necesites
    }
    //manejar sin cache
    private function detallecate()
    {
        $detalle = DB::table('catrecibida')
            ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
            ->join('users as usu', 'catrecibida.id_user_envia', '=', 'usu.id')
            ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
            ->join('categoria_reconoc', 'catrecibida.id_comportamiento', '=', 'categoria_reconoc.id')
            ->select(
                'catrecibida.id as idcat',
                'catrecibida.id_user_recibe',
                'catrecibida.detalle as det',
                'users.name as nomrecibe',
                'users.apellido as aperecibe',
                'usu.name as nomenvia',
                'usu.apellido as apenvia',
                'usu.imagen as imagenenv',
                'comportamiento_categ.descripcion as descat',
                'categoria_reconoc.nombre as comportamiento',
                'comportamiento_categ.rutaimagen as img',
                'catrecibida.puntos',
                'catrecibida.fecha'
            )
            ->orderBy('fecha', 'DESC')
            ->simplePaginate(10); // Paginación
        return $detalle;
    }

    //fucnion para retornar emoticones
    private function emoticonesTot()
    {
        $emoticonCounts = DB::table('emoticones')
            ->select('idrec', 'idemot', DB::raw('COUNT(*) as count'))
            ->groupBy('idrec', 'idemot')
            ->orderBy('idrec')
            ->orderBy('idemot')
            ->get();
        return $emoticonCounts;
    }

    //emoticones del usuario logeado
    private function emoticonUser()
    {
        $usu = auth()->user()->id;
        $em = DB::table('emoticones')
            ->where('iduser', $usu)
            ->select('idrec', 'idemot', 'emoticon')
            ->groupBy('idrec', 'idemot')
            ->orderBy('idrec')
            ->get();
        //========= este valor es para controlar los datos que no existen
        $newValue = [
            "idrec" => "A11",
            "idemot" => "2",
            "emoticon" => "j"
        ];

        $em->push($newValue);
        return $em;
    }

    //personas que reaccionaron
    private function usuariosReacciones()
    {
        $res = DB::table('emoticones')
            ->join('users', 'emoticones.iduser', '=', 'users.id')
            ->select('idrec', 'idemot', 'emoticon', 'iduser', 'users.name', 'users.apellido')
            ->orderBy('idrec')
            ->get();
        return $res;
    }

    // reporte de comentarios
    private function com()
    {
        $comentarios = DB::table('comentarioshistoy')
            ->join('users', 'idusu', '=', 'users.id')
            ->selectRaw('comentario, idrec, users.name as nombre, users.apellido, users.imagen, DATE_FORMAT(comentarioshistoy.created_at, "%e %M, %Y") as fecha')
            ->get();

        $totcomentarios = DB::table('comentarioshistoy')
            ->join('users', 'idusu', '=', 'users.id')
            ->select('idrec', DB::raw('COUNT(comentarioshistoy.id) as totalcomentarios'))
            ->groupBy('idrec')
            ->get();
        
        $data = [
                'comentarios' => $comentarios,
                'totcomentarios' => $totcomentarios
            ];

        return $data;
    }

    //reporte de fechas especiales
    private function holidays(){
        $usuanviersario = [];
        $threeDaysAgo = Carbon::now()->subDays(3)->format('m-d');
        $today = Carbon::now()->format('m-d');
        //info happy birthday
        $usershappy = Usuarios::whereRaw("DATE_FORMAT(fecna, '%m-%d') BETWEEN ? AND ?", [$threeDaysAgo, $today])
                     ->select('id', 'name', 'apellido', 'imagen',  DB::raw("DATE_FORMAT(fecna, CONCAT(YEAR(CURDATE()), '-%m-%d')) as fecha_cumple"))
                     ->orderBy('fecha_cumple', 'desc')
                     ->get();
        //info default
        $cumple = CumpleModel::first();
        //info aniversario
        $usersaniver = Usuarios::whereRaw("DATE_FORMAT(fecingreso, '%m-%d') BETWEEN ? AND ?", [$threeDaysAgo, $today])
                        ->select('id', 'name', 'apellido', 'imagen', 
                            DB::raw("DATE_FORMAT(fecingreso, CONCAT(YEAR(CURDATE()), '-%m-%d')) as fecha_aniv"), 
                            DB::raw("TIMESTAMPDIFF(YEAR, fecingreso, CURDATE()) as anios")
                        )
                        ->orderBy('fecha_aniv', 'desc')
                        ->get();
        //agrupar la info
        if(!empty($usersaniver)){
            foreach ($usersaniver as $userani) {
                $imganti = AntiguedadModel::where('tiempo', $userani->anios)->select('imagen')->first();
                $usuanviersario[] = [
                    'id' => $userani->id,
                    'name' => $userani->name,
                    'apellido' => $userani->apellido,
                    'perfil' => $userani->imagen,
                    'fecaniv' => $userani->fecha_aniv,
                    'anios' => $userani->anios,
                    'imganiv' => $imganti->imagen ?? null,
                ];
            }
        }
        
        $data = [
            'usershappy' => $usershappy,
            'usuanviersario' => $usuanviersario,
            'cumple' => $cumple,
        ];
        return $data;
    }
    
    //calcular emoticones para holidays
    private function emotholys(){
       $total = HolidaysModel::select('iduser', 'idemot', 'estado', DB::raw('COUNT(*) as count'))
            ->groupBy('iduser', 'idemot', 'estado')
            ->orderBy('iduser')
            ->orderBy('idemot')
            ->get();
       return $total;
    }

    // buscar los emoticones que tiene  el usuario logeado
    private function useremotholys(){
        $usu = auth()->user()->id;
        $em = HolidaysModel::where('useraccion', $usu)
            ->select('iduser', 'idemot', 'emoticon', 'estado')
            ->groupBy('iduser', 'idemot', 'estado')
            ->orderBy('iduser')
            ->get();
        return $em;
    }

    //personas que reaccionaron a los holidays
    private function usuariosReaccionesHol()
    {  
        $anioActual = Carbon::now()->year;
        $res = HolidaysModel::whereYear('holidays.created_at', $anioActual)
            ->join('users', 'holidays.useraccion', '=', 'users.id')
            ->select('holidays.iduser', 'holidays.idemot', 'holidays.emoticon', 'users.name', 'users.apellido', 'holidays.estado')
            ->orderBy('iduser')
            ->get();
        return $res;
    }

    private function infoComentarios(){
        $anioActual = Carbon::now()->year;
        $data = ComentarHolidayModel::whereYear('comentarholiday.created_at', $anioActual)
                ->join('users as u', 'comentarholiday.useraccion', '=', 'u.id')
                ->select('comentarholiday.iduser', 'comentarholiday.useraccion', 'comentarholiday.comentario', 'comentarholiday.tipo', 'comentarholiday.created_at as fecha', 'u.name as nombre', 'u.apellido', 'u.imagen')
                ->orderBy('iduser')
                ->get();
        return $data;
    }
    
    private function fechasProxi(){
        $monthup = Carbon::now()->month; //fecha actual
        $monthName = ucfirst(Carbon::now()->translatedFormat('F'));
        $datehoy = Carbon::now()->format('Y-m-d'); //fecha actual
        $usuarios = Usuarios::whereMonth('fecna', $monthup)
                    ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                    ->join('area', 'cargo.id_area', '=', 'area.id')
                    ->select('users.id', 'users.name', 'users.apellido', 'users.imagen', 
                            DB::raw("DATE_FORMAT(fecna, CONCAT(YEAR(CURDATE()), '-%m-%d')) as fecha_cumple"), 
                            'cargo.nombre as cargo', 'area.nombre as area', DB::raw('1 as estado'))
                    ->orderBy('fecha_cumple', 'DESC')
                    ->get(); //estado 1 para cumpleanios
        //consulta para aniversarios
        $aniversario = Usuarios::whereMonth('fecingreso', $monthup)
                        ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                        ->join('area', 'cargo.id_area', '=', 'area.id')
                        ->select('users.id', 'users.name', 'users.apellido', 'users.imagen', 
                            DB::raw("DATE_FORMAT(fecingreso, CONCAT(YEAR(CURDATE()), '-%m-%d')) as fecha_aniversario"), 
                            DB::raw("TIMESTAMPDIFF(YEAR, fecingreso, CURDATE()) as total_anios"),
                            'cargo.nombre as cargo', 'area.nombre as area', DB::raw('2 as estado'))
                        ->orderBy('fecha_aniversario', 'DESC')
                        ->get();
        $data = [
            'usuarioscum' => $usuarios,
            'aniversario' => $aniversario,
            'mes' => $monthName,
            'datehoy' => $datehoy
            ];
       return $data;
    }

    //encontrar la fecha del ultimo reconocimiento

    public function ultimoReconocimiento($idlog){

        $ultimo = RecibirCat::where('id_user_envia', $idlog)
                    ->latest('created_at')
                    ->first();
        
        if ($ultimo) {
            $diasPasados = Carbon::parse($ultimo->created_at)->diffInDays(Carbon::now());
        } else {
            $diasPasados = null;
        }
        
        return $diasPasados;
    }

    // dashboard principal
    public function dash()
    {
        $userol = Auth::user()->id_rol; //usuario logeado
        $userlog = Auth::user()->id; //usuario logeado
        $valor = 0;
        if ($userol != 1) {
            $detalle = $this->detallecate();
            $emoticones = $this->emoticonesTot();
            $emoticonuser = $this->emoticonUser();
            $datos = json_decode(json_encode($emoticonuser));
            $users = $this->usuariosReacciones();
            $comentarios = $this->com()['comentarios'];
            $totcomentarios = $this->com()['totcomentarios'];
            $images = ComunicacionModel::orderBy('posicion', 'asc')->get();
            $estadoimg = ComunicacionModel::where('posicion', 1)->select('estado')->first();
            $holidays = $this->holidays();
            $emotholys = $this->emotholys(); //cumpleanios y aniversario
            $useremotholys = $this->useremotholys(); //usuario logeado con emoticones
            $usuariosReaccioneshol = $this->usuariosReaccionesHol(); //usuarios que reaccionaron a holidays
            $infoComentarios = $this->infoComentarios(); //informacion de comentarios
            $fechasProxi = $this->fechasProxi(); //fechas proximas
            $estado =  EstadoEventosModel::first(); //estado de eventos cumpleanios
            $totreconocimiento = RecibirCat::where('id_user_recibe', '=', $userlog)->count(); //total de reconocimientos obtenidos
            $totrecom = ReconocimientosModal::where('id_usuario', '=', $userlog)->count(); // insignias obtenidas
            $valorpun = RecibirCat::where('id_user_recibe', '=', $userlog)->selectRaw('SUM(puntos) as p')->get(); //puntos obtenidos
            $totenviados = RecibirCat::where('id_user_envia', '=', $userlog)->count(); // total de reconocmientos enviados
            
            //total comentarios holidays 1 es cumpeanios y 2 es aniversario
            $totcomholy = ComentarHolidayModel::where('comentarholiday.tipo', 1)
                        ->whereYear('comentarholiday.created_at', Carbon::now()->year) // Filtrar solo el año actual
                        ->select('comentarholiday.iduser', DB::raw('COUNT(comentarholiday.id) as totalcomentarios'))
                        ->groupBy('comentarholiday.iduser')
                        ->get();

            $totcomaniver = ComentarHolidayModel::where('comentarholiday.tipo', 2)
                        ->whereYear('comentarholiday.created_at', Carbon::now()->year) // Filtrar solo el año actual
                        ->select('comentarholiday.iduser', DB::raw('COUNT(comentarholiday.id) as totalcomentarios'))
                        ->groupBy('comentarholiday.iduser')
                        ->get();

            //verificar la feha del ultimo reconocimiento enviado
            $timerec = $this->ultimoReconocimiento($userlog);

            //informacion de pildoras reconoser
            $pildoras = Pildora::all();
            
            return view('usuario.inicio', [
                'detalle' => $detalle,
                'emoticonCounts' => $emoticones,
                'emoticonuser' => $datos,
                'images' => $images,
                'users' => $users,
                'comentarios' => $comentarios,
                'totcomentarios' => $totcomentarios,
                'valor' => $valor,
                'estadoimg' => $estadoimg,
                'usershappy' => $holidays['usershappy'],
                'usuanviersario' => $holidays['usuanviersario'],
                'cumple' => $holidays['cumple'],
                'emotholys' => $emotholys,
                'useremotholys' => $useremotholys,
                'usuariosReaccioneshol' => $usuariosReaccioneshol,
                'infoComentarios' => $infoComentarios,
                'usuarios' => $fechasProxi['usuarioscum'],
                'aniversario' => $fechasProxi['aniversario'],
                'datehoy' => $fechasProxi['datehoy'],
                'monthName' => $fechasProxi['mes'],
                'estado' => $estado,
                'totreconocimiento' => $totreconocimiento,
                'totrecom' => $totrecom,
                'valorpun' => $valorpun,
                'totenviados' => $totenviados,
                'totcomholy' => $totcomholy,
                'totcomaniver' => $totcomaniver,
                'timerec' => $timerec,
                'pildoras' => $pildoras,

            ]);
        } else {
            $licencias = LicenciasModel::first();
            $totaluser = DB::table('users')->where('id_rol', '!=', '1')->count();
            $datevence = '';
            if (isset($licencias->vencimiento)) {
                $datevence = Carbon::parse($licencias->vencimiento)->format('Y-m-d'); //fecha de vencimiento de la db
            }
            return view('usuario.inicio', ['valor' => $valor, 'licencias' => $licencias, 'totaluser' => $totaluser, 'datavence' => $datevence]);
        }
    }
    // retornar la misma vista
    public function index()
    {
        return $this->dash();
    }

    public function visualizar()
    {
        //licencias 
        $licencias = LicenciasModel::first();
        $totaluser = DB::table('users')->where('id_rol', '!=', '1')->count();
        $datehoy = Carbon::now()->startOfDay(); //fecha actual
        $deshab = 0;
        $fecha = '';
        if (isset($licencias->vencimiento)) {
            $datevence = Carbon::parse($licencias->vencimiento)->startOfDay(); //fecha de vencimiento de la db
            $fecha = $datevence->format('Y-m-d');

            if ($datehoy >= $datevence) {
                // Actualizar el estado a 2 para esos usuarios
                Usuarios::where('id_estado', 1)->where('id_rol', '!=', 1)
                    ->update(['id_estado' => 2]);
                $deshab = 1; //este valor sirve para no permitir reactivar los usuarios
            }
        }
        $lista = DB::table('users')->where('users.superadmin', '!=', '1')
            ->join('roles', 'users.id_rol', '=', 'roles.id')
            ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
            ->join('area', 'cargo.id_area', '=', 'area.id')
            ->join('estado', 'users.id_estado', '=', 'estado.id')
            ->select(
                'users.id',
                'name',
                'apellido',
                'telefono',
                'email',
                'roles.descripcion as rol',
                'cargo.nombre as nomcar',
                'area.nombre as nomarea',
                'estado.descrip as esta'
            )
            ->orderBy('name', 'ASC')
            ->get();
        //retornar los roles
        $roles = DB::table('roles')->where('id', '!=', 1)->get();

        return view('admin.usuarios')->with('lista', $lista)->with('roles', $roles)->with('licencias', $licencias)->with('totaluser', $totaluser)->with('deshab', $deshab)->with('fecha', $fecha);
    }

    public function estado($id)
    {
        $pro = Usuarios::find($id);
        $es = $pro->id_estado;
        if ($es == 1) {
            $pro->id_estado = 2;
            $pro->save();
        } else {
            $pro->id_estado = 1;
            $pro->save();
        }
        Session::flash('mensaje', 'El estado ha sido actualizado con éxito!');
        return back();
    }

    public function  actualizar($id)
    {
        $dat = DB::table('users')
            ->join('roles', 'users.id_rol', '=', 'roles.id')
            ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
            ->join('area', 'cargo.id_area', '=', 'area.id')
            ->join('estado', 'users.id_estado', '=', 'estado.id')
            ->where('users.id', '=', $id)
            ->select(
                'users.id as idusu',
                'users.id_cargo as idcar',
                'users.id_rol as idrol',
                'users.name',
                'users.apellido',
                'users.direccion',
                'users.telefono',
                'users.email',
                'users.fecna',
                'users.fecingreso',
                'cargo.nombre',
                'roles.descripcion',
                'estado.descrip',
                'area.nombre as nomarea',
                'area.id as idar'
            )
            ->get();
        $com = $dat[0]->idcar; //sacar el id cargo para no duplicar los resultados
        $irol = $dat[0]->idrol;
        $iarea = $dat[0]->idar;
        $cargo = DB::table('cargo')->where('cargo.id', '!=', $com)->get();
        $rol = DB::table('roles')->where('roles.id', '!=', $irol)->get();
        $area = DB::table('area')->where('area.id', '!=', $iarea)->get();
        return view('admin.actusu')->with('dat', $dat)->with('cargo', $cargo)->with('rol', $rol)->with('area', $area);
    }

    public function regdatos(Request $request)
    {
        $es = Usuarios::find($request->id);
        $car = CargoModel::find($request->cargo);
        //validar que el usuario este habilitado para poder editar
        if ($es->id_estado == 1) {
            $es->name = $request->nombre;
            $es->email = $request->correo;
            if ($request->pass != null) {
                $es->password = Hash::make($request->pass);
            } else {
                $es->password = $es->password;
            }
            $es->apellido = $request->apellido;
            $es->direccion = $request->direccion;
            $es->telefono = $request->telf;
            $es->id_rol = $request->rol;
            $es->id_cargo = $request->cargo;
            $es->id_estado = $es->id_estado;
            $es->save();
            $car->id_area = $request->area;
            $car->nombre = $car->nombre;
            $car->save();
            Session::flash('mensaje', 'El usuario ha sido actualizado!');
        } else {

            Session::flash('menerror', 'El usuario debe estar habilitado para poder editar!');
        }
        return back();

        ///////////////////////////////////
    }
    //========================= aqui funcion para vista de grupos ======
    public function vistaGrupos()
    {
        $grupos = GrupoModel::all();
        $usuarios = Usuarios::where('id_rol', '!=', '1')
            ->join('roles', 'users.id_rol', '=', 'roles.id')
            ->select('users.id', 'users.name', 'users.apellido', 'users.email', 'users.imagen', 'roles.descripcion as rol')
            ->get();
        $usugrupo = UserGrupoModel::all();
        //cuenta el total de usuarios en cada grupo
        $tot = UserGrupoModel::select('idgrupo', DB::raw('COUNT(DISTINCT idusu) as totusu'))
            ->groupBy('idgrupo')
            ->get();
        return view('grupos.principal')->with('grupos', $grupos)->with('usuarios', $usuarios)->with('usugrupo', $usugrupo)->with('tot', $tot);
    }

    public function nuevoGrupo(Request $request)
    {
        //mensajes de error
        $request->validate([
            'grupo' => 'required|unique:grupos,descripcion',
        ]);

        $grupo = GrupoModel::create([
            'descripcion' => $request->input('grupo'),
        ]);
        $exito = "Grupo: " . $request->input('grupo') . " Registrado de manera exitosa.";
        Session::flash('exito', $exito);
        return back();
    }
    public function actuGrupo(Request $request)
    {
        $grupo = GrupoModel::find($request->input('idgrupo')); // Suponiendo que el grupo con ID 1 existe
        if ($grupo) {
            $grupo->descripcion = $request->input('descrip');
            $grupo->save();
        }
        $exito = "Grupo: " . $request->input('descrip') . " actualizado de manera exitosa.";
        Session::flash('exito', $exito);
        return back();
    }
    public function deleteGrupo(Request $request, $id)
    {
        $grupo = GrupoModel::find($id);
        if ($grupo) {
            $grupo->delete();
        }
        $exito = "Grupo: " . $grupo->descripcion . " eliminado de manera exitosa.";
        Session::flash('exito', $exito);
        return back();
    }
    //============= grupos ====================
    public function grupUser(Request $request, $id)
    {
        //return $request;
        $usurecibe = $request->input('checkUsuarios');
        if (empty($usurecibe)) { //sin datos

            UserGrupoModel::where('idgrupo', $id)->delete();
        } else {
            UserGrupoModel::where('idgrupo', $id)->delete();
            foreach ($usurecibe as $usu) {
                $validar = DB::table('usugrupos')->where('idgrupo', $id)->where('idusu', $usu)->count();
                if ($validar == 0) {
                    $usugrupo = UserGrupoModel::create([
                        'idgrupo' => $id,
                        'idusu' => $usu,
                    ]);
                }
            }
            $exito = "Usuarios agregados al grupo de manera exitosa.";
            Session::flash('exito', $exito);
        }
        return back();
    }

    //obtener el colaborador del grupo con mas altos puntos
    private function colabPuntos($id){

      $query = UserGrupoModel::where('usugrupos.idgrupo', '=', $id)
                ->join('catrecibida', 'usugrupos.idusu', '=', 'catrecibida.id_user_recibe')
                ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                ->selectRaw('users.id as idusu, users.name as nomusu, users.apellido as apeusu, COUNT(id_categoria) as total,  SUM(catrecibida.puntos) as ptotal')
                ->groupBy('idusu')
                ->orderBy('total', 'DESC')
                ->first();
      return $query;
    }
    //obtener los datos para la grafica de linea de tiempo, se obtendra todos los puntos obtenidos en cada mes de cada año
    private function puntosTiempo($id){

        $query = UserGrupoModel::where('usugrupos.idgrupo', '=', $id)
                        ->join('catrecibida', 'usugrupos.idusu', '=', 'catrecibida.id_user_recibe')
                        ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                        ->selectRaw('SUM(catrecibida.puntos) as tot, DATE_FORMAT(catrecibida.created_at, "%Y-%m") as mes')
                        ->groupBy('mes')
                        ->orderBy('mes', 'ASC')
                        ->get();
        return $query;
    }
    //obtener los datos para la grafica de donde brilla mas tu equipo
    private function puntosCat($id){
        $cate = UserGrupoModel::where('usugrupos.idgrupo', '=', $id)
                       ->join('catrecibida', 'usugrupos.idusu', '=', 'catrecibida.id_user_recibe')
                       ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                       ->selectRaw(
                           'COUNT(catrecibida.id_categoria) as total, 
                           comportamiento_categ.id as id_categoria, 
                           comportamiento_categ.descripcion as des, 
                           COALESCE(SUM(catrecibida.puntos), 0) as tot'
                       )
                       ->groupBy('comportamiento_categ.id', 'comportamiento_categ.descripcion')
                       ->orderByDesc('total')
                       ->get();
        return $cate;
    }
    //=========== metricas ==================
    public function metricas($id)
    {
        $grupo = GrupoModel::find($id);
        //validar si existen usuarios en el grupo
        $cont = UserGrupoModel::where('idgrupo', $grupo->id)->count();
       
        if($cont > 0){
        //categoria mas votada por grupos
        $datos = UserGrupoModel::where('usugrupos.idgrupo', '=', $id)
                       ->join('catrecibida', 'usugrupos.idusu', '=', 'catrecibida.id_user_recibe')
                       ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                       ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                       ->selectRaw('users.id as idusu, users.name as nomusu, users.apellido as apeusu, COUNT(id_categoria) as total, comportamiento_categ.id as idcat, comportamiento_categ.descripcion as nomcat, SUM(catrecibida.puntos) as ptotal')
                       ->groupBy('idusu', 'idcat')
                       ->orderBy('total', 'DESC')
                       ->get();
        
        $cate = UserGrupoModel::where('usugrupos.idgrupo', '=', $id)
                       ->join('catrecibida', 'usugrupos.idusu', '=', 'catrecibida.id_user_recibe')
                       ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                       ->selectRaw(
                           'COUNT(catrecibida.id_categoria) as total, 
                           comportamiento_categ.id as idcat, 
                           comportamiento_categ.descripcion as nomcat, 
                           COALESCE(SUM(catrecibida.puntos), 0) as ptotal'
                       )
                       ->groupBy('comportamiento_categ.id', 'comportamiento_categ.descripcion')
                       ->orderByDesc('total')
                       ->get();
        //usuario con mas puntos
        $usupuntos = $this->colabPuntos($id);
        // datos para linea de tiempo 
        $ptime = $this->puntosTiempo($id);
        //puntos por categoria para graficar 
        $pcat = $this->puntosCat($id);
       
        return view('grupos.metricas', compact('grupo', 'cate', 'datos', 'usupuntos', 'ptime', 'pcat'));
    }else{
        Session::flash('exito', 'Aún no hay usuarios vinculados. ¡Añade el primero!');
        return back(); 
    }
}
    //==================== registrar user====================
    public function addUser(Request $request)
    {
        $val = DB::table('users')->where('email', '=', $request->email)->count(); //valida los usuarios registrados
        $usu = $request->email;
        if ($val == 0) {
            $datos = new User([
                'name' => $request->nombres,
                'apellido' => $request->apellidos,
                'direccion'  => $request->direccion,
                'telefono'  => $request->telefono,
                'id_rol'  => $request->rol,
                'id_cargo'  => '1',
                'email' => $request->email,
                'password' =>  Hash::make($request->pass),
                'id_estado'  => '1',
            ]);
            $datos->save();
            Session::flash('regexit', 'Colaborador: ' . $usu . ' ha sido registrado de manera exitosa.');
        } else {
            Session::flash('regfalse', 'Error: El colaborador: ' . $usu . ' ya se encuentra registrado.');
        }
        return back();
    }

    //============= reacciones =======
    public function reacciones(Request $request)
    {
        $usu = auth()->user()->id;
        $nombre = auth()->user()->name;
        $apellido = auth()->user()->apellido;
        $emailusulog = auth()->user()->email; // email del usuario que esta logeado
        $res = $request->emoticon;
        $res1 = $request->idemot;
        $res2 = $request->idrec;
        //======== guardar los datos ===========
        $conta = DB::table('emoticones')->where('iduser', $usu)->where('idrec', $request->idrec)->count();
        if ($conta != 0) {
            $idat = DB::table('emoticones')->where('iduser', $usu)->where('idrec', $request->idrec)->select('id')->first();
            $es = Emoticones::find($idat->id);
            $es->idemot = $request->idemot;
            $es->emoticon = $request->emoticon;
            $es->save();
        } else {
            $category = new Emoticones();
            $category->emoticon = $request->emoticon;
            $category->idemot = $request->idemot;
            $category->iduser = $usu;
            $category->idrec = $request->idrec;
            $category->save();
        }
        //retornar la cantidad de emoticones por reconocimiento
        $likes = DB::table('emoticones')->where('idrec', $request->idrec)->where('idemot', 1)->count();
        $ilove = DB::table('emoticones')->where('idrec', $request->idrec)->where('idemot', 2)->count();
        $surprised = DB::table('emoticones')->where('idrec', $request->idrec)->where('idemot', 3)->count();
        $hug =  DB::table('emoticones')->where('idrec', $request->idrec)->where('idemot', 4)->count();
        // buscar el reconocimiento
        $reconocimiento = DB::table('catrecibida')
            ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
            ->join('users as userenvia', 'catrecibida.id_user_envia', '=', 'userenvia.id')
            ->where('catrecibida.id', $res2)
            ->select('catrecibida.detalle', 'catrecibida.created_at as fecha', 'users.name as nombre', 'users.apellido', 'users.email', 'userenvia.email as emailenvia', 'userenvia.name as nomenvio', 'userenvia.apellido as apenvio')->first();
        $data = [
            'usu' => $usu,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'emot' => $res,
            'megusta' => $likes,
            'encanta' => $ilove,
            'sorpresa' => $surprised,
            'abrazo' => $hug,
        ];
        $datos = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'emailusulog' => $emailusulog,
            'emoticon' =>  $res,
            'detalle' => $reconocimiento->detalle,
            'nomrecibe' =>  $reconocimiento->nombre,
            'aperecibe' =>  $reconocimiento->apellido,
            'emailrecibe' => $reconocimiento->email,
            'estado' => '1',
            'fecha' => $reconocimiento->fecha,
            'nomenvio' => $reconocimiento->nomenvio,
            'apenvio' => $reconocimiento->apenvio,
            'emailenvia' => $reconocimiento->emailenvia,

        ];
        // validar que el correo no sea de la misma persona que reacciona
        if (strtolower($emailusulog) != strtolower($reconocimiento->email)) {
            $val = 1;
            $descrip = "Nueva notificación";
            $respuesta = $this->sendMail($reconocimiento->email, $datos, $descrip, $val);
            //Mail::to($reconocimiento->email)->queue(new ReaccionesComentarios($datos, $val)); //envia mensajes
        }

        if (strtolower($emailusulog) != strtolower($reconocimiento->emailenvia)) { //enviar correo a la persona que envio el reconocimiento
            $val = 2;
            $descrip = "Nueva notificación";
            $respuesta = $this->sendMail($reconocimiento->emailenvia, $datos, $descrip, $val);
            //Mail::to($reconocimiento->emailenvia)->queue(new ReaccionesComentarios($datos, $val));  
        }
        return response()->json(
            [
                'data' => $data,
                'respuesta' => $respuesta
            ]
        );
    }
    /*Reacciones para aniversarios  */
    public function reaccionesaniv(Request $request){
        $useraccion = auth()->user()->id;
        $anioActual = Carbon::now()->year;
        $emailusulog = auth()->user()->email; // correo de la persona logeada
        // save data
        $validar = HolidaysModel::where('useraccion', $useraccion)->where('iduser', $request->iduser)->where('estado', $request->tipo)->whereYear('created_at', $anioActual)->count();
        if($validar == 0){ //validar que solamente reaccione una vez en el año
            $holiday = new HolidaysModel();
            $holiday->idemot = $request->idemot ?? null;
            $holiday->emoticon = $request->emoticon ?? null;
            $holiday->comentario = $request->comentario ?? null;
            $holiday->iduser = $request->iduser;
            $holiday->useraccion = $useraccion;
            $holiday->estado = $request->tipo ?? null;
            $holiday->save();
        }else{ //si ya esta guardado debe actualizar la info
            $holiday = HolidaysModel::where('useraccion', $useraccion)->where('iduser', $request->iduser)->where('estado', $request->tipo)->whereYear('created_at', $anioActual)->first();
            if($holiday) {
                $holiday->idemot = $request->idemot ?? null;
                $holiday->emoticon = $request->emoticon ?? null;
                $holiday->comentario = $request->comentario ?? null;
                $holiday->iduser = $request->iduser;
                $holiday->useraccion = $useraccion;
                $holiday->estado = $request->tipo ?? null;
                $holiday->save();
            }
        }
        //retornar la cantidad de emoticones por reconocimiento
        $likes = HolidaysModel::where('iduser', $request->iduser)->whereYear('created_at', $anioActual)->where('idemot', 1)->where('estado', $request->tipo)->count();
        $ilove = HolidaysModel::where('iduser', $request->iduser)->whereYear('created_at', $anioActual)->where('idemot', 2)->where('estado', $request->tipo)->count();
        $surprised = HolidaysModel::where('iduser', $request->iduser)->whereYear('created_at', $anioActual)->where('idemot', 3)->where('estado', $request->tipo)->count();
        $hug =  HolidaysModel::where('iduser', $request->iduser)->whereYear('created_at', $anioActual)->where('idemot', 4)->where('estado', $request->tipo)->count();
        // info de la reaccion actual
        $data = DB::table('holidays')
               ->join('users as u', 'holidays.useraccion', '=', 'u.id')
               ->where('holidays.id', '=', $holiday->id)
               ->select('holidays.iduser', 'holidays.useraccion', 'holidays.idemot', 'holidays.emoticon', 'holidays.comentario', 'holidays.estado as tipo', 'u.name as nombre', 'u.apellido')
               ->first();
               
        $usuarioCongratu = Usuarios::findOrFail($request->iduser); //usuario al que se hace la reaccion
        if($request->tipo == '1')
           $mensaje = "a tu cumpleaños,";
        else
           $mensaje = "a tu aniversario laboral,";

        $total = [
            'likes' => $likes,
            'ilove' => $ilove,
            'surprised' => $surprised,
            'hug' => $hug,
        ];

        $datos = [
            'nombre' => $data->nombre,
            'apellido' => $data->apellido,
            'detalle' => $request->emoticon,
            'nomrecibe' => $usuarioCongratu->name,
            'aperecibe' => $usuarioCongratu->apellido,
            'tipo' => '1',
            'mensaje' => $mensaje,
            'fecha' => $holiday->created_at,
        ];
        //enviar correos al usuario
        if (strtolower($emailusulog) != strtolower($usuarioCongratu->email)) {
            $descrip = "Nueva notificación";
            $respuesta = $this->sendMailHolidays($usuarioCongratu->email, $datos, $descrip);
        }

       return response()->json(['data' => $data, 'total' => $total], 200);
       
    }

    //========== comentario del history ======
    public function comentario(Request $request)
    {
        if ($request->isMethod('post')) {
            $usu = auth()->user()->id;
            $nombre = auth()->user()->name;
            $apellido = auth()->user()->apellido;
            $emailusulog = auth()->user()->email; // email del usuario que esta logeado
            $valor = $request->valorInput;
            //guardar los datos
            $category = new Comentarios();
            $category->comentario = $request->contenido;
            $category->idusu = $usu;
            $category->idrec = $valor;
            $category->save();
            // retornar el id que debe levantar
            $detalle = $this->detallecate();
            $emoticones = $this->emoticonesTot();
            $emoticonuser = $this->emoticonUser();
            $datosem = json_decode(json_encode($emoticonuser));
            $users = $this->usuariosReacciones();
            $comentarios = $this->com()['comentarios'];
            $totcomentarios = $this->com()['totcomentarios'];
            $estado =  EstadoEventosModel::first(); //estado de eventos cumpleanios
            // data para aniversarios
            $holidays = $this->holidays();
            $emotholys = $this->emotholys(); //cumpleanios y aniversario
            $useremotholys = $this->useremotholys(); //usuario logeado con emoticones
            $usuariosReaccioneshol = $this->usuariosReaccionesHol(); //usuarios que reaccionaron a holidays
            $infoComentarios = $this->infoComentarios(); //informacion de comentarios
            $fechasProxi = $this->fechasProxi(); //fechas proximas

            $reconocimiento = DB::table('catrecibida')
                ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                ->join('users as userenvia', 'catrecibida.id_user_envia', '=', 'userenvia.id')
                ->where('catrecibida.id', $valor)
                ->select(
                    'catrecibida.detalle',
                    'catrecibida.created_at as fecha',
                    'users.name as nombre',
                    'users.apellido',
                    'users.email',
                    'userenvia.email as emailenvia',
                    'userenvia.name as nomenvio',
                    'userenvia.apellido as apenvio'
                )
                ->first();
            //enviar correo
            $datos = [
                'nombre' => $nombre,
                'apellido' => $apellido,
                'emailusulog' => $emailusulog,
                'emoticon' =>  $request->contenido,
                'detalle' => $reconocimiento->detalle,
                'nomrecibe' =>  $reconocimiento->nombre,
                'aperecibe' =>  $reconocimiento->apellido,
                'emailrecibe' => $reconocimiento->email,
                'estado' => '2',
                'fecha' => $reconocimiento->fecha,
                'nomenvio' => $reconocimiento->nomenvio,
                'apenvio' => $reconocimiento->apenvio,
                'emailenvia' => $reconocimiento->emailenvia,
            ];
            // validar que el correo no sea de la misma persona que reacciona
            if (strtolower($emailusulog) != strtolower($reconocimiento->email)) {
                $val = 1;
                $descrip = "Nueva notificación";
                $respuesta = $this->sendMail($reconocimiento->email, $datos, $descrip, $val);
                //Mail::to($reconocimiento->email)->queue(new ReaccionesComentarios($datos, $val)); //envia mensajes
            }

            if (strtolower($emailusulog) != strtolower($reconocimiento->emailenvia)) { //enviar correo a la persona que envio el reconocimiento
                $val = 2;
                $descrip = "Nueva notificación";
                $respuesta = $this->sendMail($reconocimiento->emailenvia, $datos, $descrip, $val);
                //Mail::to($reconocimiento->emailenvia)->queue(new ReaccionesComentarios($datos, $val));  
            }
            //======== para imagenes de carrucel
            $images = ComunicacionModel::orderBy('posicion', 'asc')->get();
            $estadoimg = ComunicacionModel::where('posicion', 1)->select('estado')->first();
            
            //======== variables de totalizar =======
            $totreconocimiento = RecibirCat::where('id_user_recibe', '=', $usu)->count(); //total de reconocimientos obtenidos
            $totrecom = ReconocimientosModal::where('id_usuario', '=', $usu)->count(); // insignias obtenidas
            $valorpun = RecibirCat::where('id_user_recibe', '=', $usu)->selectRaw('SUM(puntos) as p')->get(); //puntos obtenidos
            $totenviados = RecibirCat::where('id_user_envia', '=', $usu)->count(); // total de reconocmientos enviados

            return view('usuario.inicio', [
                'detalle' => $detalle,
                'emoticonCounts' => $emoticones,
                'emoticonuser' => $datosem,
                'images' => $images,
                'users' => $users,
                'comentarios' => $comentarios,
                'totcomentarios' => $totcomentarios,
                'valor' => $valor,
                'estadoimg' => $estadoimg,
                'respuesta' => $respuesta,
                'usershappy' => $holidays['usershappy'],
                'usuanviersario' => $holidays['usuanviersario'],
                'cumple' => $holidays['cumple'],
                'emotholys' => $emotholys,
                'useremotholys' => $useremotholys,
                'usuariosReaccioneshol' => $usuariosReaccioneshol,
                'infoComentarios' => $infoComentarios,
                'usuarios' => $fechasProxi['usuarioscum'],
                'aniversario' => $fechasProxi['aniversario'],
                'datehoy' => $fechasProxi['datehoy'],
                'monthName' => $fechasProxi['mes'],
                'estado' => $estado,
                'totreconocimiento' => $totreconocimiento,
                'totrecom' => $totrecom,
                'valorpun' => $valorpun,
                'totenviados' => $totenviados
            ]);
        } else {
            // lógica para otros métodos
            return redirect('/dashboard');
        }
        //=========== aqui termina la validacion ===

    }

    //==================== eliminar usuario =========
    public function eliminaruser(Request $request)
    {
        $id = $request->iduser;
       
        $datosusu = Usuarios::find($id); // buscar datos del usuario
        // Eliminar las notificaciones 
        $notificacionesIds = Notificacion::join('catrecibida', 'notificaciones.idnotifi', '=', 'catrecibida.id')
            ->where('catrecibida.id_user_recibe', $id)
            ->Orwhere('catrecibida.id_user_envia', $id)
            ->pluck('notificaciones.idnotifi');
        Notificacion::whereIn('idnotifi', $notificacionesIds)->delete();
        // eliminar las notifiaciones de insignias recibidas 
        $notinsigIds = InsigniaNoti::join('insignia_obtenida', 'noti_insignia.id_insignoti', '=', 'insignia_obtenida.id')
            ->where('insignia_obtenida.id_usuario', $id)
            ->pluck('noti_insignia.id_insignoti');
        InsigniaNoti::whereIn('id_insignoti', $notinsigIds)->delete();
        // eliminar votos
        $idsvoto = RegVotoModel::where('id_postulado', $id)->Orwhere('id_votante', $id)->pluck('id');
        RegVotoModel::whereIn('id', $idsvoto)->delete();
        // eliminar  el grupo
        UserGrupoModel::where('idusu', $id)->delete();
        // eliminar los comentarios y reacciones que hizo el usuario sobre otros reconocimientos
        Comentarios::where('idusu', $id)->delete();
        Emoticones::where('iduser', $id)->delete();
        // eliminar todos los reconocimientos obtenidos
        $recibidos = RecibirCat::where('id_user_recibe', $id)
            ->Orwhere('id_user_envia', $id)
            ->pluck('catrecibida.id');

        // Elminar comentarios y emoticones de los reconociminetos que recibio el usuario
        Comentarios::whereIn('idrec', $recibidos)->delete();
        Emoticones::whereIn('idrec', $recibidos)->delete();

        RecibirCat::whereIn('id', $recibidos)->delete();
        //======================================================
        ReconocimientosModal::where('id_usuario', $id)->delete();
        JefesM::where('id_jefe', $id)->delete();
        JefesM::where('id_reporta', $id)->delete();
        // Luego, eliminar el usuario en la tabla Users (por ejemplo)
        Usuarios::where('id', $id)->delete();
        Session::flash('regexit', 'El Colaborador: ' . $datosusu->name . ' ' . $datosusu->apellido . ', ha sido eliminado de manera exitosa.');
        return back();
    }

    //comentarios para holidays, fechas de cumpleanios y aniversarios
    public function comentariosholdays(Request $request){
        $emailusulog = auth()->user()->email; // correo de la persona logeada
        $anioActual = Carbon::now()->year;
        $idlog = auth()->user()->id; //usuario logeado
        $iduser = $request->valorInputhappy; //valor id del usuario a felicitar
        $descrip = $request->contenidohappy;
        $tipo = $request->tipohappy;
        //guardar los datos
            $Comentario = new ComentarHolidayModel();
            $Comentario->comentario = $descrip;
            $Comentario->iduser = $iduser;
            $Comentario->useraccion = $idlog;
            $Comentario->tipo = $tipo;
            $Comentario->save();
        //retornar toda la info al front

        $data = ComentarHolidayModel::where('comentarholiday.id', '=', $Comentario->id)
               ->join('users as u', 'comentarholiday.useraccion', '=', 'u.id')
               ->select('comentarholiday.iduser', 'comentarholiday.useraccion', 'comentarholiday.comentario', 'comentarholiday.tipo', 'comentarholiday.created_at as fecha', 'u.name as nombre', 'u.apellido', 'u.imagen')
               ->get();
        
        $usuarioCongratu = Usuarios::findOrFail($iduser);

        //retornar los totales por comentario
        $toth = ComentarHolidayModel::where('comentarholiday.tipo', $tipo)
                        ->where('comentarholiday.iduser', $iduser)
                        ->whereYear('comentarholiday.created_at', Carbon::now()->year) // Filtrar solo el año actual
                        ->select( DB::raw('COUNT(comentarholiday.id) as total'))
                        ->get();

        // validar que el correo no sea de la misma persona que reacciona
        $datos = [
            'nombre' => auth()->user()->name,
            'apellido' => auth()->user()->apellido,
            'detalle' => $descrip,
            'nomrecibe' =>  $usuarioCongratu->name,
            'aperecibe' =>  $usuarioCongratu->apellido,
            'tipo' => '2',
            'fecha' => $Comentario->created_at,
        ];

        if (strtolower($emailusulog) != strtolower($usuarioCongratu->email)) {
            $descrip = "Nueva notificación";
            $respuesta = $this->sendMailHolidays($usuarioCongratu->email, $datos, $descrip);
        }
        
        return response()->json(['data' => $data, 'tipo' => $tipo, 'toth' => $toth], 200);
    }

    //comentarios de history 
    public function comentarioshistory(Request $request){
        $usu = auth()->user()->id;
        $nombre = auth()->user()->name;
        $apellido = auth()->user()->apellido;
        $emailusulog = auth()->user()->email; // email del usuario que esta logeado
        $valor = $request->valorInput;
        //guardar los datos
        $category = new Comentarios();
        $category->comentario = $request->contenido;
        $category->idusu = $usu;
        $category->idrec = $valor;
        $category->save();
        //retornar toda la info al front
        $data = DB::table('comentarioshistoy')->where('comentarioshistoy.id', '=', $category->id)
               ->join('users as u', 'comentarioshistoy.idusu', '=', 'u.id')
               ->select('comentarioshistoy.idrec', 'comentarioshistoy.comentario as com', 'comentarioshistoy.created_at as fecha', 'u.name as nombre', 'u.apellido', 'u.imagen')
               ->get();
        //total de comentarios para la fila
        $totcomentarios = DB::table('comentarioshistoy')
            ->where('idrec', '=', $valor)
            ->select(DB::raw('COUNT(comentarioshistoy.id) as totalcomentarios'))
            ->get();

        //obtener la informacion para enviar por correo
        $reconocimiento = DB::table('catrecibida')
                ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                ->join('users as userenvia', 'catrecibida.id_user_envia', '=', 'userenvia.id')
                ->where('catrecibida.id', $valor)
                ->select(
                    'catrecibida.detalle',
                    'catrecibida.created_at as fecha',
                    'users.name as nombre',
                    'users.apellido',
                    'users.email',
                    'userenvia.email as emailenvia',
                    'userenvia.name as nomenvio',
                    'userenvia.apellido as apenvio'
                )
                ->first();
          
          //enviar correo
          $datos = [
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'emailusulog' => $emailusulog,
                    'emoticon' =>  $request->contenido,
                    'detalle' => $reconocimiento->detalle,
                    'nomrecibe' =>  $reconocimiento->nombre,
                    'aperecibe' =>  $reconocimiento->apellido,
                    'emailrecibe' => $reconocimiento->email,
                    'estado' => '2',
                    'fecha' => $reconocimiento->fecha,
                    'nomenvio' => $reconocimiento->nomenvio,
                    'apenvio' => $reconocimiento->apenvio,
                    'emailenvia' => $reconocimiento->emailenvia,
                ];
        // validar que el correo no sea de la misma persona que reacciona
         
        if (strtolower($emailusulog) != strtolower($reconocimiento->email)) {
            $val = 1;
            $descrip = "Nueva notificación";
            $respuesta = $this->sendMail($reconocimiento->email, $datos, $descrip, $val);
            //Mail::to($reconocimiento->email)->queue(new ReaccionesComentarios($datos, $val)); //envia mensajes
        }

        if (strtolower($emailusulog) != strtolower($reconocimiento->emailenvia)) { //enviar correo a la persona que envio el reconocimiento
            $val = 2;
            $descrip = "Nueva notificación";
            $respuesta = $this->sendMail($reconocimiento->emailenvia, $datos, $descrip, $val);
            //Mail::to($reconocimiento->emailenvia)->queue(new ReaccionesComentarios($datos, $val));  
        }
        return response()->json(['data' => $data, 'totcomentarios' =>$totcomentarios], 200);
    }
}
