<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $config = Configuracion::first();
        return view('admin.config.index', [
            'config' => $config,
            'title' => 'Configuración de Notificaciones'
        ]);
    }

    public function update(Request $request)
    {
        $config = Configuracion::first();
        if (!$config) {
            $config = new Configuracion();
        }

        $config->fill($request->all());
        $config->save();

        return redirect()->back()->with('success', 'Configuración actualizada correctamente');
    }
}
