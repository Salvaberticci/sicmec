<?php
// app/Http/Controllers/ReporteController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Factura;
use App\Models\FacturasRenglone;




class ReporteController extends Controller
{
    public function index()
    {
        return view('admin.reportes.index', ['title' => 'Reportes']);
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
            $pdf = \PDF::loadView('pdf.beneficiarios', compact('clientes', 'title'));
            return $pdf->stream('ficha_beneficiarios_' . date('Y-m-d') . '.pdf');
        }

        return view('admin.reportes.ficha_beneficiario', [
            'clientes' => $clientes,
            'title' => 'Ficha de Beneficiario'
        ]);
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
            $pdf = \PDF::loadView('pdf.inventario', compact('productos', 'title'));
            return $pdf->stream('inventario_' . date('Y-m-d') . '.pdf');
        }

        return view('admin.reportes.inventario', [
            'productos' => $productos,
            'title' => 'Reporte de Inventario'
        ]);
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

        if ($request->has('medico') && $request->medico != '') {
            $facturas->where('medico_tratante', 'like', '%' . $request->medico . '%');
        }

        if ($request->has('patologia') && $request->patologia != '') {
            $facturas->where('patologia', 'like', '%' . $request->patologia . '%');
        }

        $facturas = $facturas->get();
        $clientes = Cliente::all();

        if ($request->has('generar_pdf')) {
            $title = 'Reporte de Solicitudes';
            $pdf = \PDF::loadView('pdf.solicitudes_list', compact('facturas', 'title'));
            return $pdf->stream('solicitudes_' . date('Y-m-d') . '.pdf');
        }

        return view('admin.reportes.solicitudes', [
            'facturas' => $facturas,
            'clientes' => $clientes,
            'title' => 'Reporte de Solicitudes'
        ]);
    }

    public function reporteMedico(Request $request)
    {
        $medicos = Factura::select('medico_tratante')
            ->whereNotNull('medico_tratante')
            ->where('medico_tratante', '!=', '')
            ->distinct()
            ->get();

        if ($request->has('medico') && $request->medico != '') {
            $facturas = Factura::with(['cliente', 'facturas_renglones.producto'])
                ->where('medico_tratante', $request->medico)
                ->get();
            
            if ($request->has('generar_pdf')) {
                $title = 'Reporte de Solicitudes - Médico: ' . $request->medico;
                $pdf = \PDF::loadView('pdf.solicitudes_list', compact('facturas', 'title'));
                return $pdf->stream('reporte_medico_' . str_replace(' ', '_', $request->medico) . '.pdf');
            }
            return view('admin.reportes.medico', [
                'facturas' => $facturas,
                'medicos' => $medicos,
                'request' => $request,
                'title' => 'Reporte por Médico'
            ]);
        }
    
        return view('admin.reportes.medico', [
            'medicos' => $medicos,
            'title' => 'Reporte por Médico'
        ]);
    }

    public function reportePatologia(Request $request)
    {
        $patologias = Factura::select('patologia')
            ->whereNotNull('patologia')
            ->where('patologia', '!=', '')
            ->distinct()
            ->get();

        if ($request->has('patologia') && $request->patologia != '') {
            $facturas = Factura::with(['cliente', 'facturas_renglones.producto'])
                ->where('patologia', $request->patologia)
                ->get();

            if ($request->has('generar_pdf')) {
                $title = 'Reporte de Solicitudes - Patología: ' . $request->patologia;
                $pdf = \PDF::loadView('pdf.solicitudes_list', compact('facturas', 'title'));
                return $pdf->stream('reporte_patologia_' . str_replace(' ', '_', $request->patologia) . '.pdf');
            }
            return view('admin.reportes.patologia', [
                'facturas' => $facturas,
                'patologias' => $patologias,
                'request' => $request,
                'title' => 'Reporte por Patología'
            ]);
        }
    
        return view('admin.reportes.patologia', [
            'patologias' => $patologias,
            'title' => 'Reporte por Patología'
        ]);
    }
}