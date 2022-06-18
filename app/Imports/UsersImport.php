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
       
        $val = DB::table('users')->where('email', '=', $row[6])->count(); //valida los usuarios registrados
        if($val==0){

            return new User([
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

        }
        
    }
}
