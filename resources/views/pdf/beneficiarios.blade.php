@extends('pdf.layout')

@section('content')
    <table>
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Expediente</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td class="font-bold">{{ $cliente->cedula }}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->telefono ?? 'S/N' }}</td>
                    <td>{{ $cliente->direccion ?? 'S/D' }}</td>
                    <td>{{ $cliente->nro_expediente ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right">
        <p class="font-bold">Total de beneficiarios: {{ count($clientes) }}</p>
    </div>
@endsection