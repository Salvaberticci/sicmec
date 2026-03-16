{{-- resources/views/admin/reportes/patologia.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reporte por Patología</h1>
        <a href="{{ route('reportes.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Reportes
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtro de Patología</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('reportes.patologia') }}" method="GET" class="form-inline">
                <div class="form-group mb-2 mr-3">
                    <label for="patologia" class="mr-2">Seleccione Patología:</label>
                    <select name="patologia" id="patologia" class="form-control" required style="min-width: 300px;">
                        <option value="">-- Seleccione una patología --</option>
                        @foreach($patologias as $p)
                            <option value="{{ $p->patologia }}" {{ request('patologia') == $p->patologia ? 'selected' : '' }}>
                                {{ $p->patologia }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-2 mr-2">
                    <i class="fas fa-search fa-sm"></i> Buscar
                </button>
                @if(request('patologia'))
                    <button type="submit" name="generar_pdf" value="1" class="btn btn-danger mb-2" formtarget="_blank">
                        <i class="fas fa-file-pdf fa-sm"></i> Descargar PDF
                    </button>
                @endif
            </form>
        </div>
    </div>

    @if(isset($facturas))
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-light">
                <h6 class="m-0 font-weight-bold text-gray-800">Resultados para: {{ request('patologia') }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Beneficiario</th>
                                <th>Cédula</th>
                                <th>Médico Tratante</th>
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
                                    <td>{{ $f->cliente->cedula }}</td>
                                    <td>{{ $f->medico_tratante ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $f->estatus == 'Finalizado' ? 'badge-success' : 'badge-warning' }}">
                                            {{ $f->estatus }}
                                        </span>
                                    </td>
                                    <td>{{ $f->total_medicamentos }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-right">Total Solicitudes:</th>
                                <th>{{ count($facturas) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
