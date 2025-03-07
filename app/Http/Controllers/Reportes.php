<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reconocimientos\ReconocimientosModal;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport; //llama para imprimir las insignias
use App\Exports\JefesExcel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Reportes extends Controller
{

    public function index()
    {
        $totalSindar = 0;
        $totaldar = 0;
        $idlog = auth()->id();
        $consul = DB::table('users')->where('users.id', $idlog)
            ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
            ->select('cargo.id_area as area')->first();
        $con = $consul->area;
        //consultar los jefes subordinados
        $jefesub = DB::table('jefes_tot')->where('id_reporta', $idlog)->count();
        if ($jefesub == 0) {
            $b = 0;
            $arr = 0;
            $datos = DB::table('insignia_obtenida')
                ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                ->join('area', 'cargo.id_area', '=', 'area.id')
                ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                ->where('insignia_obtenida.entregado', 1) //cuando es igual a 1 no esta entregado
                ->where('area.id', $con)
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
                    'premios.name as nompre'
                )
                ->orderBy('users.name', 'asc')
                ->get();
                
                $totalSindar = count($datos);

                // total de usuarios que recibieron premio
                $datosdar = DB::table('insignia_obtenida')
                        ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                        ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                        ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                        ->join('area', 'cargo.id_area', '=', 'area.id')
                        ->where('insignia_obtenida.entregado', 2) //cuando es igual a 1 no esta entregado
                        ->where('area.id', $con)
                        ->select('users.name as nombre', 'users.apellido')
                        ->orderBy('users.name', 'asc')
                        ->get();
            
                $totaldar = count($datosdar);

        } else {
            //$arr ;
            $b = 1;
            $datos = 0;
            $jefes = DB::table('jefes_tot')->where('id_reporta', $idlog)
                ->join('users', 'jefes_tot.id_jefe', 'users.id')
                ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                ->join('area', 'cargo.id_area', '=', 'area.id')
                ->select('cargo.id_area')
                ->distinct('cargo.id_area')
                ->get();

            //aqui se debe recorrer la consulta puesto que al consultar a la tabla jefes_tot se encuentra
            //dos jefes vinculados por lo tanto se juntan dos areas o dependencias que tienen personal a cargo
            for ($i = 0; $i < count($jefes); $i++) {
                $arr[$i] =  DB::table('insignia_obtenida')
                    ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                    ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                    ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                    ->join('area', 'cargo.id_area', '=', 'area.id')
                    ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                    ->where('insignia_obtenida.entregado', 1) //cuando es igual a 1 no esta entregado
                    ->where('area.id', $jefes[$i]->id_area)
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
                        'premios.name as nompre'
                    )
                    ->orderBy('users.name', 'asc')
                    ->get();

                    $totalSindar += count($arr[$i]); //contador

                //total de usuarios entregaron premio

                $tot[$i] =  DB::table('insignia_obtenida')
                    ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                    ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                    ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                    ->join('area', 'cargo.id_area', '=', 'area.id')
                    ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                    ->where('insignia_obtenida.entregado', '=', 2) //cuando es igual a 1 no esta entregado
                    ->where('area.id', $jefes[$i]->id_area)
                    ->select(
                        'users.name as nombre',
                        'users.apellido',
                    )
                    ->orderBy('users.name', 'asc')
                    ->get();
                
                $totaldar = count($tot[$i]);

            }
          
        }
       
        return view('jefe.vistareporte')->with('b', $b)->with('datos', $datos)->with('res', $arr)->with('totalsindar', $totalSindar)->with('totaldar', $totaldar);
    }

    public function cambiar_estado($id)
    {
        $pro = ReconocimientosModal::find($id);
        $es = $pro->entregado;
        if ($es == 1) {
            $pro->entregado = 2;
            $pro->save();
        } else {
            $pro->entregado = 1;
            $pro->save();
        }
        // Session::flash('mensaje', 'El estado ha sido actualizado con éxito!'); 
        return back();
    }

    public function consultar_entregados()
    {
       
        $idlo = auth()->id();
        $totalSindar = 0;
        $totaldar = 0;

        $consulta = DB::table('users')->where('users.id', $idlo)
            ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
            ->select('cargo.id_area as area')->first();
        $c = $consulta->area;
        $jefecon = DB::table('jefes_tot')->where('id_reporta', $idlo)->count(); //consultar si esta vinculado en la tabla
        
        if ($jefecon == 0) {
            $b = 0;
            $arr = 0;
            $datos = DB::table('insignia_obtenida')
                ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                ->join('area', 'cargo.id_area', '=', 'area.id')
                ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                //->join('comportamiento_categ', 'insignia.id_categoria', '=', 'comportamiento_categ.id')
                ->where('insignia_obtenida.entregado', 2) //cuando es igual a 1 no esta entregado
                ->where('area.id', $c)
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
                    'premios.name as nompre'
                )
                ->orderBy('users.name', 'asc')
                ->get();

            $totaldar = count($datos);

            //usuarios que no reciben recompensa

            $datosindar = DB::table('insignia_obtenida')
                ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                ->join('area', 'cargo.id_area', '=', 'area.id')
                ->where('insignia_obtenida.entregado', 1) //cuando es igual a 1 no esta entregado
                ->where('area.id', $c)
                ->select('users.name as nombre', 'users.apellido')
                ->orderBy('users.name', 'asc')
                ->get();
            
            $totalSindar = count($datosindar);
            
        } else {

            //$arr ;
            $b = 1;
            $datos = 0;
            $jefes = DB::table('jefes_tot')->where('id_reporta', $idlo)
                ->join('users', 'jefes_tot.id_jefe', 'users.id')
                ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                ->join('area', 'cargo.id_area', '=', 'area.id')
                ->select('cargo.id_area')
                ->get();

            //aqui se debe recorrer la consulta puesto que al consultar a la tabla jefes_tot se encuentra
            //dos jefes vinculados por lo tanto se juntan dos areas o dependencias que tienen personal a cargo
            for ($i = 0; $i < count($jefes); $i++) {
                $arr[$i] =  DB::table('insignia_obtenida')
                    ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                    ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                    ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                    ->join('area', 'cargo.id_area', '=', 'area.id')
                    ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                    //->join('comportamiento_categ', 'insignia.id_categoria', '=', 'comportamiento_categ.id')
                    ->where('insignia_obtenida.entregado', 2) //cuando es igual a 1 no esta entregado
                    ->where('area.id', $jefes[$i]->id_area)
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
                        'premios.name as nompre'
                    )
                    ->orderBy('users.name', 'asc')
                    ->get();
                
                $totaldar += count($arr[$i]); //usuarios recibieron premio

                //usuarios sin recibir premio
            
                $tot[$i] =  DB::table('insignia_obtenida')
                        ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                        ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                        ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                        ->join('area', 'cargo.id_area', '=', 'area.id')
                        ->where('insignia_obtenida.entregado', 1) //cuando es igual a 1 no esta entregado
                        ->where('area.id', $jefes[$i]->id_area)
                        ->select(
                            'users.name as nombre',
                            'users.apellido'
                        )
                        ->orderBy('users.name', 'asc')
                        ->get();
                    
                $totalSindar += count($tot[$i]); //usuarios sin recibir premio
                
            }
        }
        

        return view('jefe.reporte_entrega')->with('b', $b)->with('datos', $datos)->with('res', $arr)->with('totaldar', $totaldar)->with('totalsindar', $totalSindar);
    }

    public function reporte_recompensas($id)
    {
        $idlo = auth()->id();
        $consulta = DB::table('users')->where('users.id', $idlo)
            ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
            ->select('cargo.id_area as area')->first();
        $c = $consulta->area;
        $jval = DB::table('jefes_tot')->where('id_reporta', $idlo)->count();
        if ($jval == 0) {
            return Excel::download(new ProductsExport($id, $c), 'reporte_recompensa.xlsx');
        } else {

            $j = DB::table('jefes_tot')->where('id_reporta', $idlo)
                ->join('users', 'jefes_tot.id_jefe', 'users.id')
                ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                ->join('area', 'cargo.id_area', '=', 'area.id')
                ->select('cargo.id_area')
                ->get();

            return Excel::download(new JefesExcel($id, $j), 'reportes.xlsx');
        }
    }
}
