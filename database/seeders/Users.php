<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;//interacciones con las consultas
use Illuminate\Support\Facades\Hash;


class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [//array de datos 
            [
                'name' => 'Admin',
                'apellido' => 'Evolución',
                'telefono'  => '3178916679',
                'id_rol'  => '1',
                'id_cargo'  => '1',
                'email' => 'pedro@evolucion.co' ,
                'password' =>  Hash::make('123456789'),
                'id_estado'  => '1',
            ]
        ];
        DB::table('users')->insert($datos);//inserta los datos a la tabla roles
    }
}
