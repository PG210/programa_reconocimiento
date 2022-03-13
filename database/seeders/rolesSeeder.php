<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;//interacciones con las consultas

class rolesSeeder extends Seeder
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
            'descripcion' => 'admin'
            ],
            [
            'descripcion' => 'usuario'
            ],
            [
             'descripcion' => 'jefe'  
            ]

        ];
        DB::table('roles')->insert($datos);//inserta los datos a la tabla roles
    }
}
