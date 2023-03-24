<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InsigniaEmail extends Mailable 
{
    //implements ShouldQueue
    use Queueable, SerializesModels;
    public $subject="Ganaste una insignia";
    public $datosin;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datosin)
    {
        $this->datosin = $datosin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('correos.insignias');
    }
}
