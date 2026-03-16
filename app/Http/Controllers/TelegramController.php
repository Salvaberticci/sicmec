<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TelegramService;
use App\Models\Cliente;
use App\Models\Factura;
use App\Models\FacturasRenglone;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    protected $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Handle incoming Webhook from Telegram.
     */
    public function webhook(Request $request)
    {
        $update = $request->all();

        // Handle Callback Queries (Buttons)
        if (isset($update['callback_query'])) {
            return $this->handleCallbackQuery($update['callback_query']);
        }

        if (!isset($update['message'])) {
            return response()->json(['status' => 'ok']);
        }

        $message = $update['message'];
        $chatId = $message['chat']['id'];
        $text = trim($message['text'] ?? '');

        if (empty($text))
            return response()->json(['status' => 'ok']);

        Log::info("Telegram Message from {$chatId}: {$text}");

        // 1. Command: /start or /ayuda
        if ($text == '/start' || strtolower($text) == 'hola' || $text == '/ayuda') {
            $response = "<b>🏥 Bienvenido al Bot de SICMEC</b>\n\n" .
                "Puedo ayudarte a consultar el estado de tus solicitudes de medicamentos.\n\n" .
                "📌 <b>¿Cómo usar?</b>\n" .
                "Escribe tu número de <b>cédula</b> directamente (solo números).\n\n" .
                "Ejemplo: <code>12345678</code>";

            $this->telegram->sendMessage($chatId, $response);
            return response()->json(['status' => 'ok']);
        }

        // 2. Lookup by Cedula (Assuming it's a numeric string between 6 and 10 chars)
        if (is_numeric($text) && strlen($text) >= 6 && strlen($text) <= 10) {
            $this->handleStatusLookup($chatId, $text);
            return response()->json(['status' => 'ok']);
        }

        // 3. Fallback help
        $this->telegram->sendMessage($chatId, "No entendí eso. Por favor, ingresa tu número de cédula para consultar el estatus de tu solicitud.");

        return response()->json(['status' => 'ok']);
    }

    protected function handleStatusLookup($chatId, $cedula)
    {
        $cliente = Cliente::where('cedula', $cedula)->first();

        if (!$cliente) {
            $this->telegram->sendMessage($chatId, "❌ No encontramos ningún beneficiario registrado con la cédula <b>{$cedula}</b>.");
            return;
        }

        $facturas = Factura::where('cliente_id', $cliente->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        if ($facturas->isEmpty()) {
            $this->telegram->sendMessage($chatId, "👤 <b>{$cliente->nombre}</b>, no tienes solicitudes registradas recientemente.");
            return;
        }

        $response = "👤 <b>Beneficiario:</b> {$cliente->nombre}\n";
        $response .= "—————————————————\n";
        $response .= "📑 <b>Tus últimas solicitudes:</b>\n\n";

        $buttons = [];
        foreach ($facturas as $f) {
            $icon = $f->estatus == 'Finalizada' ? '✅' : ($f->estatus == 'Procesando' ? '⏳' : '💤');
            $fecha = $f->created_at->format('d/m/Y');

            $statusText = "{$icon} #{$f->id} - {$f->estatus} ({$fecha})";
            $response .= "{$statusText}\n";

            // Add a button for each request
            $buttons[] = [
                ['text' => "🔍 Detalle Solicitud #{$f->id}", 'callback_data' => "ver_solicitud_{$f->id}"]
            ];
        }

        $response .= "\n<i>Haz clic en los botones para ver qué medicamentos incluye cada una.</i>";

        $this->telegram->sendMessage($chatId, $response, [
            'inline_keyboard' => $buttons
        ]);
    }

    protected function handleCallbackQuery($callback)
    {
        $chatId = $callback['message']['chat']['id'];
        $data = $callback['data'];

        if (str_starts_with($data, 'ver_solicitud_')) {
            $id = str_replace('ver_solicitud_', '', $data);
            $factura = Factura::with('facturas_renglones.producto')->find($id);

            if (!$factura) {
                $this->telegram->sendMessage($chatId, "❌ No se encontró la solicitud #{$id}.");
                return response()->json(['status' => 'ok']);
            }

            $response = "📑 <b>Detalle de Solicitud #{$factura->id}</b>\n";
            $response .= "📅 <b>Fecha:</b> {$factura->created_at->format('d/m/Y H:i')}\n";
            $response .= "🚩 <b>Estatus:</b> {$factura->estatus}\n";
            $response .= "—————————————————\n";
            $response .= "<b>Medicamentos/Ayudas:</b>\n";

            foreach ($factura->facturas_renglones as $renglon) {
                $nombre = $renglon->producto->nombre_producto ?? 'Producto desconocido';
                $response .= "• {$nombre} (Cant: {$renglon->cantidad})\n";
            }

            if ($factura->observacion) {
                $response .= "\n📝 <b>Nota:</b> {$factura->observacion}";
            }

            $this->telegram->sendMessage($chatId, $response, [
                'inline_keyboard' => [
                    [['text' => "⬅️ Volver a buscar", 'callback_data' => "volver_inicio"]]
                ]
            ]);
        }

        if ($data == 'volver_inicio') {
            $this->telegram->sendMessage($chatId, "Por favor, ingresa tu número de <b>cédula</b> para consultar de nuevo.");
        }

        return response()->json(['status' => 'ok']);
    }
}
