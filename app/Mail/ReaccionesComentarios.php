<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReaccionesComentarios extends Mailable
{
    use Queueable, SerializesModels;
    public $subject="Nueva Notificación";
    public $datos;
    public $val;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datos, $val)
    {
        $this->datos = $datos;
        $this->val = $val; /*identifica a quien dirije el mensaje */
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('correos.notificacion')->with([
            'datos' => $this->datos,
            'val' => $this->val,
        ]);
    }
}
