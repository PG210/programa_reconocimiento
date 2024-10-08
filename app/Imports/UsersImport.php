<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithLimit; // para limitar las filas a importar
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersImport implements ToModel, WithLimit
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $limit;

    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    public function model(array $row)
    {
        if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4]) || empty($row[5]) || empty($row[6]) || empty($row[7]) || empty($row[8]) || empty($row[9])) {
            throw new \Exception('Por favor, revisa el archivo algún dato esta vacio.');   // Opcional: Lanza una excepción o maneja el error de alguna manera
        }

        $email = $row[8]; // Extraemos el correo electrónico de la fila
    
        // Verificamos si el usuario con el correo electrónico dado ya existe
        $existing_user = User::where('email', $email)->first();
    
        if ($existing_user) {
            // El usuario ya existe, omitimos esta fila
            return null;
        } else {
            // Creamos una nueva instancia de User
            $fecna = Carbon::parse($row[4])->format('Y-m-d');
            $fecin = Carbon::parse($row[5])->format('Y-m-d');
            $user = new User([
                'name' => $row[0],
                'apellido' => $row[1],
                'direccion' => $row[2],
                'telefono' => $row[3],
                'fecna' => $fecna,
                'fecingreso' => $fecin,
                'id_rol' => $row[6],
                'id_cargo' => $row[7],
                'email' => $email,
                'password' => Hash::make($row[9]),
                'id_estado' => 1,
                'imagen' => 'perfil_no_borrar.jpeg',
            ]);
    
            return $user;
        }
    }

    public function limit(): int
    {
        return $this->limit;
    }
}
