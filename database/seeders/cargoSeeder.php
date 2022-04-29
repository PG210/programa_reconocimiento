<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;//interacciones con las consultas

class cargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [//array de datos 
          
            ['nombre' => 'Evolucion',
            'id_area' => 1
            ]
        ];
        DB::table('cargo')->insert($datos);//inserta los datos a la tabla cargo
    }
}
