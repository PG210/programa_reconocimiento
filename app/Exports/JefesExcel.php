<?php

namespace App\Exports;

use DB;

use App\Models\Reconocimientos\ReconocimientosModal;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class JefesExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $j;
    public function __construct($id, $j)
    {
            $this->id = $id;
            $this->j = $j;
    }

    public function view(): View
    {

        for($i=0;$i<count($this->j);$i++){  
            $res[$i]= DB::table('insignia_obtenida')
            ->join('insignia', 'id_insignia', '=', 'insignia.id')
            ->join('users', 'id_usuario', '=', 'users.id')
            ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
            ->join('area', 'cargo.id_area', '=', 'area.id')
            ->join('premios', 'insignia.id_premio', '=', 'premios.id')
            ->join('comportamiento_categ', 'insignia.id_categoria', '=', 'comportamiento_categ.id')
            ->where('entregado', $this->id)//cuando es igual a 1 no esta entregado
            ->where('area.id', $this->j[$i]->id_area)//cuando es igual a 1 no esta entregado
            ->select('users.name as nombre', 'users.apellido', 'cargo.nombre as cargonom', 'area.nombre as areanom', 
                    'insignia.descripcion as insigdes', 'premios.descripcion as despremio', 
                    'comportamiento_categ.descripcion as categoria', 'insignia.puntos', 'entregado'
                )->get();
            } 

        return view('jefe.gerente')->with('res', $res);
    }

}
