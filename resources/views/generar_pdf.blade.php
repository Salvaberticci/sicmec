<!DOCTYPE html>
<html>
<head>
    <title>Reporte PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
        }
        th {
            text-align: left;
            background-color: #f0f0f0;
        }
        img{
            height: 10em;
            width: 19em;
        }
    </style>
</head>
<body>
        @php 
        $total_medicamentos = 0;
        $total_ayudas = 0;
        $total_ayudas_tec = 0;
        $i = 1;
        $fecha_numero = \Carbon\Carbon::parse($fecha_fin)->format('m') * 1;
        $lista = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        @endphp
            @foreach($meses as $mes)
            <img src="{{asset('img/logo_gobernacion.jpeg')}}">
            <img src="{{asset('img/logo_ac.jpeg')}}" style="float: right;">
            <h1 style="text-align: center;">Medicamentos Resueltos  <b>DESDE</b>: {{ $lista[\Carbon\Carbon::parse($fecha_inicio)->format('n') - 1] }} <b>HASTA</b>: {{$lista[\Carbon\Carbon::parse($fecha_fin)->format('n') - 1]}}</h1>
            <div style="background: #ccc; padding:5px; width: 50px; text-transform: uppercase; text-align: center; margin: 0 auto;">
                <h4>{{ $lista[\Carbon\Carbon::parse($meses[$i - 1]->created_at)->format('n') - 1]}}</h4>
            </div>
                    
            <table>
                <thead>
                    <tr>
                        <th>N</th>
                        <th>Nombres y Apellidos</th>
                        <th>Cedula</th>
                        <th>Telefono</th>
                        <th>Direccion</th>
                        <th>Medicamentos Solicitados</th>
                        <th>Centro de Votacion UBCH</th>
                        <th>Estatus</th>
                        <th>Fecha</th>
                        <th>Código VenAPP</th>
                        <th>UD.</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                    $personaNumber = 1;
                @endphp 
                    @foreach ($informacion_filtrada as $info)
                        @if(\Carbon\Carbon::parse($mes->created_at)->format('n') == \Carbon\Carbon::parse($info->created_at)->format('n'))
                            <tr>
                                <td>{{ $personaNumber }}</td>                
                                <td>{{ $info->cliente->nombre }}</td>
                                <td>{{ $info->cliente->cedula }}</td>
                                <td>{{ $info->cliente->telefono }}</td>
                                <td>{{ $info->cliente->direccion }}</td>
                                <td>
                                    @foreach($info->facturas_renglones as $renglon)
                                        {{ $renglon->producto->nombre_producto . ', ' }}
                                        @php 
                                            $total_medicamentos += $renglon->cantidad;                        
                                        @endphp

                                        @if($renglon->producto->tipo == "ayudasTecnicas")
                                        @php
                                            $total_ayudas_tec += $renglon->cantidad
                                        @endphp
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $info->cliente->ubch_centro_electoral }}</td>
                                <td>{{ $info->estatus }}</td>
                                <td>{{ $info->created_at }}</td>
                                <td>{{ $info->observacion }}</td>
                                <td>{{ $info->total_medicamentos }}</td>
                            </tr>
                            @if($info->estatus == "Finalizado")
                                @php
                                    $total_ayudas++; 
                                @endphp
                            @endif
                            @php
                                $personaNumber++; 
                            @endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
            @if($i < count($meses))
            <div style="page-break-after: always"></div>
            @endif
            @php 
            $i++;
            @endphp
            @endforeach
            <hr>
    <div>
        <h3>Totales</h3>
        <table style="width: 30%;">
            <tbody>
                <tr>
                    <td style="font-weight: bold;">Total personas atendidas:</td>
                    <td style="text-align: right;">{{ $informacion_filtrada->count() }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Total ayudas entregadas:</td>
                    <td style="text-align: right;">{{ $total_ayudas }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Total medicamentos:</td>
                    <td style="text-align: right;">{{ $total_medicamentos }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Total ayudas técnicas:</td>
                    <td style="text-align: right;">{{ $total_ayudas_tec }}</td>
                </tr>

                <!-- Agrega otras filas de totales si es necesario -->
            </tbody>
        </table>
    </div>
</body>
<script>
    // print();
</script>
</html>