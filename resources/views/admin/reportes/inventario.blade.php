{{-- resources/views/reportes/inventario.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reporte de Inventario</h1>
        <a href="{{ route('reportes.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Reportes
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('reportes.inventario') }}" method="GET" class="row align-items-end">
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Tipo de Artículo</label>
                        <select name="tipo" class="form-control">
                            <option value="">Todos los tipos</option>
                            <option value="medicamento" {{ request('tipo') == 'medicamento' ? 'selected' : '' }}>Medicamentos</option>
                            <option value="insumo" {{ request('tipo') == 'insumo' ? 'selected' : '' }}>Insumos</option>
                            <option value="ayudasTecnicas" {{ request('tipo') == 'ayudasTecnicas' ? 'selected' : '' }}>Ayudas Técnicas</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Estado de Existencia</label>
                        <select name="existencia" class="form-control">
                            <option value="">Cualquier existencia</option>
                            <option value="con_existencia" {{ request('existencia') == 'con_existencia' ? 'selected' : '' }}>Con Stock (>0)</option>
                            <option value="sin_existencia" {{ request('existencia') == 'sin_existencia' ? 'selected' : '' }}>Sin Stock (0)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-search mr-1"></i> Filtrar</button>
                    <button type="submit" name="generar_pdf" value="1" class="btn btn-danger px-4 mx-2" formtarget="_blank"><i class="fas fa-file-pdf mr-1"></i> Generar PDF</button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($productos))
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre del Producto</th>
                            <th>Tipo</th>
                            <th>Presentación</th>
                            <th>Existencia</th>
                            <th>Unidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($productos) && count($productos) > 0)
                            @foreach($productos as $producto)
                            <tr>
                                <td class="font-weight-bold">{{ $producto->nombre_producto }}</td>
                                <td><span class="badge badge-info">{{ ucfirst($producto->tipo) }}</span></td>
                                <td>{{ $producto->presentacion }}</td>
                                <td>
                                    <span class="badge {{ $producto->existencia > 0 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $producto->existencia }}
                                    </span>
                                </td>
                                <td>{{ $producto->unidad }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No se encontraron artículos con los filtros seleccionados.</td>
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