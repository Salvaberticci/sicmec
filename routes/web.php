<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporteController; // NUEVO controlador para nuestro módulo
use App\Http\Controllers\ReportesController; // Controlador EXISTENTE del sistema

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('public/login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::view('/solicitudes', 'admin.bills.index', ['title' => "Solicitudes"])->name('bills.index');
    Route::view('/inventario', 'admin.products.index', ['title' => "Inventario"])->name('products.index');
    Route::view('/beneficiarios', 'admin.clients.index', ['title' => "Beneficiarios"])->name('clients.index');
    Route::view('/usuarios', 'admin.users.index', ['title' => "Usuarios"])->name('users.index');

    // RUTA DE CONFIGURACIÓN
    Route::get('/configuracion', [App\Http\Controllers\ConfiguracionController::class, 'index'])->name('config.index');
    Route::post('/configuracion', [App\Http\Controllers\ConfiguracionController::class, 'update'])->name('config.update');

    // RUTAS DEL CONTROLADOR EXISTENTE ReportesController (reportes del sistema)
    Route::controller(ReportesController::class)->group(function () {
        Route::post('/reportes/filtro', 'filtrarInformacion');
        // Otras rutas existentes del ReportesController...
    });

    // RUTAS DEL NUEVO CONTROLADOR ReporteController (nuestro módulo de reportes)
    Route::prefix('reportes')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/ficha-beneficiario', [ReporteController::class, 'fichaBeneficiario'])->name('reportes.ficha-beneficiario');
        Route::get('/inventario', [ReporteController::class, 'inventario'])->name('reportes.inventario');
        Route::get('/solicitudes', [ReporteController::class, 'solicitudes'])->name('reportes.solicitudes');
        Route::get('/medico', [ReporteController::class, 'reporteMedico'])->name('reportes.medico');
        Route::get('/patologia', [ReporteController::class, 'reportePatologia'])->name('reportes.patologia');
        // Dentro del grupo auth - SOLO ESTAS 2 RUTAS
        Route::get('/reportes/ficha-beneficiario', [App\Http\Controllers\HomeController::class, 'generarPdfFicha']);
        Route::get('/reportes/inventario', [App\Http\Controllers\HomeController::class, 'generarPdfInventario']);
    });
});

// Ruta de prueba para notificaciones
Route::get('/test-notificaciones', function () {
    $c = App\Models\Cliente::first() ?: App\Models\Cliente::create([
        'cedula' => '99999999',
        'nombre' => 'USUARIO PRUEBA',
        'telefono' => '+584121731842',
        'correo' => 'salvatoreberticci19@gmail.com',
        'direccion' => 'CALLE PRUEBA'
    ]);

    $f = App\Models\Factura::first() ?: App\Models\Factura::create([
        'cliente_id' => $c->id,
        'total_medicamentos' => 5,
        'estatus' => 'Procesando'
    ]);

    // Forzar carga de relaciones
    $factura = App\Models\Factura::with('cliente', 'facturas_renglones.producto')->find($f->id);

    // 1. Probar Email
    try {
        Mail::to('salvatoreberticci19@gmail.com')->send(new App\Mail\SolicitudCreada($factura));
        $emailStatus = "Enviado correctamente";
    } catch (\Exception $e) {
        $emailStatus = "Error: " . $e->getMessage();
    }

    // 2. Probar SMS
    try {
        $config = App\Models\Configuracion::first();
        $sid = $config->twilio_sid;
        $token = $config->twilio_token;
        $from = $config->twilio_from;
        $to = '+584121731842';

        $twilio = new \Twilio\Rest\Client($sid, $token);
        $twilio->messages->create($to, [
            'from' => $from,
            'body' => "PRUEBA SICMEC: Hola {$c->nombre}, tu solicitud #{$f->id} está en estatus PROCESANDO. Consulta detalles en: https://t.me/sicmec_ayuda_bot"
        ]);
        $smsStatus = "Enviado correctamente";
    } catch (\Exception $e) {
        $smsStatus = "Error: " . $e->getMessage();
    }

    return response()->json([
        'email_to' => 'salvatoreberticci19@gmail.com',
        'email_result' => $emailStatus,
        'sms_to' => '+584121731842',
        'sms_result' => $smsStatus
    ]);
});

// Telegram Bot Routes
Route::post('/telegram/webhook', [App\Http\Controllers\TelegramController::class, 'webhook']);

Route::get('/telegram/set-webhook', function () {
    $service = new \App\Services\TelegramService();
    $url = url('/telegram/webhook');
    if (strpos($url, 'localhost') === false && strpos($url, 'https') === false) {
        $url = str_replace('http://', 'https://', $url);
    }
    $result = $service->setWebhook($url);
    return response()->json([
        'status' => 'webhook_request_sent',
        'url' => $url,
        'telegram_response' => $result
    ]);
})->middleware('auth');
