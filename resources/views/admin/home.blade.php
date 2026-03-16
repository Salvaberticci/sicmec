@extends('layouts.app')

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-primary">
                <div class="inner">
                    <h3>{{\App\Models\Factura::where('estatus', 'Finalizada')->sum('total_medicamentos')}}</h3>
                    <p>Medicamentos Entregados </p>
                </div>
                <div class="icon">
                    <i class="fas fa-heart"></i>
                </div>

            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-primary">
                <div class="inner">
                    <h3>{{ (\App\Models\Producto::where('tipo', 'insumo')->sum('existencia') <= 0) ? 0 : \App\Models\Producto::where('tipo', 'insumo')->sum('existencia')}}
                    </h3>
                    <p>Cantidad de Insumos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>

            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-primary">
                <div class="inner">
                    <h3>{{\App\Models\Factura::where('estatus', 'Finalizado')->orWhere('estatus', 'Procesando')->count()}}
                    </h3>

                    <p>Beneficiarios que han recibido</p>
                </div>
                <div class="icon">
                    <i class="fas fa-diagnoses"></i>
                </div>

            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-primary">
                <div class="inner">
                    <h3>{{\App\Models\Factura::where('estatus', 'En espera')->count()}}</h3>

                    <p>Beneficiarios en Espera</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-clock"></i>
                </div>

            </div>
        </div>
        <!-- ./col -->
    </div>


    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-gradient-info text-white py-3">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-chart-bar mr-1"></i> Solicitudes Resueltas por Mes
                    </h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="monthlyChart" width="100%" height="60" data-enero="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 1)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}" data-febrero="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 2)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}" data-marzo="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 3)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}" data-abril="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 4)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}" data-mayo="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 5)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}" data-junio="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 6)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}" data-julio="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 7)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}" data-agosto="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 8)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}" data-septiembre="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 9)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}" data-octubre="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 10)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}" data-noviembre="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 11)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}" data-diciembre="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 12)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-gradient-success text-white py-3">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-chart-pie mr-1"></i> Estatus de Solicitudes</h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="statusPieChart" width="100%" height="60"
                            data-finalizado="{{\App\Models\Factura::whereIn('estatus', ['Finalizado', 'Finalizada'])->count()}}"
                            data-procesando="{{\App\Models\Factura::where('estatus', 'Procesando')->count()}}"
                            data-espera="{{\App\Models\Factura::where('estatus', 'En espera')->count()}}"
                            data-anulado="{{\App\Models\Factura::where('estatus', 'Anulado')->count()}}">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-gradient-warning text-dark py-3">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-boxes mr-1"></i> Stock por Tipo de Producto</h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="stockBarChart" width="100%" height="60"
                            data-medicamentos="{{\App\Models\Producto::where('tipo', 'medicamentos')->sum('existencia')}}"
                            data-insumos="{{\App\Models\Producto::where('tipo', 'insumo')->sum('existencia')}}"
                            data-ayudas="{{\App\Models\Producto::where('tipo', 'ayudas')->sum('existencia')}}">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-users mr-1"></i> Resumen de Beneficiarios</h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="beneficiaryDoughnutChart" width="100%" height="60"
                            data-recibido="{{\App\Models\Factura::whereIn('estatus', ['Finalizado', 'Finalizada', 'Procesando'])->distinct('cliente_id')->count()}}"
                            data-espera="{{\App\Models\Factura::where('estatus', 'En espera')->distinct('cliente_id')->count()}}">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- NEW CHARTS -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-indigo text-white py-3" style="background: #6610f2;">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-virus mr-1"></i> Top 5 Patologías Atendidas</h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="patologiaChart" width="100%" height="60" 
                            data-labels="{{ $topPatologias->pluck('patologia')->implode(',') }}"
                            data-values="{{ $topPatologias->pluck('total')->implode(',') }}">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-teal text-white py-3" style="background: #20c997;">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-user-md mr-1"></i> Top 5 Médicos Tratantes</h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="medicoChart" width="100%" height="60"
                            data-labels="{{ $topMedicos->pluck('medico_tratante')->implode(',') }}"
                            data-values="{{ $topMedicos->pluck('total')->implode(',') }}">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>


    </div>
    <!-- /.row (main row) -->

@endsection

