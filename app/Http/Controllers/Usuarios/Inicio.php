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
use Session;

class Inicio extends Controller
{
    public function index(){
        return view('usuario.inicio');
    }
    public function visualizar(){
        $lista=DB::table('users')->join('roles', 'users.id_rol', '=', 'roles.id')
               ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
               ->join('area', 'cargo.id_area', '=', 'area.id')
               ->join('estado', 'users.id_estado', '=', 'estado.id')
               ->select('users.id','name', 'apellido','telefono', 'email','roles.descripcion as rol', 
                         'cargo.nombre as nomcar', 'area.nombre as nomarea', 'estado.descrip as esta')->get();
    
        return view('admin.usuarios')->with('lista', $lista);
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
       /* $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
        ]);*/
        /////////////7////////////////////7
       
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
                $es->imagen='ruta';
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
}
