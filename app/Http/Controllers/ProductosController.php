<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\TipoInsumo;
use App\Models\TipoMedicamento;
use Illuminate\Http\Request;
use App\Models\TipoAyuda;

class ProductosController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $data['productos'] = Producto::with('tipo_ayudas', 'tipo_medicamentos', 'tipo_insumo')->orderBy('nombre_producto', 'asc')->get();
        $data['tipo_medicamentos'] = TipoMedicamento::orderBy('descripcion', 'asc')->get();
        $data['tipo_ayuda'] = TipoAyuda::orderBy('descripcion', 'asc')->get();
        $data['tipo_insumos'] = TipoInsumo::orderBy('descripcion', 'asc')->get();
        return response()->json([
            'status'=> 'ok',
            'data' => $data
        ], 200);
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
        $c = Producto::create($request->all());
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
        $c = Producto::find($id);
        return response()->json([
            'status'=>'ok',
            'data'=>$c
        ],200);
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
        $c = Producto::find($id)->fill($request->all())->save();
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
        $c = Producto::find($id)->delete();
        return 200;
    }

    public function filter(Request $request){
        if($request->tipo != 'todos'){
            $p = Producto::with('tipo_ayudas', 'tipo_medicamentos', 'tipo_insumo')->where('tipo', $request->tipo)->get();
        }else{
            $p = Producto::with('tipo_ayudas', 'tipo_medicamentos', 'tipo_insumo')->get();
        }

        return response()->json([
            'data' => $p
        ], 200);
    }
}
