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
                <h3>{{ (\App\Models\Producto::where('tipo', 'insumo')->sum('existencia') <= 0) ? 0 : \App\Models\Producto::where('tipo', 'insumo')->sum('existencia')}}</h3>
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
                <h3>{{\App\Models\Factura::where('estatus', 'Finalizado')->orWhere('estatus', 'Procesando')->count()}}</h3>

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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportesModal">
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
          <div class="col-md-10 mx-auto">
              <div class="card shadow-sm border-0 mb-4">
                  <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Estadística de Solicitudes Finalizadas</h6>
                  </div>
                  <div class="card-body p-4">
                      <div class="chart-area">
                          <canvas id="myAreaChart" width="100%" height="40" 
                                  data-enero="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 1)->where('estatus', 'Finalizado')->count()}}"
                                  data-febrero="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 2)->where('estatus', 'Finalizado')->count()}}"
                                  data-marzo="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 3)->where('estatus', 'Finalizado')->count()}}"
                                  data-abril="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 4)->where('estatus', 'Finalizado')->count()}}"
                                  data-mayo="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 5)->where('estatus', 'Finalizado')->count()}}"
                                  data-junio="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 6)->where('estatus', 'Finalizado')->count()}}"
                                  data-julio="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 7)->where('estatus', 'Finalizado')->count()}}"
                                  data-agosto="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 8)->where('estatus', 'Finalizado')->count()}}"
                                  data-septiembre="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 9)->where('estatus', 'Finalizado')->count()}}"
                                  data-octubre="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 10)->where('estatus', 'Finalizado')->count()}}"
                                  data-noviembre="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 11)->where('estatus', 'Finalizado')->count()}}"
                                  data-diciembre="{{\App\Models\Factura::where(DB::raw("MONTH(created_at)"), 12)->where('estatus', 'Finalizado')->count()}}">
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
                                        <input type="text" name="cedula" class="form-control" placeholder="Cédula (opcional)">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="nombre" class="form-control" placeholder="Nombre (opcional)">
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
        var enero = $("#myAreaChart").attr("data-enero"), 
            febrero =$("#myAreaChart").attr("data-febrero"), 
            marzo =$("#myAreaChart").attr("data-marzo"), 
            abril =$("#myAreaChart").attr("data-abril"), 
            mayo =$("#myAreaChart").attr("data-mayo"), 
            junio =$("#myAreaChart").attr("data-junio"), 
            julio =$("#myAreaChart").attr("data-julio"), 
            agosto =$("#myAreaChart").attr("data-agosto"), 
            septiembre =$("#myAreaChart").attr("data-septiembre"), 
            octubre =$("#myAreaChart").attr("data-octubre"), 
            noviembre =$("#myAreaChart").attr("data-noviembre"), 
            diciembre =$("#myAreaChart").attr("data-diciembre");

        Chart.defaults.global.defaultFontFamily = 'Nunito, -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        var ctx = document.getElementById("myAreaChart");
        
        // Crear gradiente profesional
        var gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(78, 115, 223, 0.4)');
        gradient.addColorStop(1, 'rgba(78, 115, 223, 0)');

        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                datasets: [{
                    label: "Solicitudes resueltas",
                    lineTension: 0.4,
                    backgroundColor: gradient,
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [enero, febrero, marzo, abril, mayo, junio, julio, agosto, septiembre, octubre, noviembre, diciembre],
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Incluir un signo o unidad si es necesario
                            callback: function(value, index, values) {
                                return value;
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + tooltipItem.yLabel;
                        }
                    }
                }
            }
        });
    </script>
@endsection
