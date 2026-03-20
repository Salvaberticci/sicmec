{{-- resources/views/admin/reportes/ficha_beneficiario.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Reporte de Ficha de Beneficiario</h2>
    
    <div class="card mt-4">
        <div class="card-header">
            <h5>Filtros de Búsqueda</h5>
        </div>
        <div class="card-body">
            <form action="{{ url('/public/reportes/ficha-beneficiario') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cedula">Cédula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" 
                                   value="{{ request('cedula') }}" placeholder="Buscar por cédula">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                   value="{{ request('nombre') }}" placeholder="Buscar por nombre">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">Buscar</button>
                                <a href="{{ url('/public/reportes') }}" class="btn btn-secondary">Volver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($clientes) && $clientes->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h5>Resultados ({{ $clientes->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Saldo</th>
                            <th>Expediente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->cedula }}</td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ $cliente->direccion }}</td>
                            <td>{{ number_format($cliente->saldo, 2) }}</td>
                            <td>{{ $cliente->nro_expediente }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @elseif(request()->has('cedula') || request()->has('nombre'))
    <div class="alert alert-info mt-4">
        No se encontraron beneficiarios con los filtros especificados.
    </div>
    @endif
</div>
@endsection