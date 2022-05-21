<?php

namespace App\Mail;

use App\Models\Usuarios\Usuarios;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reconocimiento extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $datosrec;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datosrec)
    {
        //
       
        $this->datosrec = $datosrec;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('correos.reconocimiento');
    }
}
