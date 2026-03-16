<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $sid;
    protected $token;
    protected $from;
    protected $to_default;

    public function __construct()
    {
        $config = \App\Models\Configuracion::first();
        $this->sid = $config->twilio_sid ?? env('TWILIO_SID');
        $this->token = $config->twilio_token ?? env('TWILIO_TOKEN');
        $this->from = $config->twilio_from ?? env('TWILIO_FROM');
        $this->to_default = $config->twilio_to_default ?? null;
    }

    public function sendMessage($to, $message)
    {
        // Use default verified number if available (for trial accounts)
        $recipient = $this->to_default ?: $to;

        try {
            $client = new Client($this->sid, $this->token);
            $client->messages->create(
                $recipient,
                [
                    'from' => $this->from,
                    'body' => $message
                ]
            );
            return true;
        } catch (\Exception $e) {
            \Log::error("Twilio Error: " . $e->getMessage());
            return false;
        }
    }
}
