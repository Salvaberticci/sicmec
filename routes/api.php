<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\TrabajadoresController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\UsuariosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ClientesController::class)->group(function(){
    Route::get('/clientes', 'index');
    Route::post('/clientes/store', 'store');
    Route::get('/cliente/{id}', 'show');
    Route::put('/cliente/update/{id}', 'update');
    Route::get('/cliente/destroy/{id}', 'destroy');
    Route::get('/cliente/cedula/{cedula}', 'clientByIdNumber');
    Route::post('/cliente/mensaje', 'send');
});

Route::controller(ProductosController::class)->group(function(){
    Route::get('/productos', 'index');
    Route::post('/productos/store', 'store');
    Route::get('/producto/{id}', 'show');
    Route::put('/producto/update/{id}', 'update');
    Route::get('/producto/destroy/{id}', 'destroy');
    Route::get('/productos/filtrar/{tipo}', 'filter');
});

Route::controller(FacturasController::class)->group(function(){
    Route::get('/facturas', 'index');
    Route::post('/facturas/store', 'store');
    Route::get('/facturas/{id}', 'show');
    Route::put('/facturas/update/{id}', 'update');
    Route::get('/facturas/destroy/{id}', 'destroy');
});

Route::controller(TrabajadoresController::class)->group(function(){
    Route::get('/trabajadores', 'index');
    Route::post('/trabajadores/store', 'store');
    Route::get('/trabajador/{id}', 'show');
    Route::put('/trabajador/update/{id}', 'update');
    Route::get('/trabajador/destroy/{id}', 'destroy');
    Route::get('/trabajador/cedula/{cedula}', 'clientByIdNumber');
});

Route::controller(PagosController::class)->group(function(){
    Route::get('/cobros', 'index');
    Route::post('/cobros/store', 'store');
    Route::get('/cobro/{id}', 'show');
    Route::put('/cobro/update/{id}', 'update');
    Route::get('/cobro/destroy/{id}', 'destroy');
    Route::get('/cobro/cedula/{cedula}', 'clientByIdNumber');
});

Route::controller(NominaController::class)->group(function(){
    Route::get('/nominas', 'index');
    Route::post('/nominas/store', 'store');
    Route::get('/nomina/{id}', 'show');
    Route::put('/nomina/update/{id}', 'update');
    Route::get('/nomina/destroy/{id}', 'destroy');
    Route::get('/nomina/cedula/{cedula}', 'clientByIdNumber');
});

Route::controller(UsuariosController::class)->group(function(){
    Route::get('/usuarios', 'index');
    Route::post('/usuarios/store', 'store');
    Route::get('/usuario/{id}', 'show');
    Route::put('/usuario/update/{id}', 'update');
    Route::get('/usuario/destroy/{id}', 'destroy');
});