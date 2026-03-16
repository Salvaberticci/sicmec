<?php

namespace App\Http\Controllers;

use App\Models\Trabajadore;
use App\Models\Turno;
use Illuminate\Http\Request;

class TrabajadoresController extends Controller
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
        $title="Trabajadores";
        $data['trabajadores'] = Trabajadore::orderBy('cedula', 'asc')->get();
        $data['turnos'] = Turno::orderBy('descripcion', 'asc')->get();
        return view('admin.workers.index', ['data' => $data, 'title' => $title]);
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
        $c = Trabajadore::create($request->all());
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
        $c = Trabajadore::find($id);
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
        $c = Trabajadore::find($id)->fill($request->all())->save();
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
        $c = Trabajadore::find($id)->delete();
        return 200;
    }

    public function clientByIdNumber($ci)
    {
        $c = Trabajadore::where('cedula', $ci)->first();
        return json_encode($c);
    }
}
