<?php

namespace App\Http\Controllers\ColorsController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comunicacion\Settings;
use Illuminate\Support\Facades\File;

class Colors extends Controller
{
  public function index(){
        $data = Settings::all();
        return view('admin.settings', compact('data'));
  }

  //registrar nueva configuracion 
  public function register(Request $request){
    try{
        //validar
        $tipo = $request->tipo;
        $mensaje = new Settings();
        $mensaje->tipo = $request->tipo;
        if ($tipo == 1){ //colores
            $mensaje->key = $request->key;
            $mensaje->value = $request->color;
        }else{ //imagen de logo empresa (interno)
            if ($request->hasFile('imagen')) {
                $file = $request->file('imagen');
                $val = "imglogo" . time() . "." . $file->guessExtension();
                $ruta = public_path("dist/img/");
                $file->move($ruta, $val); //guardar img
                $mensaje->link = $val;
            }
        }
        $mensaje->save();


        return back()->with('success', 'Dato guardado correctamente.');

    }catch(\Exception $e){

      return back()->with('error', 'Hubo un problema al guardar los datos.');

    }
  }

  //========= eliminar datos ==========
  public function deleteConfig(Request $request){
    
    $config = Settings::find($request->id);
    if ($config) {
        $config->delete();
        return back()->with('success', 'Dato eliminado correctamente.');
    }
    return back()->with('error', 'Hubo un problema al eliminar el dato.');
  }

  //=========== actualizar colores =========
  public function updateConfig(){
    // Cargar los valores de colores desde la base de datos
    $settings = Settings::where('tipo', 1)->pluck('value', 'key');

    // Obtener el contenido original de colores.css
    $cssPath = public_path('dist/css/r.css');
    $cssContent = File::get($cssPath);

    // Reemplazar las variables CSS con los valores desde la base de datos
    foreach ($settings as $key => $value) {
        $cssContent = preg_replace("/--{$key}:[^;]+;/", "--{$key}: {$value};", $cssContent);
    }

    // Guardar el nuevo contenido CSS en el archivo
    File::put($cssPath, $cssContent);
    return back()->with('success', 'CSS actualizado correctamente.');
    
  }

}

