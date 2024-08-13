<?php

namespace App\Http\Controllers\ImportacionController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;


class Importacion extends Controller
{
    public function archivoimpor(Request $request){
        $file = $request->file('archivosubido');
        try {
            Excel::import(new UsersImport, $file);
            return back()->with('success', 'Archivo importado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar el archivo: ' . $e->getMessage());
        }
    }
}