@section('scripts')
    <script src="{{asset("plugins/chart.js/Chart.min.js")}}"></script>
    <script>
        $(function () {
            // Chart Default Styling
            Chart.defaults.global.defaultFontFamily = 'Nunito, -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            // 1. Monthly Resolved Requests (Bar Chart)
            var monthlyCtx = document.getElementById("monthlyChart");
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                    datasets: [{
                        label: "Solicitudes",
                        backgroundColor: "rgba(78, 115, 223, 1)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        data: [
                            $(monthlyCtx).data("enero"), $(monthlyCtx).data("febrero"), $(monthlyCtx).data("marzo"),
                            $(monthlyCtx).data("abril"), $(monthlyCtx).data("mayo"), $(monthlyCtx).data("junio"),
                            $(monthlyCtx).data("julio"), $(monthlyCtx).data("agosto"), $(monthlyCtx).data("septiembre"),
                            $(monthlyCtx).data("octubre"), $(monthlyCtx).data("noviembre"), $(monthlyCtx).data("diciembre")
                        ],
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{ gridLines: { display: false, drawBorder: false } }],
                        yAxes: [{ ticks: { min: 0, maxTicksLimit: 5 }, gridLines: { color: "rgb(234, 236, 244)", drawBorder: false, borderDash: [2] } }],
                    },
                    legend: { display: false }
                }
            });

            // 2. Status Distribution (Pie Chart)
            var statusCtx = document.getElementById("statusPieChart");
            new Chart(statusCtx, {
                type: 'pie',
                data: {
                    labels: ["Finalizado", "Procesando", "En espera", "Anulado"],
                    datasets: [{
                        data: [$(statusCtx).data("finalizado"), $(statusCtx).data("procesando"), $(statusCtx).data("espera"), $(statusCtx).data("anulado")],
                        backgroundColor: ['#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                        hoverBackgroundColor: ['#17a673', '#2c9faf', '#dda20a', '#be2617'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    legend: { position: 'bottom', labels: { boxWidth: 15 } },
                    tooltips: { backgroundColor: "rgb(255,255,255)", bodyFontColor: "#858796", borderColor: '#dddfeb', borderWidth: 1 }
                }
            });

            // 3. Stock by Type (Bar Chart)
            var stockCtx = document.getElementById("stockBarChart");
            new Chart(stockCtx, {
                type: 'horizontalBar',
                data: {
                    labels: ["Medicamentos", "Insumos", "Ayudas"],
                    datasets: [{
                        label: "Existencia",
                        backgroundColor: ["#4e73df", "#6610f2", "#e83e8c"],
                        data: [$(stockCtx).data("medicamentos"), $(stockCtx).data("insumos"), $(stockCtx).data("ayudas")],
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{ ticks: { min: 0 } }],
                    },
                    legend: { display: false }
                }
            });

            // 4. Beneficiaries Summary (Doughnut Chart)
            var beneCtx = document.getElementById("beneficiaryDoughnutChart");
            new Chart(beneCtx, {
                type: 'doughnut',
                data: {
                    labels: ["Atendidos", "En espera"],
                    datasets: [{
                        data: [$(beneCtx).data("recibido"), $(beneCtx).data("espera")],
                        backgroundColor: ['#4e73df', '#858796'],
                        hoverBackgroundColor: ['#2e59d9', '#6e707e'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    cutoutPercentage: 70,
                    legend: { position: 'bottom', labels: { boxWidth: 15 } },
                    tooltips: { backgroundColor: "rgb(255,255,255)", bodyFontColor: "#858796", borderColor: '#dddfeb', borderWidth: 1 }
                }
            });

            // 5. Patologia Chart
            var patoCtx = document.getElementById("patologiaChart");
            if(patoCtx) {
                var patoLabels = $(patoCtx).data("labels") ? $(patoCtx).data("labels").split(",") : [];
                var patoValues = $(patoCtx).data("values") ? $(patoCtx).data("values").toString().split(",") : [];
                new Chart(patoCtx, {
                    type: 'doughnut',
                    data: {
                        labels: patoLabels,
                        datasets: [{
                            data: patoValues,
                            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: { position: 'bottom', labels: { boxWidth: 15 } }
                    }
                });
            }

            // 6. Medico Chart
            var medCtx = document.getElementById("medicoChart");
            if(medCtx) {
                var medLabels = $(medCtx).data("labels") ? $(medCtx).data("labels").split(",") : [];
                var medValues = $(medCtx).data("values") ? $(medCtx).data("values").toString().split(",") : [];
                new Chart(medCtx, {
                    type: 'bar',
                    data: {
                        labels: medLabels,
                        datasets: [{
                            label: 'Solicitudes',
                            data: medValues,
                            backgroundColor: '#20c997',
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        scales: { yAxes: [{ ticks: { beginAtZero: true } }] },
                        legend: { display: false }
                    }
                });
            }
        });
    </script>
@endsection