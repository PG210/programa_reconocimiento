<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
            // Opcionalmente si queremos reinicar la cola cada 10 minutos
            // $schedule->command('queue:work --daemon')->everyFiveMinutes();
             $schedule->command('queue:restart')->everyTenMinutes();
             $schedule->command('dispatch:birthday-emails')->daily(); //mensajes de felicitaciones
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
