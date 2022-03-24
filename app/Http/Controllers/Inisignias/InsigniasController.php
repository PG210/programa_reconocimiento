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
        $comportamiento = Comportamiento::all();//debe haber una categoria por defecto 
        $categ = DB::table('Categoria_reconoc')->get();
        return view('insignias.insignias')->with('dat', $comportamiento)->with('categ', $categ);
    }

    public function premios(){
        $img=DB::table('premios')
        ->get();
        return view('insignias.premios')->with('dat', $img);
    }

    public function insignia(){ 
        $pre=DB::table('premios')
        ->get();
        return view('insignias.reginsignia')->with('pre', $pre);
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
            $category->descripcion = $request->input('des');
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
            $category->puntos = $request->input('puntos'); 
            $category->save();
            return back();
           }

    }


}
