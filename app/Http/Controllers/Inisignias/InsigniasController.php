<?php

namespace App\Http\Controllers\Inisignias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Insignias\InsigniasModel;
use App\Models\Categorias\Comportamiento;
use App\Models\Categorias\Categoria_reco;
use App\Models\Categorias\Premios;
use App\Models\Insignias\PuntosModel; // para cambiar el nombre de los puntos
use App\Models\Reconocimientos\ReconocimientosModal;
use Intervention\Image\Facades\Image; // optimizar las imagenes
use Illuminate\Support\Facades\Session;

class InsigniasController extends Controller
{
    public function registrar()
    {
        $comportamiento = Comportamiento::where('descripcion', '!=', 'Default')->get(); //debe haber una categoria por defecto 
       
        $categ = DB::table('categoria_reconoc')
            ->join('comportamiento_categ', 'id_comportamiento', 'comportamiento_categ.id')
            ->select('categoria_reconoc.id', 'categoria_reconoc.nombre', 'categoria_reconoc.rutaimagen', 'comportamiento_categ.descripcion as compor', 'categoria_reconoc.id_comportamiento', 'categoria_reconoc.puntos')
            ->orderBy('compor', 'ASC')
            ->get();
       
        return view('insignias.insignias')->with('dat', $comportamiento)->with('categ', $categ);
    }

    public function premios()
    {
        $img = DB::table('premios')->get();
        return view('insignias.premios')->with('dat', $img);
    }

    public function elimpremios(Request $request)
    {
        $id = $request->idpre;

        $val = DB::table('insignia')->where('id_premio', '=', $id)->count();
        if ($val == 0) {
            DB::table('premios')->delete($id);
            Session::flash('eliminarexit', 'Recompensa eliminada correctamente!');
        } else {
            Session::flash('eliminarexit', 'No es posible eliminar la recompensa porque está vinculada a otros registros.');
        }
        return back();
    }

    public function insignia()
    {
        $pre = DB::table('premios')->get();
        $categ = DB::table('comportamiento_categ')->get();
        $res = DB::table('insignia')->count();
        $nompuntos = PuntosModel::findOrFail(1);
        if ($res != 0) {
            $b = 1;
            $insignia = DB::table('insignia')
                ->join('premios', 'id_premio', '=', 'premios.id')
                ->select('insignia.id', 'insignia.name', 'insignia.descripcion', 'insignia.puntos', 'insignia.rutaimagen', 'premios.name as prenom', 'insignia.tipo')
                ->get();
        } else {
            $b = 0;
            $r = array('name' => 'Sin datos', 'descripcion' => 'Sin datos', 'puntos' => '0', 'id_premio' => '0', 'rutaimagen' => 'sin datos');
            $insignia = $r;
        }

        return view('insignias.reginsignia')->with('pre', $pre)->with('insignia', $insignia)->with('b', $b)->with('categ', $categ)->with('nompuntos', $nompuntos);
    }

    //=================== modificar puntos ====
    public function modpuntos(Request $request)
    {
        // modificar el nombre de los puntos
        PuntosModel::findOrFail(1)->update(['descripcion' => $request->nompunto]);
        return back();
    }

    public function reginsig(Request $request)
    {
        $category = new Categoria_reco();
        $category->nombre = $request->input('nombre');
        $category->id_comportamiento = $request->input('scompor');
        $category->puntos = $request->input('puntos');
        $category->save();
        return back();
    }

