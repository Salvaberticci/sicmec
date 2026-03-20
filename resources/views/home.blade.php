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
              <h2>Estadística de solicitudes resueltas</h2>
              <hr>
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
      </section> 
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

          console.log(junio)
      // Set new default font family and font color to mimic Bootstrap's default styling
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.global.defaultFontColor = '#292b2c';

                // Area Chart Example
                var ctx = document.getElementById("myAreaChart");
                var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    datasets: [{
                    label: "Solicitudes resueltas",
                    lineTension: 0.3,
                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                    borderColor: "blue",
                    pointRadius: 5,
                    pointBackgroundColor: "#fff",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "red",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: [enero, febrero, marzo, abril, mayo, junio, julio, agosto, septiembre, octubre, noviembre, diciembre],
                    }],
                },
                options: {
                    scales: {
                    xAxes: [{
                        time: {
                        unit: 'date'
                        },
                        gridLines: {
                        display: false
                        },
                        ticks: {
                        maxTicksLimit: 12
                        }
                    }],
                    yAxes: [{
                        ticks: {
                        min: 0,
                        max: 100,
                        maxTicksLimit: 5
                        },
                        gridLines: {
                        color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                    },
                    legend: {
                    display: false
                    }
                }
            });
    </script>
@endsection
