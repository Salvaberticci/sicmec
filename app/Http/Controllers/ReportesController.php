<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\FacturasRenglone;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;
use \PDF;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller {


    public function filtrarInformacion(Request $request)
    {
        // Obtain the start and end dates from the request
        $fecha_inicio = Carbon::parse($request->start_date)->format('M');
        $fecha_fin = Carbon::parse($request->end_date)->format('M');
        
        // Validate the input dates
        if (!$fecha_inicio || !$fecha_fin) {
            return redirect()->back()->withErrors('Debes seleccionar ambas fechas');
        }
    
        // Validate the date format
        if (!strtotime($fecha_inicio) || !strtotime($fecha_fin)) {
            return redirect()->back()->withErrors('Formato de fecha inválido');
        }
    
        // Ensure the start date is before the end date
        if (strtotime($fecha_inicio) > strtotime($fecha_fin)) {
            return redirect()->back()->withErrors('La fecha de inicio debe ser anterior a la fecha de fin');
        }
        // Filter by date range using Eloquent whereBetween method
        // $informacion_filtrada = Factura::whereBetween('created_at', [$request->start_date, $request->end_date])->orderBy('created_at', 'ASC')->get();
        $fecha1 = Carbon::createFromDate($request->start_date)->startOfMonth();
        $fecha2 = Carbon::createFromDate($request->end_date)->startOfMonth();

        $cantidad_meses = $fecha1->diffInMonths($fecha2) + 1;

        $meses = DB::table('facturas')->select('created_at')->where(DB::raw("DATE(created_at)"), ">=", $request->start_date, "AND", "created_at", "<=", $request->end_date)->groupBy(DB::raw('MONTH(created_at)'))->get();
        $informacion_filtrada = Factura::where("created_at", ">=", $request->start_date, "AND", "created_at", "<=", $request->end_date)->orderBy('created_at', 'ASC')->get();
        
        /// Generar pdf utilizando DOMPDF
        $pdf = PDF::loadView('generar_pdf', ['informacion_filtrada' => $informacion_filtrada , 'fecha_inicio' =>$fecha_inicio, 'fecha_fin' => $fecha_fin, 'meses' => $meses, 'cantidad_meses' => $cantidad_meses]);
        $pdf->setPaper('A4', 'landscape');
        // return view('generar_pdf', ['informacion_filtrada' => $informacion_filtrada , 'fecha_inicio' =>$fecha_inicio, 'fecha_fin' => $fecha_fin, 'meses' => $meses, 'cantidad_meses' => $cantidad_meses]);
        // // Return el PDF para download
        return $pdf->stream('reporte_generado.pdf', ["Attachment" => false]);
    }
}