    public function registroinsignia(Request $request)
    {
        $idcat = $request->input('categoria');
        $category = new InsigniasModel();
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $val = "insignia" . time() . "." . $file->guessExtension();
            $ruta = public_path("imgpremios/" . $val);

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

            $category->rutaimagen = $val; //ingresa el nombre de la ruta a la base de datos
            $category->name = $request->input('nombre');
            $category->descripcion = $request->input('descripcion');
            $category->id_premio = $request->input('premio');
            $category->puntos = $request->input('puntos');
            if (strpos($idcat, 'puntos') === false) {
                $category->id_categoria = $idcat; // si no esta la palabra puntos
            } else {
                $category->tipo = 1;  //si es una insignia de puntos
            }
            $category->save();
        }
        return back();
    }
    //===========eliminar las insignias ============
    public function deleteinsig(Request $request)
    {
        $id = $request->idin;
        $dato = InsigniasModel::find($id);
        $validar = ReconocimientosModal::where('id_insignia', $id)->count();
        if ($validar != 0) {
            Session::flash('mensajeerror', 'No es posible eliminar la insignia porque está vinculada a otros registros.');
            return back();
        } else {
            $dato->delete();
            Session::flash('mensaje', 'Insignia eliminada con éxito!');
            return back();
        }
    }

    //aqui se obtinene reporte para jefes y usuario de las insignias que puede ganar
    public function reporte()
    {
        $val = DB::table('insignia')->count();
        if ($val != 0) {
            $b = 1;
            $coninsig = DB::table('insignia')
                ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                //->join('comportamiento_categ', 'insignia.id_categoria', '=', 'comportamiento_categ.id')
                ->select(
                    'insignia.id as idinsig',
                    'insignia.name',
                    'insignia.descripcion',
                    'insignia.puntos',
                    'premios.descripcion as despremio',
                    'premios.name as nompre',
                    'insignia.rutaimagen as imginsig',
                    'premios.rutaimagen as imgpre'
                )
                ->get();
        } else {
            $b = 0;
            $coninsig = 0;
        }


        return view('jefe.insigreporte')->with('coninsig', $coninsig)->with('b', $b);
    }

    public function actualizarpre($id)
    {

        $datos = DB::table('premios')->where('premios.id', '=', $id)->get();
        return view('insignias.actupremio')->with('datos', $datos);
    }

    public function actupremion(Request $request)
    {
        $id = $request->idupdate;

        $pre = Premios::findOrfail($id); //buscar el id del producto para actualizar  

        if ($request->hasFile('imgupdate')) {
            $file = $request->file('imgupdate');
            $val = "premio" . time() . "." . $file->guessExtension();
            $ruta = public_path("imgpremios/" . $val);
            // Crear una instancia de la imagen
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

            $pre->rutaimagen = $val; //ingresa el nombre de la ruta a la base de datos
        }
        $pre->name = $request->input('nombreupdate');
        $pre->descripcion = $request->input('desupdate');
        $pre->save();
        Session::flash('actualizadopre', 'La recompensa se ha actualizado correctamente.');
        return back();
    }

    //vista de formulario insignia
    public function vistainsig($id)
    {
        $datosin = '';
        $pre = DB::table('premios')->get();
        $categ = DB::table('comportamiento_categ')->get();
        $puntos = DB::table('puntosconfig')->first();
        #==========================================================
        $insigcom = DB::table('insignia')->where('insignia.id', '=', $id)
            ->join('premios', 'id_premio', '=', 'premios.id')
            ->join('comportamiento_categ', 'id_categoria', '=', 'comportamiento_categ.id')
            ->select(
                'insignia.id',
                'insignia.name',
                'insignia.descripcion',
                'insignia.puntos',
                'insignia.rutaimagen',
                'premios.name as prenom',
                'premios.id as idpremio',
                'comportamiento_categ.id as idcateg',
                'comportamiento_categ.descripcion as descateg'
            )
            ->get();

        if (count($insigcom) == 0) {
            $insigcom =  DB::table('insignia')->where('insignia.id', '=', $id)
                ->join('premios', 'id_premio', '=', 'premios.id')
                ->select(
                    'insignia.id',
                    'insignia.name',
                    'insignia.descripcion',
                    'insignia.puntos',
                    'insignia.rutaimagen',
                    'premios.name as prenom',
                    'premios.id as idpremio'
                )
                ->get();
        }

        $datosin = $insigcom;

        return view('insignias.actuinsig')->with('puntos', $puntos)->with('datosin', $datosin)->with('pre', $pre)->with('categ', $categ);
    }

    //actualizar insignias
    public function formactuinsig(Request $request, $id)
    {
        $idcat = $request->input('categoria');
        $ins = InsigniasModel::findOrfail($id); //buscar el id del producto para actualizar  
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $val = "insignia" . time() . "." . $file->guessExtension();
            $ruta = public_path("imgpremios/" . $val);

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

            $ins->rutaimagen = $val; //ingresa el nombre de la ruta a la base de datos   
        }
        $ins->name = $request->input('nombre');
        $ins->descripcion = $request->input('descripcion');
        $ins->puntos = $request->input('puntos');
        $ins->id_premio = $request->input('premio');
        if (strpos($idcat, 'puntos') === false) {
            $ins->id_categoria = $request->input('categoria'); // si no esta la palabra puntos
        } else {
            $ins->tipo = 1;  //si es una insignia de puntos
        }
        $ins->save();

        Session::flash('actualizainsig', 'Insignia Actualizada Correctamente!');
        return back();
    }
}
