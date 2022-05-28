<?php

namespace App\Exports;

use App\Models\Reconocimientos\ReconocimientosModal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class GerenteExcel implements FromQuery,  WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct($id)
    {
        $this->id = $id;
    }


    public function query()
    {
        return ReconocimientosModal::query()
                ->join('insignia', 'id_insignia', '=', 'insignia.id')
                ->join('users', 'id_usuario', '=', 'users.id')
                ->join('cargo', 'users.id_cargo', '=', 'cargo.id')
                ->join('area', 'cargo.id_area', '=', 'area.id')
                ->join('premios', 'insignia.id_premio', '=', 'premios.id')
                ->join('comportamiento_categ', 'insignia.id_categoria', '=', 'comportamiento_categ.id')
                ->where('entregado', $this->id)//cuando es igual a 1 no esta entregado
                ->select('users.name as nombre', 'users.apellido', 'cargo.nombre as cargonom', 'area.nombre as areanom', 
                        'insignia.descripcion as insigdes', 'premios.descripcion as despremio', 
                        'comportamiento_categ.descripcion as categoria', 'insignia.puntos'
                    );

    }

    public function headings(): array //encabezado del excel implementar WithHeadings
    {
        return ["Nombre", "Apellido", "Cargo", "Area", "Insignia", "Recompensa", "Categoria", "Puntos"];
    }

//aplicar color al encabezado
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:H1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('F8FF28');

            },
        ];
    }
}
