<?php

namespace App\Http\Controllers\Inisignias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Categorias\Comportamiento;

class CategoriasController extends Controller
{
    public function registrar(){
        $comportamiento = Comportamiento::all();//debe haber una categoria por defecto 
        return view('insignias.categorias')->with('dat', $comportamiento);
    }

    public function regis_cat(Request $request){
        $category = new Comportamiento();
        $category->descripcion = $request->input('descrip');
        $category->puntos = $request->input('puntos');
        $category->save();
        return back();
    }
    
}
