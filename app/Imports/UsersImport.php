<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use DB;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {  
        if(empty($row[8])) {
            return "Hola";
        }

        // Validar que el correo electrónico es válido
        if (!filter_var($row[6], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("El correo electrónico no es válido.");
        }
       
        $val = DB::table('users')->where('email', '=', $row[6])->count(); //valida los usuarios registrados
        if($val == 0){

           $datos = new User([
                'name' => $row[0],
                'apellido' => $row[1],
                'direccion'  => $row[2],
                'telefono'  => $row[3],
                'id_rol'  => $row[4],
                'id_cargo'  => $row[5],
                'email' => $row[6] ,
                'password' =>  Hash::make($row[7]),
                'id_estado'  => $row[8],
            ]);
            $datos->save();
            return $datos;
        }else{
            return null;
        }
    }
}
