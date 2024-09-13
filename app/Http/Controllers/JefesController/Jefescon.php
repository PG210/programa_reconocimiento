<?php

namespace App\Http\Controllers\JefesController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JefesModal\JefesM;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GerenteExcel; //llama para imprimir las insignias
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Jefescon extends Controller
{
  public function index()
  {

    $listado = DB::table('users')
      ->join('roles', 'users.id_rol', '=', 'roles.id')
      ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
      ->join('area', 'cargo.id_area', '=', 'area.id')
      ->join('estado', 'users.id_estado', '=', 'estado.id')
      ->where('users.id_rol', 3)
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
      )->get();

    $jefes = DB::table('jefes_tot')
      ->join('users', 'jefes_tot.id_reporta', '=', 'users.id')
      ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
      ->join('area', 'cargo.id_area', '=', 'area.id')
      ->select(
        'jefes_tot.id as idjefes',
        'jefes_tot.id_jefe',
        'users.name as nomjef',
        'users.apellido as apejef',
        'cargo.nombre as nomcar',
        'area.nombre as nomarea'
      )
      ->get();
    return view('admin.jefesvin')->with('lista', $listado)->with('jefes', $jefes);
  }

  public function registrar(Request $request)
  {
    if ($request->idreporta != "elegir") {
      $idje = $request->idjefe;
      $idrep = $request->idreporta;
      $val = DB::table('jefes_tot')->where('id_jefe', $idje)->where('id_reporta', $idrep)->count();
      if ($val != 0) {

        Session::flash('vincu', 'Los datos ya se encuentran registrados!');
      } else {
        $jefe = new JefesM();
        $jefe->id_jefe =  $idje;
        $jefe->id_reporta =  $idrep;
        $jefe->save();
        Session::flash('regis', 'Los datos se registraron exitosamente!');
      }
    }
    return back();
  }

  public function eliminar($id)
  {
    DB::table('jefes_tot')->where('jefes_tot.id', '=', $id)->delete();
    Session::flash('jefe', 'Eliminado con éxito!');
    return back();
  }

  public function vista_gen($id)
  {
    $con = $id;
    $val = DB::table('insignia_obtenida')->where('insignia_obtenida.entregado', 1)->count();
    if ($val != 0) {
      $b = 1;
      $datos = DB::table('insignia_obtenida')
        ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
        ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
        ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
        ->join('area', 'cargo.id_area', '=', 'area.id')
        ->join('premios', 'insignia.id_premio', '=', 'premios.id')
        //->join('comportamiento_categ', 'insignia.id_categoria', '=', 'comportamiento_categ.id')
        ->where('insignia_obtenida.entregado', $con) //cuando es igual a 1 no esta entregado
        ->select(
          'insignia_obtenida.id as idinsig',
          'insignia_obtenida.entregado as estado',
          'insignia.name as nominsig',
          'insignia.descripcion as insigdes',
          'insignia.puntos',
          'insignia.rutaimagen as imginsig',
          'premios.descripcion as despremio',
          'premios.rutaimagen as imgpre',
          'users.name as nombre',
          'users.apellido',
          'cargo.nombre as cargonom',
          'area.nombre as areanom',
          'insignia_obtenida.entregado',
          'premios.name as nompre'
        )
        ->get();
    } else {
      $b = 0;
      $datos = 0;
    }


    return view('gerente.reporteprin')->with('datos', $datos)->with('b', $b);
  }

  //gerente excel
  public function gerente_excel($id)
  {
    return Excel::download(new GerenteExcel($id), 'reporte_gerente.xlsx');
  }
}
