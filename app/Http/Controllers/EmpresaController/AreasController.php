<?php

namespace App\Http\Controllers\EmpresaController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area\AreaModel;
use App\Models\Area\CargoModel;
use DB;
use Session;


class AreasController extends Controller
{
    public function index(){
        return view('admin.areas');
    }

    public function registrar(Request $request){
        $nom=$request->nombre;
        $val=DB::table('area')->where('nombre', '=', $nom)->count();
        if($val==0){

            $category= new AreaModel();
            $category->nombre = $request->input('nombre');
            $category->save();
            //return back();
            $info=DB::table('area')->get();
            return response(json_decode($info),200)->header('Content-type', 'text/plain');

        }else{

            return \Response::json([
                'error'  => 'Error datos'
            ],422);
           
        }
       
    }

    public function eliminar($id){
            $val=DB::table('cargo')->where('cargo.id_area','=',$id)->count();
            if($val!=0){
                Session::flash('mensajeerror', 'No se puede eliminar! Categoria se encuentra vinculada');
                return back();
            }else{
                Session::flash('mensaje', 'Eliminado con éxito!');
                DB::table('area')->where('area.id','=',$id)->delete();
                return back();
            }
    }

    public function consultar(Request $request){
        if($request->infor==1){
            $info=DB::table('area')->get();
            return response(json_decode($info),200)->header('Content-type', 'text/plain');
        }
       
    }

    public function  vistacar(){
        $area=DB::table('area')->get();
        $val=DB::table('cargo')->join('area', 'cargo.id_area', '=', 'area.id')
        ->select('cargo.id as idcar', 'cargo.nombre as cargonom', 'area.nombre as areanom')->count();
        if($val!=0){
            $b=1;
            $info=DB::table('cargo')->join('area', 'cargo.id_area', '=', 'area.id')
            ->select('cargo.id as idcar', 'cargo.id_area as idarea', 'cargo.nombre as cargonom', 'area.nombre as areanom')->get();
        }else{
            $b=0;
            $info="sin datos";
        }
        return view('admin.cargos')->with('area',$area)->with('info',$info)->with('b',$b);
    }

    public function regcargo(Request $request){
        $nom=$request->cargo;
        $id=$request->idarea;
        $val=DB::table('cargo')->where('nombre', '=', $nom)->where('id_area', '=', $id)->count();
        if($val==0){

            $category= new CargoModel();
            $category->nombre = $request->input('cargo');
            $category->id_area = $request->input('idarea');
            $category->save();
            //return back();
            $info=DB::table('cargo')->join('area', 'cargo.id_area', '=', 'area.id')
                  ->select('cargo.id as idcar', 'cargo.nombre as cargonom', 'area.nombre as areanom')->get();
            Session::flash('mensaje', 'Dato Guardado De Forma Ëxitosa!');
            return back()->with('info', $info);
        }else{
            Session::flash('mensajeerror', 'El dato ya esta vinculado en el area!');
            return back();
           
        }
    }

    public function elimcargo($id){

        $val=DB::table('users')->where('users.id_cargo','=',$id)->count();
        if($val!=0){
            Session::flash('mensajeerror', 'No se puede eliminar! Categoria se encuentra vinculada');
            return back();
        }else{
            Session::flash('mensaje', 'Eliminado con éxito!');
            DB::table('cargo')->where('cargo.id','=',$id)->delete();
            return back();
        }
        
    }

    public function cargoactu(Request $request){
        $car = CargoModel::find($request->idcargo);
        $car->id_area = $request->idar;
        $car->nombre= $request->car;
        $car->save();
        return back();

    }
   
}
