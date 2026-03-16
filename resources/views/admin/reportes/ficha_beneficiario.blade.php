@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ficha de Beneficiario</h1>
        <a href="{{ route('reportes.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Reportes
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('reportes.ficha-beneficiario') }}" method="GET" class="row align-items-end">
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Cédula</label>
                        <input type="text" class="form-control" name="cedula" value="{{ request('cedula') }}" placeholder="V-12345678">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Nombre</label>
                        <input type="text" class="form-control" name="nombre" value="{{ request('nombre') }}" placeholder="Nombre del beneficiario">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-search mr-1"></i> Buscar</button>
                    @if(isset($clientes) && $clientes->count() > 0)
                        <button type="submit" name="generar_pdf" value="1" class="btn btn-danger px-4 mx-2" formtarget="_blank"><i class="fas fa-file-pdf mr-1"></i> Generar PDF</button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if(isset($clientes))
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Expediente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($clientes) && count($clientes) > 0)
                            @foreach($clientes as $cliente)
                            <tr>
                                <td class="font-weight-bold text-primary">{{ $cliente->cedula }}</td>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->telefono }}</td>
                                <td>{{ $cliente->direccion }}</td>
                                <td class="text-muted">{{ $cliente->nro_expediente }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No se encontraron beneficiarios con los criterios de búsqueda.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection