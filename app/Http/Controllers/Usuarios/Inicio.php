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
use Session;
use App\Models\Comunicacion\ComunicacionModel;
// librerias para eliminar
use App\Models\RecibeCatMoldel\RecibirCat;
use App\Models\Reconocimientos\ReconocimientosModal;
use App\Models\JefesModal\JefesM;
use App\Models\ModelNotify\Notificacion;
use App\Models\ModelNotify\InsigniaNoti;
use App\Models\EstadoVotModel\RegVotoModel;

#use Illuminate\Support\Facades\Cache;
use App\Services\MicrosoftGraphService;
use App\Models\Token;
//==========
use App\Models\User;
use App\Jobs\SendMailJob; // Importa el job


class Inicio extends Controller
{
    
    protected $graphService;

    public function __construct(MicrosoftGraphService $graphService)
    {
        $this->graphService = $graphService;
    }

    //funcion para enviar los mensajes
    // funcion para enviar correos y reutilizar
    private function sendMail($destino, $data, $descrip, $valor){
        // Renderiza la vista Blade con el contenido HTML
        $content = view('correos.notificacion', [  
              'datos' => $data, // valores para la vista de correo
              'val' => $valor
             ])->render();
       
         // Despacha el job a la cola
        SendMailJob::dispatch($descrip, $content, $destino);

        return true; // Puedes ajustar la respuesta según necesites
    }
     //manejar sin cache
     private function detallecate(){
        $detalle = DB::table('catrecibida')
                    ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
                    ->join('users as usu', 'catrecibida.id_user_envia', '=', 'usu.id')
                    ->join('comportamiento_categ', 'catrecibida.id_categoria', '=', 'comportamiento_categ.id')
                    ->join('categoria_reconoc', 'catrecibida.id_comportamiento', '=', 'categoria_reconoc.id')
                    ->select('catrecibida.id as idcat', 'catrecibida.id_user_recibe', 'catrecibida.detalle as det', 'users.name as nomrecibe', 'users.apellido as aperecibe', 'usu.name as nomenvia', 'usu.apellido as apenvia', 'usu.imagen as imagenenv', 'comportamiento_categ.descripcion as descat',
                            'categoria_reconoc.nombre as comportamiento', 'comportamiento_categ.rutaimagen as img', 'catrecibida.puntos', 'catrecibida.fecha')
                    ->orderBy('fecha', 'DESC')
                    ->simplePaginate(10); // Paginación
        return $detalle;
    }
     
    /*private function detallecate(){
        $userId = auth()->id(); // O el ID del usuario actual si aplica
        $page = request('page', 1);
        $cacheKey = "detalle_page_{$page}_user_{$userId}";
        $detalle = Cache::remember($cacheKey, 60, function() {
            return DB::table('catrecibida')
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
            ->paginate(10); // Paginación
        });
    
        return $detalle;
    }*/
    
    //fucnion para retornar emoticones
    private function emoticonesTot(){
        $emoticonCounts = DB::table('emoticones')
            ->select('idrec', 'idemot', DB::raw('COUNT(*) as count'))
            ->groupBy('idrec', 'idemot')
            ->orderBy('idrec')
            ->orderBy('idemot')
            ->get();
        return $emoticonCounts;
    }

