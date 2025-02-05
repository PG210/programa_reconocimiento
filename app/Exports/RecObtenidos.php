<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Illuminate\Support\Facades\DB;

class RecObtenidos implements FromCollection,  WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public $data;
    public $datcate;

    public function __construct($data, $datcate)
    {
        $this->data = $data;
        $this->datcate = $datcate;
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
                'tot' => $item->tot ?? '0',
                'c1' => $item->c1 ?? '0',
                'c2' => $item->c2 ?? '0',
                'c3' => $item->c3 ?? '0',
                'c4' => $item->c4 ?? '0',
                'c5' => $item->c5 ?? '0',
            ];
        }));
    }
    
    public function headings(): array //encabezado del excel implementar WithHeadings
    {
        return $this->datcate;
    }

    //aplicar color al encabezado
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:J1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('F8FF28');

            },
        ];
    }
   
}
