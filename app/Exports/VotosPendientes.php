<?php

namespace App\Exports;

use App\Models\EstadoVotModel\RegVotoModel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class VotosPendientes implements FromQuery,  WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $anio;
    protected $per;
    protected $tcat;

    public function __construct($anio, $per, $tcat)
    {
        $this->anio = $anio;
        $this->per = $per;
        $this->tcat = $tcat;
        
    }

    public function query()
    {
        return RegVotoModel::join('users','postulado.id_votante', '=', 'users.id')
            ->join('comportamiento_categ','postulado.id_votocat', '=', 'comportamiento_categ.id')
            ->join('estavotacion','postulado.id_estado', '=', 'estavotacion.id')
            ->where('estavotacion.anio', $this->anio)
            ->where('estavotacion.periodo', $this->per)
            ->select(
                'users.name', 
                'users.apellido', 
                'users.email', 
                'estavotacion.anio',
                'estavotacion.periodo',
                DB::raw( 'COUNT(postulado.id_votocat) as nvotos'),
                DB::raw('IF(' . $this->tcat . ' - COUNT(postulado.id_votocat) = 0, "0", ' . $this->tcat . ' - COUNT(postulado.id_votocat)) as votos_pendientes')

            )
            ->groupBy('users.name', 'users.apellido', 'users.email', 'estavotacion.anio', 'estavotacion.periodo');
    }
    
    public function headings(): array //encabezado del excel implementar WithHeadings
    {   
          return ["Nombre", "Apellido", "Correo", "Año", "Periodo", "No Votos", "Votos_pendientes" ];
    }

//aplicar color al encabezado
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:G1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('F8FF28');

            },
        ];
    }
}