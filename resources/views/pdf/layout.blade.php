<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Reporte SICMEC' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #1a3c6b;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 12px;
            opacity: 0.9;
        }

        .content {
            padding: 20px;
        }

        .report-info {
            margin-bottom: 20px;
            font-size: 9px;
            color: #666;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #1a3c6b;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-size: 9px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
        }

        .bg-success {
            background-color: #d1e7dd;
            color: #0a3622;
        }

        .bg-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .bg-danger {
            background-color: #f8d7da;
            color: #842029;
        }

        .bg-info {
            background-color: #cff4fc;
            color: #055160;
        }

        .bg-primary {
            background-color: #cfe2ff;
            color: #084298;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Sistema SICMEC</h1>
        <p>{{ $title ?? 'Reporte de Sistema' }}</p>
    </div>

    <div class="content">
        <div class="report-info">
            Fecha de generación: {{ date('d/m/Y H:i:s') }} | Generado por: {{ Auth::user()->name ?? 'Administrador' }}
        </div>

        @yield('content')
    </div>

    <div class="footer">
        <p>Sistema de Control de Medicamentos y Ayudas (SICMEC) - v1.0</p>
        <p>Página 1 de 1</p>
    </div>
</body>

</html>