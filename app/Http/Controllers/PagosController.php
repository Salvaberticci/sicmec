<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\MetodosPago;
use App\Models\Factura;
use App\Models\Cliente;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $title="Pagos";
        $data['pagos'] = Pago::orderBy('created_at', 'desc')->get();
        $data['metodos-pago'] = MetodosPago::orderBy('descripcion', 'asc')->get();
        $data['facturas-pendientes'] = Factura::where('estatus', 'pendiente')->get();
        return view('admin.pays.index', ['data' => $data, 'title' => $title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $f = Factura::find($request->factura_id);
        $cal = $f->total_factura - $request->monto;
        if($cal < 0){
            $c = Cliente::find($f->cliente_id);
            $cu = Cliente::find($c->id)->fill(['saldo' => ($c->saldo + ($request->monto - $f->total_factura))])->save();
            $f->fill(['estatus' => "Finalizada"])->save();
        }

        if($cal == 0){
            $f->fill(['estatus' => "Finalizada"])->save();
        }

        
        $p = Pago::create($request->all());
        return 200;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $c = Pago::find($id);
        return json_encode($c);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $c = Pago::find($id)->fill($request->all())->save();
        return 200;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c = Pago::find($id)->delete();
        return 200;
    }

    public function clientByIdNumber($ci)
    {
        $c = Pago::where('cedula', $ci)->first();
        return json_encode($c);
    }
}
