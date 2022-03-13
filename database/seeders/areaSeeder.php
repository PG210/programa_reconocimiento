<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;//interacciones con las consultas


class areaSeeder extends Seeder
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
            'nombre' => 'default'
            ]

        ];
        DB::table('area')->insert($datos);//inserta los datos a la tabla roles
    }
}
