{{-- resources/views/reportes/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Módulo de Reportes</h2>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ficha de Beneficiario</h5>
                            <p class="card-text">Reporte detallado de información de beneficiarios</p>
                            <a href="{{ route('reportes.ficha-beneficiario') }}" class="btn btn-primary">Generar Reporte</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Inventario</h5>
                            <p class="card-text">Reporte de productos filtrados por tipo</p>
                            <a href="{{ route('reportes.inventario') }}" class="btn btn-primary">Generar Reporte</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Solicitudes</h5>
                            <p class="card-text">Reporte de facturas/solicitudes realizadas</p>
                            <a href="{{ route('reportes.solicitudes') }}" class="btn btn-primary">Generar Reporte</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection