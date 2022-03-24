<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuarios\Usuarios;
use Illuminate\Support\Facades\DB;

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

}
