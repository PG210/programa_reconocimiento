<?php

namespace App\Http\Controllers\JefesController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JefesModal\JefesM;
use DB;
use Session;

class Jefescon extends Controller
{
    public function index(){
        
        $listado=DB::table('users')
        ->join('roles', 'users.id_rol', '=', 'roles.id')
        ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
        ->join('area', 'cargo.id_area', '=', 'area.id')
        ->join('estado', 'users.id_estado', '=', 'estado.id')
        ->where('users.id_rol', 3)
        ->select('users.id','name', 'apellido','telefono', 'email','roles.descripcion as rol', 
                  'cargo.nombre as nomcar', 'area.nombre as nomarea', 'estado.descrip as esta')->get();
        
        $jefes =DB::table('jefes_tot')
               ->join('users', 'jefes_tot.id_reporta', '=', 'users.id')
               ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
               ->join('area', 'cargo.id_area', '=', 'area.id')
               ->select('jefes_tot.id as idjefes', 'jefes_tot.id_jefe', 'users.name as nomjef', 'users.apellido as apejef', 
                        'cargo.nombre as nomcar', 'area.nombre as nomarea')
              ->get();
        return view('admin.jefesvin')->with('lista', $listado)->with('jefes', $jefes);
    }

    public function registrar(Request $request){
      if($request->idreporta != "elegir"){
        $idje = $request->idjefe;
        $idrep = $request->idreporta;
        $val =DB::table('jefes_tot')->where('id_jefe', $idje)->where('id_reporta', $idrep)->count();
      if($val!=0){

        Session::flash('vincu', 'Los datos ya se encuentran registrados!');

      }else{
        $jefe = new JefesM();
        $jefe->id_jefe =  $idje;
        $jefe->id_reporta =  $idrep;
        $jefe->save();
        Session::flash('regis', 'Los datos se registraron exitosamente!');
      }
      }
       return back();
    }

    public function eliminar($id){
      DB::table('jefes_tot')->where('jefes_tot.id', '=', $id)->delete();
      Session::flash('jefe', 'Eliminado con éxito!');
      return back();
    }
}
