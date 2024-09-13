<?php

namespace App\Http\Controllers\Comunicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comunicacion\ComunicacionModel;
use Intervention\Image\Facades\Image; // optimizar las imagenes

class ComunicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $imagen1 = ComunicacionModel::where('posicion', 1)->first();
        $imagen2 = ComunicacionModel::where('posicion', 2)->first();
        $imagen3 = ComunicacionModel::where('posicion', 3)->first();
        $imagen4 = ComunicacionModel::where('posicion', 4)->first();
        //obtener todas las imagenes ===
        $images = ComunicacionModel::orderBy('posicion', 'asc')->get();
        $estadoimg = ComunicacionModel::where('posicion', 1)->select('estado')->first();
        return view('admin.comunicacion')->with(['imagen1' => $imagen1, 'imagen2' => $imagen2, 'imagen3' => $imagen3, 'imagen4' => $imagen4, 'images' => $images, 'estadoimg' => $estadoimg]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //========== imagenes =====
        if ($request->hasFile('imgone')) {
            $file = $request->file('imgone');
            $val = "imgcarrucel" . time() . "." . $file->guessExtension(); // este se debe guardar
            $ruta = public_path("dist/carrucel/" . $val);
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
            $category = new ComunicacionModel();
            $category->imagen = $val;
            $category->descrip = $request->desone;
            $category->posicion = $request->posicion;
            $category->estado = 2;
            $category->save();
        }
        //==========regresar la info guardada===========
        $imagen1 = ComunicacionModel::where('posicion', 1)->first();
        $imagen2 = ComunicacionModel::where('posicion', 2)->first();
        $imagen3 = ComunicacionModel::where('posicion', 3)->first();
        $imagen4 = ComunicacionModel::where('posicion', 4)->first();
        //obtener todas las imagenes ===
        $images = ComunicacionModel::orderBy('posicion', 'asc')->get();
        //estado de las imagenes
        $estadoimg = ComunicacionModel::where('posicion', 1)->select('estado')->first();

        return back()->with(['imagen1' => $imagen1, 'imagen2' => $imagen2, 'imagen3' => $imagen3, 'imagen4' => $imagen4, 'images' => $images, 'estadoimg' => $estadoimg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return $id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //actualizar datos
        $imagen = ComunicacionModel::findOrFail($id);
        $imagen->colorletra = $request->colorletra;
        if ($request->has('checkfondo') && $request->checkfondo == '1')
            $imagen->colorfondo = '';
        else
            $imagen->colorfondo = $request->colorfondo;
        $imagen->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $imagen = ComunicacionModel::findOrFail($id);
        $imagen->delete();
        return back()->with('success', 'Imagen eliminada exitosamente.');
    }

    // publicar
    public function publicar()
    {
        $estadoim = ComunicacionModel::where('posicion', 1)->first();
        if ($estadoim->estado == 2)
            $estadoim->estado = 1;
        else
            $estadoim->estado = 2;
        $estadoim->save();
        return back();
    }
}
