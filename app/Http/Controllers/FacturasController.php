<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\FacturasRenglone;
use App\Models\Producto;
use App\Models\TipoMedicamento;
use App\Models\TipoInsumo;
use App\Models\TipoAyuda;
use App\Models\Cliente;
use App\Models\Pago;
use Twilio\Rest\Client as TwilioClient;
use Illuminate\Http\Request;

class FacturasController extends Controller
{
    public function index()
    {
        $data['solicitudes'] = Factura::with('cliente')->orderBy('id', 'desc')->get();
        $data['productos'] = Producto::with('tipo_ayudas', 'tipo_medicamentos', 'tipo_insumo')->orderBy('nombre_producto', 'asc')->get();
        $data['tipo_medicamentos'] = TipoMedicamento::orderBy('descripcion', 'asc')->get();
        $data['tipo_ayuda'] = TipoAyuda::orderBy('descripcion', 'asc')->get();
        $data['tipo_insumos'] = TipoInsumo::orderBy('descripcion', 'asc')->get();
        return response()->json([
            "status" => "ok",
            "data" => $data
        ], 200);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource.
     * Triggers: SMS (new request) + Email with PDF
     */
    public function store(Request $request)
    {
        $products = json_decode($request->products, true);
        $c = Cliente::where('cedula', $request->cedula)->first();

        if ($c == "") {
            $c = Cliente::create([
                'cedula' => $request->cedula,
                'nombre' => strtoupper($request->nombre),
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'direccion' => strtoupper($request->direccion),
                'nro_expediente' => $request->nro_expediente,
                'ubch_centro_electoral' => strtoupper($request->ubch_centro_electoral)
            ])->latest('id')->first();
        } else {
            $c->fill([
                'cedula' => $request->cedula,
                'nombre' => strtoupper($request->nombre),
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'direccion' => strtoupper($request->direccion),
                'nro_expediente' => $request->nro_expediente,
                'ubch_centro_electoral' => strtoupper($request->ubch_centro_electoral)
            ])->save();
        }

        $total_medicamentos = 0;
        foreach ($products as $key) {
            $total_medicamentos = $total_medicamentos + $key['cantidad'];
        }

        $path = null;
        if ($request->hasFile('archivo_planilla')) {
            $file = $request->file('archivo_planilla');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(base_path('public/storage/planillas'), $filename);
            $path = 'storage/planillas/' . $filename;
        }

        $f = Factura::create([
            'cliente_id' => $c->id,
            'total_medicamentos' => $total_medicamentos,
            'estatus' => $request->estatus,
            'observacion' => $request->observacion,
            'atendido_por' => strtoupper($request->atendido_por),
            'archivo_planilla' => $path,
            'medico_tratante' => strtoupper($request->medico_tratante),
            'patologia' => strtoupper($request->patologia)
        ])->latest('id')->first();

        foreach ($products as $key) {
            if (strpos($key['id'], 'P') !== false) {
                $p = Producto::create([
                    'nombre_producto' => strtoupper($key['descripcion']),
                    'tipo' => $key['tipo'],
                    'presentacion' => $key['presentacion'],
                    'unidad' => $key['unidad']
                ])->latest('id')->first();
                FacturasRenglone::create([
                    'factura_id' => $f->id,
                    'producto_id' => $p->id,
                    'cantidad' => $key['cantidad'],
                ]);
            } else {
                FacturasRenglone::create([
                    'factura_id' => $f->id,
                    'producto_id' => $key['id'],
                    'cantidad' => $key['cantidad'],
                ]);
            }
        }

        if ($request->estatus != "En espera") {
            foreach ($products as $key) {
                $existe = Producto::find($key['id'])->existencia;
                Producto::find($key['id'])->fill([
                    'existencia' => ($existe - $key['cantidad']),
                ])->save();
            }
        }

        // -------------------------------------------------------
        // SMS: Recién hecha la solicitud
        // -------------------------------------------------------
        try {
            $config = \App\Models\Configuracion::first();
            $sid = $config->twilio_sid ?? env('TWILIO_SID');
            $token = $config->twilio_token ?? env('TWILIO_TOKEN');
            $from = $config->twilio_from ?? env('TWILIO_FROM');
            $to = $config->twilio_to_default ?: $c->telefono;

            $twilio = new TwilioClient($sid, $token);
            $msg = "Hola {$c->nombre}, recibimos tu solicitud #{$f->id}. Médico: {$f->medico_tratante}. Patología: {$f->patologia}. Estatus: {$f->estatus}. Hemos enviado la planilla al correo.";
            $twilio->messages->create($to, [
                "from" => $from,
                "body" => $msg . " Consulta: https://t.me/sicmec_ayuda_bot"
            ]);
        } catch (\Exception $e) {
            \Log::error("Twilio SMS Error (store): " . $e->getMessage());
        }

        // -------------------------------------------------------
        // EMAIL: Planilla PDF al correo del beneficiario
        // -------------------------------------------------------
        try {
            if ($c->correo) {
                $factura = Factura::with('cliente', 'facturas_renglones.producto')->find($f->id);
                \Mail::to($c->correo)->send(new \App\Mail\SolicitudCreada($factura));
            }
        } catch (\Exception $e) {
            \Log::error("Mail Error (store): " . $e->getMessage());
        }

        return 200;
    }

    public function show($id)
    {
        $c = Factura::with(
            'cliente',
            'facturas_renglones.producto',
            'facturas_renglones',
            'facturas_renglones.producto.tipo_ayudas',
            'facturas_renglones.producto.tipo_medicamentos',
            'facturas_renglones.producto.tipo_insumo'
        )->find($id);
        return response()->json(['data' => $c], 200);
    }

    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource.
     * Triggers: SMS when status changes to "Aprobada"
     */
    public function update(Request $request, $id)
    {
        $products = json_decode($request->products, true);
        $c = Cliente::where('cedula', $request->cedula)->first();

        if ($c == "") {
            $c = Cliente::create([
                'cedula' => $request->cedula,
                'nombre' => strtoupper($request->nombre),
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'direccion' => strtoupper($request->direccion),
                'nro_expediente' => $request->nro_expediente,
                'ubch_centro_electoral' => strtoupper($request->ubch_centro_electoral)
            ])->latest('id')->first();
        } else {
            $c->fill([
                'cedula' => $request->cedula,
                'nombre' => strtoupper($request->nombre),
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'direccion' => strtoupper($request->direccion),
                'nro_expediente' => $request->nro_expediente,
                'ubch_centro_electoral' => strtoupper($request->ubch_centro_electoral)
            ])->save();
        }

        $total_medicamentos = 0;
        foreach ($products as $key) {
            $total_medicamentos = $total_medicamentos + $key['cantidad'];
        }

        $f = Factura::find($id);

        $path = $f->archivo_planilla;
        if ($request->hasFile('archivo_planilla')) {
            // Delete old file if exists
            if ($path && file_exists(base_path('public/' . $path))) {
                unlink(base_path('public/' . $path));
            }
            $file = $request->file('archivo_planilla');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(base_path('public/storage/planillas'), $filename);
            $path = 'storage/planillas/' . $filename;
        }

        $f->fill([
            'cliente_id' => $c->id,
            'total_medicamentos' => $total_medicamentos,
            'estatus' => $request->estatus,
            'observacion' => $request->observacion,
            'atendido_por' => $request->atendido_por,
            'archivo_planilla' => $path,
            'medico_tratante' => strtoupper($request->medico_tratante),
            'patologia' => strtoupper($request->patologia)
        ])->save();

        FacturasRenglone::where('factura_id', $id)->delete();
        foreach ($products as $key) {
            if (strpos($key['id'], 'P') !== false) {
                $p = Producto::create([
                    'nombre_producto' => strtoupper($key['descripcion']),
                    'tipo' => $key['tipo'],
                    'presentacion' => $key['presentacion'],
                    'unidad' => $key['unidad']
                ])->latest('id')->first();
                FacturasRenglone::create([
                    'factura_id' => $f->id,
                    'producto_id' => $p->id,
                    'cantidad' => $key['cantidad'],
                ]);
            } else {
                FacturasRenglone::create([
                    'factura_id' => $f->id,
                    'producto_id' => $key['id'],
                    'cantidad' => $key['cantidad'],
                ]);
            }
        }

        if ($request->estatus != "En espera") {
            foreach ($products as $key) {
                $existe = Producto::find($key['id'])->existencia;
                Producto::find($key['id'])->fill([
                    'existencia' => ($existe - $key['cantidad']),
                ])->save();
            }
        }

        // -------------------------------------------------------
        // SMS: Notificación de cambio de Estatus
        // -------------------------------------------------------
        try {
            $config = \App\Models\Configuracion::first();
            $sid = $config->twilio_sid ?? env('TWILIO_SID');
            $token = $config->twilio_token ?? env('TWILIO_TOKEN');
            $from = $config->twilio_from ?? env('TWILIO_FROM');
            $to = $config->twilio_to_default ?: $c->telefono;

            $statusMsg = "Hola {$c->nombre}, tu solicitud #{$f->id} ha cambiado a estatus: " . strtoupper($f->estatus) . ".";

            if ($f->estatus == "Aprobada") {
                $statusMsg = "¡Buenas noticias {$c->nombre}! Tu solicitud #{$f->id} (Medico: {$f->medico_tratante}) ha sido APROBADA. Puedes retirar tu medicamento.";
            } elseif ($f->estatus == "Finalizado") {
                $statusMsg = "Hola {$c->nombre}, tu solicitud #{$f->id} (Medico: {$f->medico_tratante}) ha sido FINALIZADA. Gracias por confiar en nosotros.";
            }

            $twilio = new TwilioClient($sid, $token);
            $twilio->messages->create($to, [
                "from" => $from,
                "body" => $statusMsg . " Consulta detalles en: https://t.me/sicmec_ayuda_bot"
            ]);
        } catch (\Exception $e) {
            \Log::error("Twilio SMS Error (update): " . $e->getMessage());
        }

        // -------------------------------------------------------
        // EMAIL: Notificación de cambio de Estatus
        // -------------------------------------------------------
        try {
            if ($c->correo) {
                $factura = Factura::with('cliente', 'facturas_renglones.producto')->find($f->id);
                \Mail::to($c->correo)->send(new \App\Mail\SolicitudCreada($factura));
            }
        } catch (\Exception $e) {
            \Log::error("Mail Error (update): " . $e->getMessage());
        }

        return 200;
    }

    public function destroy($id)
    {
        Factura::find($id)->delete();
        return 200;
    }
}
