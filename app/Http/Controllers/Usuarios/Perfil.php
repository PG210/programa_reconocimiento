<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuarios\Usuarios;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image; // optimizar las imagenes
use Session;

class Perfil extends Controller
{
    public function index(){
        $usu= auth()->user()->id;
        $usuarios = Usuarios::findOrFail($usu)->first();//variable retorna todos los valores a la vista
        
        $users = DB::table('users')
            ->join('roles', 'users.id_rol', '=', 'roles.id')
            ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
            ->join('estado', 'users.id_estado', '=', 'estado.id')
            ->where('users.id', '=', $usu)
            ->get();

           $d=$users->filter()->all();
       
           return view('usuario.perfil')->with('dat', $users);
    }
   
    public function datos(){
          //consulta a traves de modelo 
        /*  $cli= auth()->user()->id;
          $fac=DB::table('facturas')
          ->join('productos', 'idprod', '=','productos.referencia')
          ->join('users', 'cedula', '=','users.id')
          ->join('forma_pago', 'pago', '=','forma_pago.id')
          ->where('cedula', '=', $cli)
          ->orderBy('referencia', 'asc')
          ->get();*/
    
        
    }
    public function editar(){
      $usu= auth()->user()->id;
      $dat = DB::table('users')
      ->join('roles', 'users.id_rol', '=', 'roles.id')
      ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
      ->join('area', 'cargo.id_area', '=', 'area.id')
      ->join('estado', 'users.id_estado', '=', 'estado.id')
      ->where('users.id', '=', $usu)
      ->select('users.id as idusu', 'users.id_cargo as idcar', 'users.id_rol as idrol', 'users.name', 'users.apellido', 'users.direccion', 'users.telefono', 'users.email', 'cargo.nombre',
        'roles.descripcion', 'estado.descrip', 'area.nombre as nomarea', 'area.id as idar')
      ->get();
       return view('usuario.editarperfil')->with('dat', $dat);
    }

    public function guardar(Request $request){
       //#################################
      $idusu = auth()->user()->id;
      $esval = DB::table('users')->where('users.id', '=', $idusu)->count();
       if($esval!=0){
            $es = Usuarios::find($idusu);
            $es->name = $request->nombre;
            $es->apellido = $request->apellido;
            $es->direccion = $request->direccion;
            $es->telefono = $request->telf;
            $es->email = $request->correo;
            if($request->pass!=null){
               $es->password= Hash::make($request->pass);
            }
            else{
               $es->password=$es->password;
            }
            $es->id_rol = $es->id_rol;
            $es->id_cargo = $es->id_cargo;
            $es->id_estado = $es->id_estado;
            //#######imagen
            if($request->hasFile('img')){                 
               $file = $request->file('img');
               $val = "perfil".time().".".$file->guessExtension();
               $ruta = public_path("dist/imgperfil/".$val);

               // Crear una instancia de la imagen y redimensionarla si es necesario
               $img = Image::make($file->getRealPath());

               // Redimensionar la imagen si es necesario
               $img->resize(200, 200, function ($constraint) {
                  $constraint->aspectRatio();
                  $constraint->upsize();
               });

               // Optimizar la imagen ajustando la calidad (70% en este ejemplo) y manteniendo la extensión original
               $img->encode($file->guessExtension(), 80);

               // Guardar la imagen optimizada en la ruta especificada
               $img->save($ruta);

               $es->imagen= $val;//ingresa el nombre de la ruta a la base de datos
              }
            //#######end imagen
            $es->save(); 
            Session::flash('mensaje', 'El usuario ha sido actualizado!'); 
           
          }   
          return back();
       //##################################
    }
}
