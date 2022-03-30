<?php

namespace App\Http\Controllers\Inisignias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Categorias\Comportamiento;
use App\Models\Categorias\Categoria_reco;

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

    public function buscaractu($id){
        $cat=DB::table('categoria_reconoc')->where('categoria_reconoc.id', '=', $id)->join('comportamiento_categ', 'id_comportamiento', 'comportamiento_categ.id')
             ->select('categoria_reconoc.id as idcat','categoria_reconoc.nombre', 'categoria_reconoc.descripcion','categoria_reconoc.id_comportamiento', 'categoria_reconoc.rutaimagen', 'comportamiento_categ.descripcion as des', 'comportamiento_categ.id')
             ->get();
        $com = DB::table('comportamiento_categ')->get();
        return view('admin.actucategoria')->with('cat', $cat)->with('com', $com);
    }

   
    public function actucat(Request $request, $id){
        $categoria = Categoria_reco::findOrfail($id);//buscar el id del producto para actualizar
        if($request->hasFile('imagen')){                 
            $file = $request->file('imagen');
            $val = "cateact".time().".".$file->guessExtension();
            $ruta = public_path("imgpremios/".$val);
           // if($file->guessExtension()=="pdf"){
            copy($file, $ruta);//ccopia el archivo de una ruta cualquiera a donde este
            $categoria->rutaimagen = $val;//ingresa el nombre de la ruta a la base de datos
            $categoria->nombre = $request->input('nombre');
            $categoria->descripcion = $request->input('des');
            $categoria->id_comportamiento = $request->input('com');
            $categoria->save();
            return redirect()->route('reg_insignia');
           
        }else{
            $res = Categoria_reco::findOrfail($id);
            $img = $res->rutaimagen;
            $res->rutaimagen = $img;//ingresa el nombre de la ruta a la base de datos
            $res->nombre = $request->input('nombre');
            $res->descripcion = $request->input('des');
            $res->id_comportamiento = $request->input('com');
            $res->save();
            return redirect()->route('reg_insignia');

        }
         //redirect()->route('lista_productos');
        
 }
    
}
