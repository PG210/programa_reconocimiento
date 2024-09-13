<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendMailJob; //instancia el jobs
use Carbon\Carbon;
use App\Models\Usuarios\Usuarios; //usuarios
use App\Models\Eventos\AntiguedadModel; // para antiguedad
use App\Models\Eventos\CumpleModel; // cumpleanios
use Illuminate\Support\Facades\DB;


class DispatchBirthdayEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:birthday-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Despachar jobs para enviar correos de cumpleaños a los usuarios';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {   
        //fechas de cumpleanios
        $today = Carbon::now()->format('m-d'); // Fecha actual mes y dia
        $usershappy = Usuarios::whereRaw("DATE_FORMAT(fecna, '%m-%d') = ?", [$today])->get(); //obtener todos los colaboradores que cumplen anios hoy
        //fechas de aniversario
        $aniversario = Usuarios::whereRaw("DATE_FORMAT(fecingreso, '%m-%d') = ?", [$today])
                        ->select('users.id', 'users.name', 'users.apellido', 'email',
                            DB::raw("TIMESTAMPDIFF(YEAR, fecingreso, CURDATE()) as anios"))->get();

        $datos = CumpleModel::first();
        $subject = "Felicidades";
        
        if(!empty($usershappy)){
        foreach ($usershappy as $user) {
            $content = view('correos.cumple', ['datos' => $datos, 'usuario' => $user])->render();
            SendMailJob::dispatch($subject, $content, $user->email);
           // $this->info('Job para correo de cumpleaños despachado a: ' . $user->email);
        }
       }

       if(!empty($aniversario)){
        foreach ($aniversario as $userani) {
            $datoan = AntiguedadModel::where('tiempo', $userani->anios)->first();
            $content = view('correos.antiguedad', ['datos' => $datoan, 'usuario' => $userani])->render();
            SendMailJob::dispatch($subject, $content, $userani->email);
            $this->info('Job para correo de cumpleaños despachado a: ' . $userani->email);
        }
      }
    }
}
