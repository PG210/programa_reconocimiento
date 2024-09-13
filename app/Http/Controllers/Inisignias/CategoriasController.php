<?php

namespace App\Http\Controllers\Inisignias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Categorias\Comportamiento;
use App\Models\Categorias\Categoria_reco;
use Intervention\Image\Facades\Image; // optimizar las imagenes
use Illuminate\Support\Facades\Session;

class CategoriasController extends Controller
{
    public function registrar()
    {
        $comportamiento = Comportamiento::all(); //debe haber una categoria por defecto 
        return view('insignias.categorias')->with('dat', $comportamiento);
    }

    public function regis_cat(Request $request)
    {
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $val = "imgcat" . time() . "." . $file->guessExtension();
            $ruta = public_path("imgpremios/" . $val);
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

            $category = new Comportamiento();
            $category->descripcion = $request->input('descrip');
            $category->puntos = 0;
            $category->rutaimagen = $val;
            $category->save();
        }
        return back();
    }

    public function buscaractu($id)
    {
        $cat = DB::table('categoria_reconoc')->where('categoria_reconoc.id', '=', $id)->join('comportamiento_categ', 'id_comportamiento', 'comportamiento_categ.id')
            ->select('categoria_reconoc.id as idcat', 'categoria_reconoc.nombre', 'categoria_reconoc.id_comportamiento', 'categoria_reconoc.rutaimagen', 'comportamiento_categ.descripcion as des', 'comportamiento_categ.id')
            ->get();
        $com = DB::table('comportamiento_categ')->get();
        return view('admin.actucategoria')->with('cat', $cat)->with('com', $com);
    }


    public function actucat(Request $request, $id)
    {
        $res = Categoria_reco::findOrfail($id);
        $res->nombre = $request->input('nombrenew');
        $res->id_comportamiento = $request->input('comnew');
        $res->puntos = $request->input('puntosnew');
        $res->save();
        return redirect()->route('reg_insignia');
    }

    public function eliminar($id)
    {
        $val = DB::table('categoria_reconoc')->where('categoria_reconoc.id_comportamiento', '=', $id)->count();
        if ($val != 0) {
            Session::flash('mensaje', 'No se puede eliminar! Categoria se encuentra vinculada');
            return back();
        } else {
            Session::flash('mensaje', 'Eliminado con éxito!');
            DB::table('comportamiento_categ')->where('id', '=', $id)->delete();
            return back();
        }
    }
    //================== eliminar datos de comportamiento ========0
    public function deleteCom($id)
    {
        $cont = DB::table('catrecibida')->where('id_comportamiento', '=', $id)->count();
        if ($cont == 0) {
            DB::table('categoria_reconoc')->where('id', '=', $id)->delete();
        }
        return back();
    }

    public function busactualizar($id)
    {
        $cat = DB::table('comportamiento_categ')->where('comportamiento_categ.id', '=', $id)
            ->get();
        return view('admin.actualizacategor')->with('cat', $cat);
    }

    public function actualizar(Request $request, $id)
    {
        //=========buscar el id para actualizar                 
        $categoria = Comportamiento::findOrfail($id);

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $val = "imgcat" . time() . "." . $file->guessExtension();
            $ruta = public_path("imgpremios/" . $val);

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

            $categoria->rutaimagen = $val;
        }
        $categoria->descripcion = $request->input('des');
        $categoria->puntos = 0;
        $categoria->save();
        Session::flash('actualizado', 'Categoria Actualizada Correctamente!');
        return back();
    }
}
