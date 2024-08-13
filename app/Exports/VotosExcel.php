<?php

namespace App\Exports;

use App\Models\EstadoVotModel\RegVotoModel;
use App\Models\Usuarios\Usuarios; // para ver usuarios
use App\Models\EstadoVotModel\EstavotModel;
use App\Models\Categorias\Comportamiento; // para categorias

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class VotosExcel implements FromQuery,  WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct($anio, $per, $estadovot)
    {
        $this->anio = $anio;
        $this->per = $per;
        $this->estadovot = $estadovot;
    }


    public function query()
    {
        if( $this->estadovot == 1){
            return RegVotoModel::query()
                ->join('users','postulado.id_postulado', '=', 'users.id')
                ->join('comportamiento_categ','postulado.id_votocat', '=', 'comportamiento_categ.id') 
                ->join('estavotacion','postulado.id_estado', '=', 'estavotacion.id')
                ->where('estavotacion.anio', $this->anio)//se debe validar el periodo de votacion 
                ->where('estavotacion.periodo', $this->per)
                ->select('users.name', 'users.apellido', 'users.email', 'estavotacion.anio', 'estavotacion.periodo',  
                            DB::raw( 'COUNT(postulado.id_votocat) as total'))
                ->groupBy('users.name', 'users.apellido', 'users.email', 'estavotacion.anio', 'estavotacion.periodo');
               
        }elseif( $this->estadovot == 3){
            //=========== se realizo interacción con los modelos ====
            $estado = EstavotModel::where('anio',  $this->anio)->where('periodo', $this->per)->first();
            
            return Usuarios::leftJoin('postulado', function($join) use ($estado) {
                        $join->on('users.id', '=', 'postulado.id_votante')
                                ->where('postulado.id_estado', '=', $estado->id);
                    })
                    ->whereNull('postulado.id_votante')
                    ->where('id_rol', '!=', '1')
                    ->select('name', 'apellido', 'email');
                
        }
    }

    public function headings(): array //encabezado del excel implementar WithHeadings
    {   
        if( $this->estadovot == 1)
          return ["Nombre", "Apellido", "Correo", "Año", "Periodo", "Votos_recibidos"];
        elseif ( $this->estadovot == 3)
          return ["Nombre", "Apellido", "Correo"];
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