    //emoticones del usuario logeado
    private function emoticonUser(){
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
    private function usuariosReacciones(){
        $res = DB::table('emoticones')
            ->join('users', 'emoticones.iduser', '=', 'users.id')
            ->select('idrec', 'idemot', 'emoticon', 'iduser', 'users.name', 'users.apellido')
            ->orderBy('idrec')
            ->get();
        return $res;
    }
   
    // reporte de comentarios
    private function com(){
        $comentarios = DB::table('comentarioshistoy')
                        ->join('users', 'idusu', '=', 'users.id')
                        ->select('comentario', 'idrec', 'users.name as nombre', 'users.apellido', 'users.imagen', 'comentarioshistoy.created_at as fecha')
                        ->get();
        return $comentarios;
    }

    public function dash(){
        $detalle = $this->detallecate();
        $emoticones = $this->emoticonesTot();
        $emoticonuser = $this->emoticonUser();
        $datos = json_decode(json_encode($emoticonuser));
        $users = $this->usuariosReacciones();
        $comentarios = $this->com();
        $valor = 0;
        $images = ComunicacionModel::orderBy('posicion', 'asc')->get();
        $estadoimg = ComunicacionModel::where('posicion', 1)->select('estado')->first();
       
        //return $emoticones;
        return view('usuario.inicio', [
            'detalle' => $detalle,
            'emoticonCounts' => $emoticones,
            'emoticonuser' => $datos,
            'images' => $images,
            'users' => $users,
            'comentarios' => $comentarios,
            'valor' => $valor,
            'estadoimg' => $estadoimg
        ]);
    }
    // retornar la misma vista
    public function index(){
       return $this->dash();
    }

    public function visualizar(){
        $lista=DB::table('users')->join('roles', 'users.id_rol', '=', 'roles.id')
               ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
               ->join('area', 'cargo.id_area', '=', 'area.id')
               ->join('estado', 'users.id_estado', '=', 'estado.id')
               ->select('users.id','name', 'apellido','telefono', 'email','roles.descripcion as rol', 
                         'cargo.nombre as nomcar', 'area.nombre as nomarea', 'estado.descrip as esta')
               ->orderBy('name', 'ASC')
               ->get();
        //retornar los roles
        $roles = DB::table('roles')->where('id', '!=', 1)->get();
        return view('admin.usuarios')->with('lista', $lista)->with('roles', $roles);
    }

    public function estado($id){
        $pro = Usuarios::find($id);
        $es = $pro->id_estado;
        if($es==1){
            $pro->id_estado = 2;
            $pro->save();
        }else{
            $pro->id_estado = 1;
            $pro->save();
        } 
         Session::flash('mensaje', 'El estado ha sido actualizado con éxito!'); 
        return back();
    }
    
    public function  actualizar($id){
        $dat = DB::table('users')
        ->join('roles', 'users.id_rol', '=', 'roles.id')
        ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
        ->join('area', 'cargo.id_area', '=', 'area.id')
        ->join('estado', 'users.id_estado', '=', 'estado.id')
        ->where('users.id', '=', $id)
        ->select('users.id as idusu', 'users.id_cargo as idcar', 'users.id_rol as idrol', 'users.name', 'users.apellido', 'users.direccion', 'users.telefono', 'users.email', 'cargo.nombre',
          'roles.descripcion', 'estado.descrip', 'area.nombre as nomarea', 'area.id as idar')
        ->get();
        $com=$dat[0]->idcar;//sacar el id cargo para no duplicar los resultados
        $irol=$dat[0]->idrol;
        $iarea =$dat[0]->idar;
        $cargo =DB::table('cargo')->where('cargo.id', '!=',$com)->get();
        $rol =DB::table('roles')->where('roles.id', '!=',$irol)->get();
        $area =DB::table('area')->where('area.id', '!=',$iarea)->get();
        return view('admin.actusu')->with('dat', $dat)->with('cargo', $cargo)->with('rol', $rol)->with('area', $area);
    }
   /*estado
rol 
cargo 
pass 
correo 
telf 
direccion 
apellido 
nombre
*/

    public function regdatos(Request $request){ 
            $es = Usuarios::find($request->id);
            $car = CargoModel::find($request->cargo);
            //validar que el usuario este habilitado para poder editar
            if($es->id_estado==1){
                $es->name = $request->nombre;
                $es->email = $request->correo;
                if($request->pass!=null){
                $es->password= Hash::make($request->pass);
                }
                else{
                 $es->password=$es->password;
                }
                $es->apellido = $request->apellido;
                $es->direccion = $request->direccion;
                $es->telefono = $request->telf;
                $es->id_rol = $request->rol;
                $es->id_cargo = $request->cargo;
                $es->id_estado = $es->id_estado;
                $es->save(); 
                $car->id_area = $request->area;
                $car->nombre= $car->nombre;
                $car->save();
                Session::flash('mensaje', 'El usuario ha sido actualizado!'); 
            }else{

                Session::flash('menerror', 'El usuario debe estar habilitado para poder editar!'); 
               
            } 
            return back();
           
        ///////////////////////////////////
    }
   //========================= aqui funcion para vista de grupos ======
   public function vistaGrupos(){
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

   public function nuevoGrupo(Request $request){
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
   public function actuGrupo(Request $request){
        $grupo = GrupoModel::find($request->input('idgrupo')); // Suponiendo que el grupo con ID 1 existe
        if ($grupo) {
            $grupo->descripcion = $request->input('descrip');
            $grupo->save();
        }
        $exito = "Grupo: " . $request->input('descrip') . " actualizado de manera exitosa.";
        Session::flash('exito', $exito); 
        return back();
   }
   public function deleteGrupo(Request $request, $id){
        $grupo = GrupoModel::find($id);
        if ($grupo) {
            $grupo->delete();
        }
        $exito = "Grupo: " . $grupo->descripcion . " eliminado de manera exitosa.";
        Session::flash('exito', $exito); 
        return back();
   }
   //============= grupos ====================
   public function grupUser(Request $request, $id){
    //return $request;
    $usurecibe = $request->input('checkUsuarios');
    if(empty($usurecibe)){ //sin datos

        UserGrupoModel::where('idgrupo', $id)->delete();
        
    }else{
        UserGrupoModel::where('idgrupo', $id)->delete();
        foreach($usurecibe as $usu) {
            $validar = DB::table('usugrupos')->where('idgrupo', $id)->where('idusu', $usu)->count();
            if($validar == 0){
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
   //=========== metricas ==================
   public function metricas($id){
     $grupo = GrupoModel::find($id);
     $usergrupo = UserGrupoModel::where('idgrupo', $id)->select('idusu')->get();
     //return $usergrupo;
     // aqui filtrar los usuarios y recorrer para sumar puntos 
     foreach ($usergrupo as $usuarioId) {
        $puntaje[] = DB::table('catrecibida')
            ->where('id_user_recibe', $usuarioId->idusu)
            ->select('id_user_recibe', 'id_categoria', 'puntos')
            ->get();
     }
     
     if (isset($puntaje)) {
     //====================
     $totpuntaje = [];
     foreach ($puntaje as $usuario) {
        foreach ($usuario as $registro) {
            $idCategoria = $registro->id_categoria; // Acceder a la propiedad como objeto
            $puntos = $registro->puntos; // Acceder a la propiedad como objeto
            if (!isset($totpuntaje[$idCategoria])) {
                $totpuntaje[$idCategoria] = 0;
            }
            
            $totpuntaje[$idCategoria] += $puntos;
        }
     }
     //========================= calcular totales por usuario =====================
     $totusu = [];

        foreach ($puntaje as $usu) {
            foreach ($usu as $reg) {
                $idUsuario=$reg->id_user_recibe;
                $idCategoria=$reg->id_categoria;
                $puntos=$reg->puntos;

                if (!isset($totusu[$idUsuario][$idCategoria])) {
                    $totusu[$idUsuario][$idCategoria] = 0;
                }

                $totusu[$idUsuario][$idCategoria] += $puntos;
            }
        }
       
     //consultar las categorias
     $cate = DB::table('comportamiento_categ')->select('id', 'descripcion', 'puntos')->get();
     $users = Usuarios::where('id_rol', '!=', '1')
                ->join('roles', 'users.id_rol', '=', 'roles.id')
                ->select('users.id', 'users.name', 'users.apellido', 'users.email', 'users.imagen', 'roles.descripcion as rol')
                ->get();
    //return $totpuntaje;
     return view('grupos.metricas')->with('grupo', $grupo)->with('puntaje', $totpuntaje)->with('cate', $cate)->with('totusu', $totusu)->with('users', $users);
    }else{
        return back();
    }
    } 
  //==================== registrar user====================
  public function addUser(Request $request){
    $val = DB::table('users')->where('email', '=', $request->email)->count(); //valida los usuarios registrados
    $usu = $request->email;
    if($val == 0){
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
       }else{
        Session::flash('regfalse', 'Error: El colaborador: ' . $usu . ' ya se encuentra registrado.'); 
       }
    return back();
  }

  //============= reacciones =======
public function reacciones(Request $request){
    $usu = auth()->user()->id;
    $nombre = auth()->user()->name;
    $apellido = auth()->user()->apellido;
    $emailusulog = auth()->user()->email; // email del usuario que esta logeado
    $res = $request->emoticon;
    $res1 = $request->idemot;
    $res2 = $request->idrec;
    //======== guardar los datos ===========
    $conta = DB::table('emoticones')->where('iduser', $usu)->where('idrec', $request->idrec)->count();
    if ($conta != 0){
        $idat = DB::table('emoticones')->where('iduser', $usu)->where('idrec', $request->idrec)->select('id')->first();
        $es = Emoticones::find($idat->id);
        $es->idemot = $request->idemot;
        $es->emoticon = $request->emoticon;
        $es->save();
    }else{
        $category = new Emoticones();
        $category->emoticon = $request->emoticon;
        $category->idemot = $request->idemot;
        $category->iduser= $usu;
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
     if(strtolower($emailusulog) != strtolower($reconocimiento->email)){
        $val = 1;
        $descrip = "Nueva notificación";
        $respuesta = $this->sendMail($reconocimiento->email, $datos, $descrip, $val);
        //Mail::to($reconocimiento->email)->queue(new ReaccionesComentarios($datos, $val)); //envia mensajes
     }
     
     if(strtolower($emailusulog) != strtolower($reconocimiento->emailenvia)){ //enviar correo a la persona que envio el reconocimiento
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

  //========== comentario del history ======
  public function comentario(Request $request){
    if ($request->isMethod('post')) {
     $usu = auth()->user()->id;
     $nombre = auth()->user()->name;
     $apellido = auth()->user()->apellido;
     $emailusulog = auth()->user()->email; // email del usuario que esta logeado
     $valor = $request->valorInput;
     //guardar los datos
     $category = new Comentarios();
     $category->comentario = $request->contenido;
     $category->idusu= $usu;
     $category->idrec = $valor;
     $category->save();
     // retornar el id que debe levantar
     $detalle = $this->detallecate();
     $emoticones = $this->emoticonesTot();
     $emoticonuser = $this->emoticonUser();
     $datosem = json_decode(json_encode($emoticonuser));
     $users = $this->usuariosReacciones();
     $comentarios = $this->com();
     // data para el correo
     
     $reconocimiento = DB::table('catrecibida')
            ->join('users', 'catrecibida.id_user_recibe', '=', 'users.id')
            ->join('users as userenvia', 'catrecibida.id_user_envia', '=', 'userenvia.id')
            ->where('catrecibida.id', $valor)
            ->select('catrecibida.detalle', 
                    'catrecibida.created_at as fecha', 
                    'users.name as nombre', 
                    'users.apellido', 
                    'users.email', 
                    'userenvia.email as emailenvia', 'userenvia.name as nomenvio', 'userenvia.apellido as apenvio'
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
     if(strtolower($emailusulog) != strtolower($reconocimiento->email)){
        $val = 1;
        $descrip = "Nueva notificación";
        $respuesta = $this->sendMail($reconocimiento->email, $datos, $descrip, $val);
        //Mail::to($reconocimiento->email)->queue(new ReaccionesComentarios($datos, $val)); //envia mensajes
     }
     
     if(strtolower($emailusulog) != strtolower($reconocimiento->emailenvia)){ //enviar correo a la persona que envio el reconocimiento
        $val = 2;
        $descrip = "Nueva notificación";
        $respuesta = $this->sendMail($reconocimiento->emailenvia, $datos, $descrip, $val);
        //Mail::to($reconocimiento->emailenvia)->queue(new ReaccionesComentarios($datos, $val));  
     }
     //======== para imagenes de carrucel
     $images = ComunicacionModel::orderBy('posicion', 'asc')->get();
     $estadoimg = ComunicacionModel::where('posicion', 1)->select('estado')->first();
     
     return view('usuario.inicio', [
        'detalle' => $detalle,
        'emoticonCounts' => $emoticones,
        'emoticonuser' => $datosem,
        'images' => $images,
        'users' => $users,
        'comentarios' => $comentarios,
        'valor' => $valor,
        'estadoimg' => $estadoimg,
        'respuesta' => $respuesta
    ]);
     
    }else{
        // lógica para otros métodos
        return redirect('/dashboard');
    }
    //=========== aqui termina la validacion ===

  }

  //==================== eliminar usuario =========
public function eliminaruser($id){
    //return $id;
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
        $idsvoto =RegVotoModel::where('id_postulado', $id)->Orwhere('id_votante', $id)->pluck('id');
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
    Session::flash('regexit', 'El Colaborador: ' . $datosusu->name . ' '. $datosusu->apellido . ', ha sido eliminado de manera exitosa.');  
   return back();
}

}

