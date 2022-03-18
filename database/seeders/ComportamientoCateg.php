<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;//interacciones con las consultas

class ComportamientoCateg extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [//array de datos 
          
            ['descripcion' => 'Default',
            'puntos' => 0
            ]
        ];
        DB::table('comportamiento_categ')->insert($datos);//inserta los datos a la tabla cargo
    }
}
