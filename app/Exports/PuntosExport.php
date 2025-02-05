<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Concerns\Exportable;

use Maatwebsite\Excel\Events\AfterSheet;

use Illuminate\Support\Collection;

class PuntosExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
         // Convertir el array multidimensional en una colección simple para Excel
         $flattenedData = collect($this->data)->flatten(1);

         return new Collection($flattenedData->map(function ($item) {
             return [
                 'nombre' => $item->nombre,
                 'ape' => $item->ape,
                 'fecmin' => $item->fecmin,
                 'fecmax' => $item->fecmax,
                 'tot' => $item->puntostot ?? '0'
             ];
         }));
    }

    public function headings(): array //encabezado del excel implementar WithHeadings
    {
        return ["Nombre", "Apellido", "F/Inicial", "F/Final", "Total puntos"];
    }

     //aplicar color al encabezado
     public function registerEvents(): array
     {
         return [
             AfterSheet::class    => function(AfterSheet $event) {
 
                 $event->sheet->getDelegate()->getStyle('A1:F1')
                         ->getFill()
                         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                         ->getStartColor()
                         ->setARGB('F8FF28');
 
             },
         ];
     }

}
