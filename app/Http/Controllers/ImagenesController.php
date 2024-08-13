<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias\ImagenesModal;
use App\Models\Categorias\TablaImagenModal;
use App\Models\Categorias\Premios;
use Intervention\Image\Facades\Image; // optimizar las imagenes



class ImagenesController extends Controller
{
    public function registro(){
        $tipo=ImagenesModal::all();
        return view('admin.regimagen')->with('dat', $tipo);
    }

    public function regimagen(Request $request){

        $category = new TablaImagenModal();
       // $reques=$request;
        //return($reques);

     if($request->hasFile('imgruta')){
                                
            $file = $request->file('imgruta');//guarda la variable id en un file
            $val = "imagen".time().".".$file->guessExtension();//renombra el archivo subido
            $ruta = public_path("imgcomportamiento/".$val);//ruta para guardar el archivo pdf/ es la carpeta
            
           // if($file->guessExtension()=="pdf"){

            copy($file, $ruta);//ccopia el archivo de una ruta cualquiera a donde este
            $category->ruta = $val;//ingresa el nombre de la ruta a la base de datos
            $category->nombre = $request->input('nombre');
            $category->id_tipoimagen = $request->input('tipoimagen');       
            $category->save();
            return back();
           }

    }

    public function regpre(Request $request){
        $category = new Premios();
        if($request->hasFile('img')){                 
            $file = $request->file('img');
            $val = "premio".time().".".$file->guessExtension();
            $ruta = public_path("imgpremios/".$val);
            
            // Crear una instancia de la imagen y redimensionarla si es necesario
            $img = Image::make($file->getRealPath());
            
            // Redimensionar la imagen si es necesario
            $img->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            // Optimizar la imagen ajustando la calidad (70% en este ejemplo) y manteniendo la extensión original
            $img->encode($file->guessExtension(), 80);
            
            // Guardar la imagen optimizada en la ruta especificada
            $img->save($ruta);
            
            $category->rutaimagen = $val;//ingresa el nombre de la ruta a la base de datos
            $category->name = $request->input('nombre');
            $category->descripcion = $request->input('des'); 
            $category->save();
            return back();
           }
    }

    
}
