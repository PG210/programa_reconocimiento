<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoImagen extends Seeder
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
            'tipodes' => 'Premio'
            ],
            [
            'tipodes' => 'Categoria Reconocimiento'
            ],
            [
             'tipodes' => 'Insignia'  
            ]

        ];
        DB::table('tipo_imagen')->insert($datos);//inserta los datos a la tabla roles
    }
}
