<?php

namespace App\Http\Controllers\ImportacionController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Models\Licencias\LicenciasModel;
use Illuminate\Support\Facades\DB;

class Importacion extends Controller
{
    public function archivoimpor(Request $request)
    {
        //find limit of import
        $licencias = LicenciasModel::first();
        $totaluser = DB::table('users')->where('id_rol', '!=', '1')->count();

        $limite = $licencias->numlicencia - $totaluser; //limite de filas a importar segun las licencias asignadas

        $file = $request->file('archivosubido');
        try {
            Excel::import(new UsersImport($limite), $file);
            return back()->with('success', 'Se importaron exitosamente ' . $limite . ' Filas.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar el archivo: ' . $e->getMessage());
        }
    }
}
