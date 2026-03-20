<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{$title}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset("plugins/fontawesome-free/css/all.min.css")}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset("plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset("plugins/jqvmap/jqvmap.min.css")}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset("dist/css/adminlte.min.css")}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset("plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset("plugins/daterangepicker/daterangepicker.css")}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset("plugins/summernote/summernote-bs4.min.css")}}">
  <link rel="stylesheet" href="{{asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}">
  <link rel="stylesheet" href="{{asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
  <link rel="stylesheet" href="{{asset("plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">
  @yield('styles')
  <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Modal de Reportes-->
    <div class="modal fade" id="reportes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Filtrar informacion por rango de fecha</h5>
          </div>
          <div class="modal-body text-center">
            <form action="reportes/filtro" method="post" class="form-inline justify-content-start align-items-center"
              target="_blank">
              @csrf
              <div class="form-group mx-2">
                <label for="start_date" class="mr-2">Fecha de inicio:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
              </div>
              <div class="form-group mx-2">
                <label for="end_date" class="mr-2">Fecha de fin:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
              </div>
              <button type="submit" class="btn btn-primary">Aplicar Filtro</button>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{asset('img/logo.png')}}" alt="InversionesGelvis" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li> --}}
      </ul>




      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          {{-- <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Buscar..."
                  aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div> --}}
        </li>

        <!-- Messages Dropdown Menu -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#reportes" href="#" role="button">
            <i class="fas fa-print"></i>
          </a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li> --}}
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar bg-gradient-primary elevation-4">
      <!-- Brand Logo -->
      <a href="" class="brand-link">
        <img src="{{asset('img/logo2.png')}}" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light text-white">SICMEC</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset('img/user.png')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block text-white">{{auth()->user()->name}}</a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="home"
                class="nav-link @if(Request::route()->getName() == "home") active bg-white @endif text-white">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Escritorio
                </p>
              </a>
            </li>
            <li class="nav-item menu-open">
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('bills.index')}}"
                    class="nav-link @if(Request::route()->getName() == "bills.index") active bg-white @endif text-white">
                    <i class="fas fa-folder-plus nav-icon"></i>
                    <p>Solicitudes</p>
                  </a>
                </li>

                {{-- <li class="nav-item">
                  <a href="{{route('payment.index')}}" class="nav-link text-white">
                    <i class="fa fa-briefcase nav-icon"></i>
                    <p>Cobros</p>
                  </a>
                </li> --}}
                <li class="nav-item">
                  <a href="{{route('products.index')}}"
                    class="nav-link @if(Request::route()->getName() == "products.index") active bg-white @endif text-white">
                    <i class="fas fa-boxes nav-icon"></i>
                    <p>Inventario</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{route('clients.index')}}"
                    class="nav-link  @if(Request::route()->getName() == "clients.index") active bg-white @endif text-white">
                    <i class="fas fa-diagnoses nav-icon"></i>
                    <p>Beneficiarios</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item menu-open">
              <a class="nav-link" href="/sicmec/public/reportes-directo.php" target="_blank"
                style="color:white;margin-left:8px;">
                <i class="fas fa-chart-bar" style="color:white;margin-right:7px;"></i> Reportes
              </a>
            </li>
            {{-- <li class="nav-item menu-open">
              <a href="#" class="nav-link text-white">
                <i class="nav-icon fas fa-cubes"></i>
                <p>
                  Inventario
                </p>
              </a>
              <ul class="nav nav-treeview">

              </ul>
            </li>
            <li class="nav-item menu-open">
              <a href="#" class="nav-link text-white">
                <i class="nav-icon fas fa-list"></i>
                <p>
                  Nómina
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('workers.index')}}" class="nav-link text-white">
                    <i class="fa fa-user-circle nav-icon"></i>
                    <p>Trabajadores</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('payrolls.index')}}" class="nav-link text-white">
                    <i class="far fa-credit-card nav-icon"></i>
                    <p>Pagos</p>
                  </a>
                </li>
              </ul>
            </li> --}}
            <li class="nav-item menu-open">
              {{-- <a href="#" class="nav-link text-white">
                <i class="fa fa-cogs nav-icon"></i>
                <p>
                  Configuración
                </p>
              </a> --}}
              <hr class="border-white">
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('users.index')}}"
                    class="nav-link  @if(Request::route()->getName() == "users.index") active bg-white @endif text-white">
                    <i class="fa fa-user nav-icon"></i>
                    <p>Usuarios</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('config.index')}}"
                    class="nav-link  @if(Request::route()->getName() == "config.index") active bg-white @endif text-white">
                    <i class="fa fa-cogs nav-icon"></i>
                    <p>Configuración</p>
                  </a>
                </li>
              </ul>
              <hr class="border-white">
            </li>


          </ul>
        </nav>
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a class="nav-link text-white" href="{{ route('logout') }}" onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                <i class="fa fa-arrow-left nav-icon"></i>
                <p>{{ __('Salir') }}</p>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">{{$title}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          @yield('content')
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2023.</strong>
      Todos los derechos reservados.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 0.0.1
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{asset("plugins/jquery/jquery.min.js")}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset("plugins/jquery-ui/jquery-ui.min.js")}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{asset("plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
  <!-- ChartJS -->
  <script src="{{asset("plugins/chart.js/Chart.min.js")}}"></script>
  <!-- Sparkline -->
  <script src="{{asset("plugins/sparklines/sparkline.js")}}"></script>
  <!-- JQVMap -->
  <script src="{{asset("plugins/jqvmap/jquery.vmap.min.js")}}"></script>
  <script src="{{asset("plugins/jqvmap/maps/jquery.vmap.usa.js")}}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{asset("plugins/jquery-knob/jquery.knob.min.js")}}"></script>
  <!-- daterangepicker -->
  <script src="{{asset("plugins/moment/moment.min.js")}}"></script>
  <script src="{{asset("plugins/daterangepicker/daterangepicker.js")}}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{asset("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}"></script>
  <!-- Summernote -->
  <script src="{{asset("plugins/summernote/summernote-bs4.min.js")}}"></script>
  <!-- overlayScrollbars -->
  <script src="{{asset("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset("plugins/datatables/jquery.dataTables.min.js")}}"></script>
  <script src="{{ asset("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}"></script>
  <script src="{{ asset("plugins/datatables-responsive/js/dataTables.responsive.min.js")}}"></script>
  <script src="{{ asset("plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}"></script>
  <script src="{{ asset("plugins/datatables-buttons/js/dataTables.buttons.min.js")}}"></script>
  <script src="{{ asset("plugins/datatables-buttons/js/buttons.bootstrap4.min.js")}}"></script>
  <script src="{{ asset("plugins/jszip/jszip.min.js")}}"></script>
  <script src="{{ asset("plugins/pdfmake/pdfmake.min.js")}}"></script>
  <script src="{{ asset("plugins/pdfmake/vfs_fonts.js")}}"></script>
  <script src="{{ asset("plugins/datatables-buttons/js/buttons.html5.min.js")}}"></script>
  <script src="{{ asset("plugins/datatables-buttons/js/buttons.print.min.js")}}"></script>
  <script src="{{ asset("plugins/datatables-buttons/js/buttons.colVis.min.js")}}"></script>
  <script src="{{asset("dist/js/adminlte.js")}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- AdminLTE for demo purposes -->
  {{--
  <script src="{{asset(" dist/js/demo.js")}}"></script> --}}
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{asset("dist/js/pages/dashboard.js")}}"></script>
  <script src="{{asset("dist/js/bootstrap-notify.min.js")}}"></script>
  <script>
    $(function () {
      $(".dataTable").DataTable({
        "responsive": true,
        "ordering": false,
        "language": {
          "url": '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        }
      })

      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "language": {
          "url": '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },

      });

    });

    const validator = {
      soloNumeros: function (event) {
        var code = (event.which) ? event.which : event.keyCode;

        if (code == 8) { // backspace.
          return true;
        } else if (code >= 48 && code <= 57) { // is a number.
          return true;
        } else { // other keys.
          return false;
        }
      },

      soloLetras: function (event) {
        if ((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122))
          event.returnValue = false;
      }
    }
  </script>
  @yield('scripts')
</body>

</html>