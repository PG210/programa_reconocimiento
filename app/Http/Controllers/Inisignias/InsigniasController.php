<?php

namespace App\Http\Controllers\Inisignias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Insignias\InsigniasModel;
use App\Models\Categorias\Comportamiento;
use App\Models\Categorias\Categoria_reco;

class InsigniasController extends Controller
{
    public function registrar(){
        $comportamiento = Comportamiento::where('descripcion', '!=', 'Default')->get();//debe haber una categoria por defecto 
        $con = DB::table('categoria_reconoc')->count();
        if($con!=0){
            $b=1;
            $categ = DB::table('categoria_reconoc')
            ->join('comportamiento_categ', 'id_comportamiento', 'comportamiento_categ.id')
            ->select('categoria_reconoc.id', 'categoria_reconoc.nombre', 'categoria_reconoc.rutaimagen', 'comportamiento_categ.descripcion as compor')
            ->get();
        }
        else{
            $b=0;
            $categ = 'sin datos';
        }
        return view('insignias.insignias')->with('dat', $comportamiento)->with('categ', $categ)->with('b', $b);
    }

    public function premios(){
        $img=DB::table('premios')
        ->get();
        return view('insignias.premios')->with('dat', $img);
    }

    public function insignia(){ 
        $pre=DB::table('premios')->get();
        $categ=DB::table('comportamiento_categ')->get();
        $res=DB::table('insignia')->count();
        if($res!=0){
            $b=1;
            $insignia=DB::table('insignia')
            ->join('premios', 'id_premio', '=', 'premios.id')
            ->select('insignia.name', 'insignia.descripcion', 'insignia.puntos', 'insignia.rutaimagen', 'premios.name as prenom')
            ->get();
        }
        else{
            $b=0;
            $r=array('name' => 'Sin datos', 'descripcion' => 'Sin datos', 'puntos' => '0', 'id_premio' => '0', 'rutaimagen' => 'sin datos');
            $insignia=$r;
        }
        return view('insignias.reginsignia')->with('pre', $pre)->with('insignia', $insignia)->with('b', $b)->with('categ', $categ);;
    }

    public function reginsig(Request $request){
        $category = new Categoria_reco();
        if($request->hasFile('imagen')){                 
            $file = $request->file('imagen');
            $val = "caterec".time().".".$file->guessExtension();
            $ruta = public_path("imgpremios/".$val);
           // if($file->guessExtension()=="pdf"){
            copy($file, $ruta);//ccopia el archivo de una ruta cualquiera a donde este
            $category->rutaimagen = $val;//ingresa el nombre de la ruta a la base de datos
            $category->nombre = $request->input('nombre');
            $category->id_comportamiento = $request->input('scompor');     
            $category->save();
            return back();
           }
    }

    public function registroinsignia(Request $request){
        //return $request;
        $category = new InsigniasModel();
        if($request->hasFile('img')){                 
            $file = $request->file('img');
            $val = "insignia".time().".".$file->guessExtension();
            $ruta = public_path("imgpremios/".$val);
           // if($file->guessExtension()=="pdf"){
            copy($file, $ruta);//ccopia el archivo de una ruta cualquiera a donde este
            $category->rutaimagen = $val;//ingresa el nombre de la ruta a la base de datos
            $category->name = $request->input('nombre');
            $category->descripcion = $request->input('descripcion');
            $category->id_premio = $request->input('premio'); 
            $category->id_categoria = $request->input('categoria');     
            $category->puntos = $request->input('puntos'); 
            $category->save();
            return back();
           }

    }

    //aqui se obtinene una insignia cada vez que obtenga cierto numero de reconocimientos

    




}
