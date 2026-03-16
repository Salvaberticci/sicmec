{{-- resources/views/admin/reportes/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Módulo de Reportes</h1>
    </div>

    <div class="row">
        <!-- Ficha de Beneficiario -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Ficha de Beneficiario</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">Información detallada</div>
                            <a href="{{ route('reportes.ficha-beneficiario') }}" class="btn btn-primary btn-sm mt-3 w-100">Generar</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-id-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventario -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Inventario</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">Control de stock</div>
                            <a href="{{ route('reportes.inventario') }}" class="btn btn-info btn-sm mt-3 w-100">Generar</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Solicitudes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Solicitudes</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">Resumen de entregas</div>
                            <a href="{{ route('reportes.solicitudes') }}" class="btn btn-warning btn-sm mt-3 w-100">Generar</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <!-- NUEVO: Médicos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Médicos Tratantes</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">Reportes por Doctor</div>
                            <a href="{{ route('reportes.medico') }}" class="btn btn-success btn-sm mt-3 w-100">Ver Reportes</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NUEVO: Patologías -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Patologías</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">Reportes por Enfermedad</div>
                            <a href="{{ route('reportes.patologia') }}" class="btn btn-danger btn-sm mt-3 w-100">Ver Reportes</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-virus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
