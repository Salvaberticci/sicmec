<?php
// public/reportes-simple.php
require_once '../vendor/autoload.php';
require_once '../bootstrap/app.php';

use Illuminate\Support\Facades\DB;

// Lógica simple para mostrar clientes
$clientes = DB::table('clientes')->get();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reportes Simple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Reporte de Beneficiarios</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= $cliente->cedula ?></td>
                    <td><?= $cliente->nombre ?></td>
                    <td><?= $cliente->telefono ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>