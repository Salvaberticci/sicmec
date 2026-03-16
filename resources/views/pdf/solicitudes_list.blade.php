@extends('pdf.layout')

@section('content')
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Beneficiario</th>
                <th>Médico</th>
                <th>Patología</th>
                <th>Estatus</th>
                <th>Items</th>
                <th>Fecha</th>
                <th>Atendido por</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facturas as $factura)
                <tr>
                    <td class="font-bold">#{{ $factura->id }}</td>
                    <td>{{ $factura->cliente->nombre ?? 'N/A' }}</td>
                    <td>{{ $factura->medico_tratante ?? '-' }}</td>
                    <td>{{ $factura->patologia ?? '-' }}</td>
                    <td>
                        <span class="badge {{ 
                                    $factura->estatus == 'Finalizado' ? 'bg-success' :
                ($factura->estatus == 'Procesando' ? 'bg-info' : 'bg-warning') 
                                }}">
                            {{ $factura->estatus }}
                        </span>
                    </td>
                    <td class="text-right">{{ $factura->total_medicamentos }}</td>
                    <td>{{ $factura->created_at->format('d/m/Y') }}</td>
                    <td>{{ $factura->atendido_por ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right">
        <p class="font-bold">Total de solicitudes: {{ count($facturas) }}</p>
        <p class="font-bold">Total medicamentos entregados: {{ collect($facturas)->sum('total_medicamentos') }}</p>
    </div>
@endsection