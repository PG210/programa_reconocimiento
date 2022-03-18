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
        return view('insignias.insignias')->with('dat', $comportamiento);
    }

    public function premios(){
        //$comportamiento = Comportamiento::all();//debe haber una categoria por defecto 
        return view('insignias.premios');
    }

    public function insignia(){ 
        return view('insignias.reginsignia');
    }

    public function reginsig(Request $request){

        $category = new Categoria_reco();
        $category->nombre = $request->input('nombre');
        $category->descripcion = $request->input('descripcion');
        $category->id_comportamiento = $request->input('id');
        $category->rutaimagen = $request->input('imagen');
       
        $category->save();
        return back();
    }


}
