<?php

namespace App\Jobs;

use App\Services\MicrosoftGraphService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $subject;
    protected $content;
    protected $recipient;

    public function __construct($subject, $content, $recipient)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->recipient = $recipient;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MicrosoftGraphService $microsoftGraphService)
    {
        $result = $microsoftGraphService->sendMail($this->subject, $this->content, $this->recipient);

        if ($result['status'] !== 'success') {
            // Manejar el error o volver a intentar
            \Log::error("Error al enviar correo: " . $result['message']);
        }
    }
}
