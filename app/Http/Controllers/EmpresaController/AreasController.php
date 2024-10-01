<?php

namespace App\Http\Controllers\EmpresaController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area\AreaModel;
use App\Models\Area\CargoModel;
use App\Models\Licencias\LicenciasModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Usuarios\Usuarios;
use App\Models\Eventos\AntiguedadModel; // para antiguedad
use App\Models\Eventos\CumpleModel; // cumpleanios
use Intervention\Image\Facades\Image; // optimizar las imagenes
use App\Models\Eventos\EstadoEventosModel;


class AreasController extends Controller
{
    public function index(){
        $areas = AreaModel::all();
        $licencias = LicenciasModel::first();
        $date = Carbon::now()->format('Y-m-d');
        $totaluser = DB::table('users')->where('id_rol', '!=', '1')->count();
        return view('admin.areas')->with('areas', $areas)->with('licencias', $licencias)->with('date', $date)->with('totaluser', $totaluser);
    }

    public function registrar(Request $request){

        $nom = strtolower($request->nombre);
        $val = DB::table('area')->whereRaw('LOWER(nombre) = ?', [$nom])->count();
        if($val==0){
            $category= new AreaModel();
            $category->nombre = $request->input('nombre');
            $category->save();   
        }
        return back();
       
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

    //funcion para registrar licencias
    public function reglicencias(Request $request){
        $val = LicenciasModel::all();
     
        if(count($val) != 0){
            $licencia = LicenciasModel::first();
            $licencia->numlicencia = $request->asig;
            $licencia->vencimiento = $request->vencimiento; 
            $licencia->save();
            
        }else{
            $licencia = new LicenciasModel();
            $licencia->numlicencia = $request->asig;
            $licencia->vencimiento = $request->vencimiento; 
            $licencia->save();
        }

        // actualizar la fecha de las licencias
        $licencias = LicenciasModel::first();
        $datehoy = Carbon::now(); //fecha actual
        $datevence = Carbon::parse($licencias->vencimiento); //fecha de vencimiento de la db
        
        if($datehoy->isSameDay($datevence)){
            // Actualizar el estado a 1 para esos usuarios
            Usuarios::where('id_estado', 1)->where('id_rol', '!=', 1)
                    ->update(['id_estado' => 2]);
        }else{
            Usuarios::where('id_estado', 2)->where('id_rol', '!=', 1)
                     ->update(['id_estado' => 1]);
        }
        
       return back();
    }

  //==========================
  public function eventos(){
    $cumple = CumpleModel::first();
    $ant = AntiguedadModel::all();
    $monthup = Carbon::now()->month; //fecha actual
    $monthName = ucfirst(Carbon::now()->translatedFormat('F'));
    $datehoy = Carbon::now()->format('Y-m-d'); //fecha actual
    $estado =  EstadoEventosModel::first();
   
    $usuarios = Usuarios::whereMonth('fecna', $monthup)
                ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                ->join('area', 'cargo.id_area', '=', 'area.id')
                ->select('users.id', 'users.name', 'users.apellido', 'users.imagen', 
                        DB::raw("DATE_FORMAT(fecna, CONCAT(YEAR(CURDATE()), '-%m-%d')) as fecha_cumple"), 
                        'cargo.nombre as cargo', 'area.nombre as area', DB::raw('1 as estado'))
                ->get(); //estado 1 para cumpleanios
    
    //consulta para aniversarios
    $aniversario = Usuarios::whereMonth('fecingreso', $monthup)
                    ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                    ->join('area', 'cargo.id_area', '=', 'area.id')
                    ->select('users.id', 'users.name', 'users.apellido', 'users.imagen', 
                        DB::raw("DATE_FORMAT(fecingreso, CONCAT(YEAR(CURDATE()), '-%m-%d')) as fecha_aniversario"), 
                        DB::raw("TIMESTAMPDIFF(YEAR, fecingreso, CURDATE()) as total_anios"),
                        'cargo.nombre as cargo', 'area.nombre as area', DB::raw('2 as estado'))->get();

    return view('admin.eventos', compact('cumple', 'ant', 'usuarios', 'monthName', 'aniversario', 'datehoy', 'estado'));
  }

  public function happybirthday(Request $request){
     $val = '';
     if($request->hasFile('file')){                 
        $file = $request->file('file');
        $val = "imgcumple".time().".".$file->guessExtension(); // este se debe guardar
        $ruta = public_path("dist/eventos/".$val);
        // Crear una instancia de la imagen y redimensionarla si es necesario
        $img = Image::make($file->getRealPath());

        // Redimensionar la imagen si es necesario
        $img->resize(700, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        // Optimizar la imagen ajustando la calidad (70% en este ejemplo) y manteniendo la extensión original
        $img->encode($file->guessExtension(), 80);
        // Guardar la imagen optimizada en la ruta especificada
        $img->save($ruta);
        }
        //===========================================
        $validar = CumpleModel::first();
        if(isset($validar->imagen)){
            $datos = CumpleModel::first();
            if(!empty($val)){
              $datos->imagen = $val;
            }
            $datos->descrip = $request->descrip;
            $datos->save();
        }else{
            $category = new CumpleModel();
            $category->imagen = $val;
            $category->descrip = $request->descrip;
            $category->save();
        }
       
    return back();
  }

  public function antique(Request $request){
    if($request->hasFile('imagen')){                 
        $file = $request->file('imagen');
        $val = "imgantiguedad".time().".".$file->guessExtension(); // este se debe guardar
        $ruta = public_path("dist/eventos/".$val);
        // Crear una instancia de la imagen y redimensionarla si es necesario
        $img = Image::make($file->getRealPath());
        // Redimensionar la imagen si es necesario
        $img->resize(700, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        // Optimizar la imagen ajustando la calidad (70% en este ejemplo) y manteniendo la extensión original
        $img->encode($file->guessExtension(), 80);
        // Guardar la imagen optimizada en la ruta especificada
        $img->save($ruta);
        //===========================================
        $category = new AntiguedadModel();
        $category->imagen = $val;
        $category->descrip = $request->des;
        $category->tiempo = $request->tem;
        $category->nombre = $request->nom;
        $category->save();
    }
    return back();
  }
   
  //eliminar datos
  public function deletevento($id){
    $antiguedad = AntiguedadModel::find($id);
    if ($antiguedad) {
        $antiguedad->delete();
    }
    return back();
  }

  //activar o desactivar eventos
  public function activeCumple(Request $request){
    
     $estado = $request->estado;
     #== actualizar estado
     $createEstado = EstadoEventosModel::findOrFail(1); // Cambiado a findOrFail
     $createEstado->estado = $estado;
     $createEstado->save();
     return back();
  }

}
 