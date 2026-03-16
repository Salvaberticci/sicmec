@extends('pdf.layout')

@section('content')
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Existencia</th>
                <th>Tipo</th>
                <th>Presentación</th>
                <th>Unidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td class="font-bold">{{ $producto->nombre_producto }}</td>
                    <td>
                        <span class="badge {{ $producto->existencia > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $producto->existencia }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ 
                            $producto->tipo == 'medicamento' ? 'bg-primary' :
                ($producto->tipo == 'insumo' ? 'bg-info' : 'bg-warning') 
                        }}">
                            {{ $producto->tipo }}
                        </span>
                    </td>
                    <td>{{ $producto->presentacion ?? 'S/A' }}</td>
                    <td>{{ $producto->unidad ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right">
        <p class="font-bold">Total de productos: {{ count($productos) }}</p>
    </div>
@endsection