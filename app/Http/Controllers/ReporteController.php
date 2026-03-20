<?php
// app/Http/Controllers/ReporteController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Factura;
use App\Models\FacturaRenglone;
use PDF;




class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index', ['title' => 'Reportes']);
    }

    public function fichaBeneficiario(Request $request)
    {
        $clientes = Cliente::query();

        if ($request->has('cedula') && $request->cedula != '') {
            $clientes->where('cedula', 'like', '%' . $request->cedula . '%');
        }

        if ($request->has('nombre') && $request->nombre != '') {
            $clientes->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        $clientes = $clientes->get();

        if ($request->has('generar_pdf')) {
            $title = 'Reporte de Beneficiarios';
            $pdf = PDF::loadView('pdf.beneficiarios', compact('clientes', 'title'));
            return $pdf->stream('ficha_beneficiarios_' . date('Y-m-d') . '.pdf');
        }

        return view('reportes.ficha_beneficiario', compact('clientes'));
    }

    public function inventario(Request $request)
    {
        $productos = Producto::query();

        if ($request->has('tipo') && $request->tipo != '') {
            $productos->where('tipo', $request->tipo);
        }

        if ($request->has('existencia') && $request->existencia != '') {
            if ($request->existencia == 'con_existencia') {
                $productos->where('existencia', '>', 0);
            } elseif ($request->existencia == 'sin_existencia') {
                $productos->where('existencia', '<=', 0);
            }
        }

        $productos = $productos->get();

        if ($request->has('generar_pdf')) {
            $title = 'Reporte de Inventario';
            $pdf = PDF::loadView('pdf.inventario', compact('productos', 'title'));
            return $pdf->stream('inventario_' . date('Y-m-d') . '.pdf');
        }

        return view('reportes.inventario', compact('productos'));
    }

    public function solicitudes(Request $request)
    {
        $facturas = Factura::with(['cliente', 'facturas_renglones.producto']);

        if ($request->has('fecha_desde') && $request->fecha_desde != '') {
            $facturas->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->has('fecha_hasta') && $request->fecha_hasta != '') {
            $facturas->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        if ($request->has('estatus') && $request->estatus != '') {
            $facturas->where('estatus', $request->estatus);
        }

        if ($request->has('cliente_id') && $request->cliente_id != '') {
            $facturas->where('cliente_id', $request->cliente_id);
        }

        $facturas = $facturas->get();
        $clientes = Cliente::all();

        if ($request->has('generar_pdf')) {
            $title = 'Reporte de Solicitudes';
            $pdf = PDF::loadView('pdf.solicitudes_list', compact('facturas', 'title'));
            return $pdf->stream('solicitudes_' . date('Y-m-d') . '.pdf');
        }

        return view('reportes.solicitudes', compact('facturas', 'clientes'));
    }
}