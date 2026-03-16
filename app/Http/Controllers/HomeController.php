<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Factura;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {  
        $title = "Escritorio";
        
        $topPatologias = Factura::select('patologia', \DB::raw('count(*) as total'))
            ->whereNotNull('patologia')
            ->where('patologia', '!=', '')
            ->groupBy('patologia')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $topMedicos = Factura::select('medico_tratante', \DB::raw('count(*) as total'))
            ->whereNotNull('medico_tratante')
            ->where('medico_tratante', '!=', '')
            ->groupBy('medico_tratante')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('admin.home', compact('title', 'topPatologias', 'topMedicos'));
    }
    public function reporteFichaBeneficiario(Request $request)
    {
        $clientes = Cliente::query();
        
        if ($request->has('cedula') && $request->cedula != '') {
            $clientes->where('cedula', 'like', '%' . $request->cedula . '%');
        }
        
        if ($request->has('nombre') && $request->nombre != '') {
            $clientes->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        $clientes = $clientes->get();

        return view('admin.reportes.ficha_beneficiario', [
            'clientes' => $clientes,
            'title' => 'Ficha de Beneficiario'
        ]);
    }
    
    // En HomeController.php - agregar estos dos métodos
public function generarPdfFicha(Request $request)
{
    $clientes = \App\Models\Cliente::query();
    
    if ($request->has('cedula') && $request->cedula != '') {
        $clientes->where('cedula', 'like', '%' . $request->cedula . '%');
    }
    
    if ($request->has('nombre') && $request->nombre != '') {
        $clientes->where('nombre', 'like', '%' . $request->nombre . '%');
    }

    $clientes = $clientes->get();
    
    // PDF simple - sin vistas complicadas
    $pdf = \PDF::loadView('pdf.simple_ficha', compact('clientes'));
    return $pdf->download('ficha_beneficiarios.pdf');
}

public function generarPdfInventario(Request $request)
{
    $productos = \App\Models\Producto::query();
    
    if ($request->has('tipo') && $request->tipo != '') {
        $productos->where('tipo', $request->tipo);
    }

    $productos = $productos->get();
    
    $pdf = \PDF::loadView('pdf.simple_inventario', compact('productos'));
    return $pdf->download('inventario.pdf');
}
}

