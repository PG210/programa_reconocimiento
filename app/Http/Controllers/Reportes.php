<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reconocimientos\ReconocimientosModal;
use DB;

class Reportes extends Controller
{
    public function index(){
        $datos = DB::table('insignia_obtenida')
                ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
                ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
                ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                ->join('area', 'cargo.id_area', '=', 'area.id')
                ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                ->join('comportamiento_categ', 'insignia.id_categoria', '=', 'comportamiento_categ.id')
                ->where('insignia_obtenida.entregado', 1)//cuando es igual a 1 no esta entregado
                ->select('insignia_obtenida.id as idinsig', 'insignia_obtenida.entregado as estado', 'insignia.name as nominsig', 'insignia.descripcion as insigdes', 'insignia.puntos',
                         'insignia.rutaimagen as imginsig', 'premios.descripcion as despremio', 'premios.rutaimagen as imgpre', 'comportamiento_categ.descripcion as categoria',
                        'users.name as nombre', 'users.apellido', 'cargo.nombre as cargonom', 'area.nombre as areanom')
                ->get();
        
        return view('jefe.vistareporte')->with('datos', $datos);
    }
     
    public function cambiar_estado($id){
        $pro = ReconocimientosModal::find($id);
        $es = $pro->entregado;
        if($es==1){
            $pro->entregado = 2;
            $pro->save();
        }else{
            $pro->entregado = 1;
            $pro->save();
        } 
        // Session::flash('mensaje', 'El estado ha sido actualizado con éxito!'); 
        return back();
    }

    public function consultar_entregados(){

        $datos = DB::table('insignia_obtenida')
        ->join('insignia', 'insignia_obtenida.id_insignia', '=', 'insignia.id')
        ->join('users', 'insignia_obtenida.id_usuario', '=', 'users.id')
        ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
        ->join('area', 'cargo.id_area', '=', 'area.id')
        ->join('premios', 'insignia.id_premio', '=', 'premios.id')
        ->join('comportamiento_categ', 'insignia.id_categoria', '=', 'comportamiento_categ.id')
        ->where('insignia_obtenida.entregado', 2)//cuando es igual a 1 no esta entregado
        ->select('insignia_obtenida.id as idinsig', 'insignia_obtenida.entregado as estado', 'insignia.name as nominsig', 'insignia.descripcion as insigdes', 'insignia.puntos',
                 'insignia.rutaimagen as imginsig', 'premios.descripcion as despremio', 'premios.rutaimagen as imgpre', 'comportamiento_categ.descripcion as categoria',
                'users.name as nombre', 'users.apellido', 'cargo.nombre as cargonom', 'area.nombre as areanom')
        ->get();

         return view('jefe.reporte_entrega')->with('datos', $datos);

    }
}
