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

        if ($limite <= 0) {
            return back()->with('error', 'No puede importar más usuarios. Ha alcanzado el límite de licencias.');
        }

        $file = $request->file('archivosubido');

        try {
            $import = new UsersImport($limite);
            Excel::import($import, $file);

            $importados = $import->getImportedCount();
            $duplicados = $import->getDuplicatedEmails();
            $correosImportados = $import->getImportedEmails();

            $mensaje = " ✅<h5> Se importaron exitosamente $importados usuario(s). </h5>";

            // Mostrar los correos registrados
            if (!empty($correosImportados)) {
                $listaImportados = implode('<br>', array_slice($correosImportados, 0, 10));
                $mensaje .= "<h6>📬 Correos registrados:</h6>$listaImportados";
                if (count($correosImportados) > 10) {
                    $mensaje .= "<br>...y " . (count($correosImportados) - 10) . " más.";
                }
            }
            
            //correos duplicados
            if (!empty($duplicados)) {
                $mensaje .= "<br><h5> !Los siguientes correos ya existían y fueron omitidos:</h5>" . implode('<br>', $duplicados);
            }

            return back()->with('success', $mensaje);

        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar el archivo: ' . $e->getMessage());
        }
    }
}
