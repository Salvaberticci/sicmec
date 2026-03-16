{{-- resources/views/admin/reportes/solicitudes.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reporte de Solicitudes</h1>
        <a href="{{ route('reportes.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Reportes
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtros Avanzados</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('reportes.solicitudes') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label>Desde:</label>
                        <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Hasta:</label>
                        <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Médico:</label>
                        <input type="text" name="medico" class="form-control" placeholder="Nombre del médico" value="{{ request('medico') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Patología:</label>
                        <input type="text" name="patologia" class="form-control" placeholder="Tipo de patología" value="{{ request('patologia') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Estatus:</label>
                        <select name="estatus" class="form-control">
                            <option value="">Todos</option>
                            <option value="Finalizado" {{ request('estatus') == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                            <option value="Procesando" {{ request('estatus') == 'Procesando' ? 'selected' : '' }}>Procesando</option>
                            <option value="En espera" {{ request('estatus') == 'En espera' ? 'selected' : '' }}>En espera</option>
                            <option value="Cancelado" {{ request('estatus') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary d-inline-block">
                            <i class="fas fa-search fa-sm"></i> Buscar
                        </button>
                        <button type="submit" name="generar_pdf" value="1" class="btn btn-danger d-inline-block ml-2" formtarget="_blank">
                            <i class="fas fa-file-pdf fa-sm"></i> Generar PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($facturas))
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-light">
                <h6 class="m-0 font-weight-bold text-gray-800">Listado de Solicitudes ({{ count($facturas) }})</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Beneficiario</th>
                                <th>Médico</th>
                                <th>Patología</th>
                                <th>Estatus</th>
                                <th>Items</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($facturas as $f)
                                <tr>
                                    <td>#{{ $f->id }}</td>
                                    <td>{{ $f->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $f->cliente->nombre }}</td>
                                    <td>{{ $f->medico_tratante ?? '-' }}</td>
                                    <td>{{ $f->patologia ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $f->estatus == 'Finalizado' ? 'badge-success' : 'badge-warning' }}">
                                            {{ $f->estatus }}
                                        </span>
                                    </td>
                                    <td>{{ $f->total_medicamentos }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection