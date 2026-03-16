<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            background-color: #1a3c6b;
            color: white;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 11px;
            opacity: 0.85;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            background: #e9eff7;
            border-left: 4px solid #1a3c6b;
            padding: 6px 10px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1a3c6b;
            color: white;
            padding: 6px 8px;
            text-align: left;
            font-size: 11px;
        }

        td {
            padding: 5px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }

        tr:nth-child(even) {
            background-color: #f5f8fc;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 10px;
        }

        .status-en-espera {
            background: #fff3cd;
            color: #856404;
        }

        .status-finalizada {
            background: #d1e7dd;
            color: #0a3622;
        }

        .status-aprobada {
            background: #cfe2ff;
            color: #084298;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Sistema SICMEC</h1>
        <p>Planilla de Solicitud de Medicamentos</p>
    </div>

    <div class="section">
        <div class="section-title">📋 Datos de la Solicitud</div>
        <table>
            <tr>
                <td><strong>N° de Solicitud:</strong></td>
                <td>#{{ $factura->id }}</td>
            </tr>
            <tr>
                <td><strong>Fecha:</strong></td>
                <td>{{ $factura->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Estatus:</strong></td>
                <td>{{ $factura->estatus }}</td>
            </tr>
            <tr>
                <td><strong>Atendido por:</strong></td>
                <td>{{ $factura->atendido_por ?? 'N/A' }}</td>
            </tr>
            @if($factura->medico_tratante)
                <tr>
                    <td><strong>Médico Tratante:</strong></td>
                    <td>{{ $factura->medico_tratante }}</td>
                </tr>
            @endif
            @if($factura->patologia)
                <tr>
                    <td><strong>Patología:</strong></td>
                    <td>{{ $factura->patologia }}</td>
                </tr>
            @endif
            @if($factura->observacion)
                <tr>
                    <td><strong>Observación:</strong></td>
                    <td>{{ $factura->observacion }}</td>
                </tr>
            @endif
        </table>
    </div>

    <div class="section">
        <div class="section-title">👤 Datos del Beneficiario</div>
        <table>
            <tr>
                <td><strong>Nombre:</strong></td>
                <td>{{ $factura->cliente->nombre }}</td>
            </tr>
            <tr>
                <td><strong>Cédula:</strong></td>
                <td>{{ $factura->cliente->cedula }}</td>
            </tr>
            <tr>
                <td><strong>Teléfono:</strong></td>
                <td>{{ $factura->cliente->telefono }}</td>
            </tr>
            <tr>
                <td><strong>Dirección:</strong></td>
                <td>{{ $factura->cliente->direccion }}</td>
            </tr>
            @if($factura->cliente->nro_expediente)
                <tr>
                    <td><strong>N° Expediente:</strong></td>
                    <td>{{ $factura->cliente->nro_expediente }}</td>
                </tr>
            @endif
            @if($factura->cliente->ubch_centro_electoral)
                <tr>
                    <td><strong>UBCH / Centro:</strong></td>
                    <td>{{ $factura->cliente->ubch_centro_electoral }}</td>
                </tr>
            @endif
        </table>
    </div>

    <div class="section">
        <div class="section-title">💊 Medicamentos / Insumos Solicitados</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Presentación</th>
                    <th>Unidad</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($factura->facturas_renglones) && count($factura->facturas_renglones) > 0)
                    @foreach($factura->facturas_renglones as $i => $renglon)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $renglon->producto->nombre_producto ?? 'N/A' }}</td>
                            <td>{{ $renglon->producto->presentacion ?? '-' }}</td>
                            <td>{{ $renglon->producto->unidad ?? '-' }}</td>
                            <td>{{ $renglon->cantidad }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align:center;">Sin productos registrados</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <p style="text-align:right; font-weight:bold; margin-top:8px;">
            Total de ítems: {{ $factura->total_medicamentos }}
        </p>
    </div>

    @if($factura->archivo_planilla)
        <div class="section" style="page-break-inside: avoid;">
            <div class="section-title">🖼️ Imagen de Referencia (Planilla)</div>
            <div style="text-align: center; margin-top: 10px;">
                @php
                    $path = $factura->archivo_planilla;
                    $imagePath = public_path($path);

                    // Robust path resolution for different environments
                    if (!file_exists($imagePath)) {
                        $imagePath = base_path('public/' . $path);
                    }

                    $imageData = "";
                    if (file_exists($imagePath)) {
                        try {
                            $type = pathinfo($imagePath, PATHINFO_EXTENSION);
                            $data = file_get_contents($imagePath);
                            $imageData = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        } catch (\Exception $e) {
                            $imageData = "";
                        }
                    }
                @endphp
                @if ($imageData)
                    <img src="{{ $imageData }}"
                        style="max-width: 100%; max-height: 450px; border: 1px solid #ddd; border-radius: 5px;">
                @else
                    <p style="color: #888; font-style: italic;">(Archivo de imagen no encontrado o ilegible:
                        {{ $path }})
                    </p>
                @endif
            </div>
        </div>
    @endif

    <div class="footer">
        <p>Este documento fue generado automáticamente por el Sistema SICMEC.</p>
        <p>Presentar este documento (impreso o digital) al momento del retiro.</p>
    </div>
</body>

</html>