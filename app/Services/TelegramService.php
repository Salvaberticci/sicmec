<?php

namespace App\Services;

use App\Models\Configuracion;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $token;
    protected $baseUrl;

    public function __construct()
    {
        $config = Configuracion::first();
        $this->token = $config->telegram_bot_token ?? null;
        $this->baseUrl = "https://api.telegram.org/bot{$this->token}";
    }

    /**
     * Send a simple text message.
     */
    public function sendMessage($chatId, $text, $options = [])
    {
        if (!$this->token) {
            Log::warning("Telegram Bot Token not configured.");
            return false;
        }

        $payload = array_merge([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ], $options);

        // If an inline_keyboard is provided in options, it should be under reply_markup
        if (isset($payload['inline_keyboard'])) {
            $payload['reply_markup'] = json_encode([
                'inline_keyboard' => $payload['inline_keyboard']
            ]);
            unset($payload['inline_keyboard']);
        }

        try {
            $response = Http::post("{$this->baseUrl}/sendMessage", $payload);
            return $response->json();
        } catch (\Exception $e) {
            Log::error("Telegram Send Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Register the webhook URL with Telegram.
     */
    public function setWebhook($url)
    {
        if (!$this->token)
            return false;

        try {
            $response = Http::post("{$this->baseUrl}/setWebhook", [
                'url' => $url
            ]);
            return $response->json();
        } catch (\Exception $e) {
            Log::error("Telegram Webhook Error: " . $e->getMessage());
            return false;
        }
    }
}
