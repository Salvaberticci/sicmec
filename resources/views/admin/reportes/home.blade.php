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
            {{-- Agregar esta tarjeta junto a las existentes --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Reportes</h5>
                        <h2 class="text-primary"><i class="fas fa-chart-bar"></i></h2>
                        <p class="card-text">Generar reportes del sistema</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#reportesModal">
                            Abrir Reportes
                        </button>
                    </div>
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
            <div class="card h-100">
                <div class="card-header bg-gradient-info text-white">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i> Solicitudes Resueltas por Mes</h3>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="monthlyChart" width="100%" height="60"
                            data-enero="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 1)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}"
                            data-febrero="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 2)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}"
                            data-marzo="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 3)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}"
                            data-abril="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 4)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}"
                            data-mayo="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 5)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}"
                            data-junio="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 6)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}"
                            data-julio="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 7)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}"
                            data-agosto="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 8)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}"
                            data-septiembre="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 9)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}"
                            data-octubre="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 10)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}"
                            data-noviembre="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 11)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}"
                            data-diciembre="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 12)->where(function ($q) {
        $q->where('estatus', 'Finalizado')->orWhere('estatus', 'Finalizada'); })->count()}}">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-gradient-success text-white">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i> Estatus de Solicitudes</h3>
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
            <div class="card h-100">
                <div class="card-header bg-gradient-warning text-dark">
                    <h3 class="card-title"><i class="fas fa-boxes mr-1"></i> Stock por Tipo de Producto</h3>
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
            <div class="card h-100">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title"><i class="fas fa-users mr-1"></i> Resumen de Beneficiarios</h3>
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
    </div>
    </section>

    <!-- Modal de Reportes -->
    <div class="modal fade" id="reportesModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generar Reportes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Ficha de Beneficiario</h5>
                                    <p class="card-text">Reporte detallado de beneficiarios</p>
                                    <form action="../public/reportes/ficha-beneficiario" method="GET" target="_blank">
                                        <div class="mb-3">
                                            <input type="text" name="cedula" class="form-control"
                                                placeholder="Cédula (opcional)">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" name="nombre" class="form-control"
                                                placeholder="Nombre (opcional)">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Generar PDF</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Inventario</h5>
                                    <p class="card-text">Reporte de productos en stock</p>
                                    <form action="../public/reportes/inventario" method="GET" target="_blank">
                                        <div class="mb-3">
                                            <select name="tipo" class="form-control">
                                                <option value="">Todos los tipos</option>
                                                <option value="medicamentos">Medicamentos</option>
                                                <option value="insumos">Insumos</option>
                                                <option value="ayudas">Ayudas</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Generar PDF</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /.row (main row) -->

@endsection

@section('scripts')
    <script src="{{asset("plugins/chart.js/Chart.min.js")}}"></script>
    <script>
      $(function() {
          // Chart Default Styling
          Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
          Chart.defaults.global.defaultFontColor = '#292b2c';

          // 1. Monthly Resolved Requests (Bar Chart)
          var monthlyCtx = document.getElementById("monthlyChart");
          new Chart(monthlyCtx, {
              type: 'bar',
              data: {
                  labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                  datasets: [{
                      label: "Solicitudes",
                      backgroundColor: "rgba(2,117,216,1)",
                      borderColor: "rgba(2,117,216,1)",
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
                      xAxes: [{ gridLines: { display: false } }],
                      yAxes: [{ ticks: { min: 0 } }],
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
                      backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#dc3545'],
                  }],
              },
              options: {
                  maintainAspectRatio: false,
                  legend: { position: 'bottom' }
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
                      backgroundColor: ["#007bff", "#6f42c1", "#e83e8c"],
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
                      backgroundColor: ['#007bff', '#6c757d'],
                  }],
              },
              options: {
                  maintainAspectRatio: false,
                  legend: { position: 'bottom' }
              }
          });
      });
    </script>
@endsection