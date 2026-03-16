<?php
// Función para cargar variables del .env
function getEnvValue($key, $default = '')
{
    $path = __DIR__ . '/../.env';
    if (file_exists($path)) {
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if (!$line || strpos($line, '#') === 0)
                continue;
            if (strpos($line, '=') === false)
                continue;

            list($name, $value) = explode('=', $line, 2);
            if (trim($name) == $key) {
                $value = trim($value);
                // Remove quotes if present
                if (
                    (strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) ||
                    (strpos($value, "'") === 0 && strrpos($value, "'") === strlen($value) - 1)
                ) {
                    $value = substr($value, 1, -1);
                }
                return $value;
            }
        }
    }
    return $default;
}

// Conexión dinámica usando el .env de Laravel
$host = getEnvValue('DB_HOST', 'localhost');
$dbname = getEnvValue('DB_DATABASE', 'sicmec');
$user = getEnvValue('DB_USERNAME', 'root');
$pass = getEnvValue('DB_PASSWORD', '');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión en Reportes: " . $e->getMessage() . " (Verifica el archivo .env)");
}

// Determinar qué reporte generar
$tipo_reporte = $_GET['tipo'] ?? 'beneficiarios';
$filtro_cedula = $_GET['cedula'] ?? '';
$filtro_nombre = $_GET['nombre'] ?? '';
$filtro_tipo = $_GET['filtro_tipo'] ?? '';

// Construir consultas con filtros - USANDO PREPARED STATEMENTS
$params_clientes = [];
$where_clientes = "1=1";
if ($filtro_cedula) {
    $where_clientes .= " AND cedula LIKE ?";
    $params_clientes[] = "%$filtro_cedula%";
}
if ($filtro_nombre) {
    $where_clientes .= " AND nombre LIKE ?";
    $params_clientes[] = "%$filtro_nombre%";
}

$params_productos = [];
$where_productos = "1=1";
if ($filtro_tipo) {
    $where_productos .= " AND tipo = ?";
    $params_productos[] = $filtro_tipo;
}

// Ejecutar consultas de forma segura
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE $where_clientes");
$stmt->execute($params_clientes);
$clientes = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $pdo->prepare("SELECT * FROM productos WHERE $where_productos");
$stmt->execute($params_productos);
$productos = $stmt->fetchAll(PDO::FETCH_OBJ);

$facturas = $pdo->query("SELECT f.*, c.nombre as cliente_nombre
FROM facturas f
LEFT JOIN clientes c ON f.cliente_id = c.id
ORDER BY f.created_at DESC
LIMIT 50")->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Reportes - SICMEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primario: #218cff;
            --color-primario-hover: #1a7ae6;
        }

        .header-reporte {
            background: var(--color-primario);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }

        .card-reporte {
            border: none;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(33, 140, 255, 0.1);
            transition: transform 0.3s ease;
        }

        .card-reporte:hover {
            transform: translateY(-2px);
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            background: transparent;
            color: var(--color-primario);
            border-bottom: 3px solid var(--color-primario);
        }

        .btn-primary {
            background: var(--color-primario);
            border: none;
        }

        .btn-primary:hover {
            background: var(--color-primario-hover);
        }

        .estadistica-card {
            text-align: center;
            padding: 1.5rem;
        }

        .estadistica-numero {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--color-primario);
        }

        .filtros-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--color-primario);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(33, 140, 255, 0.05);
        }

        .badge-primary {
            background: var(--color-primario);
        }

        /* Estilos para impresión */
        @media print {
            .no-print {
                display: none !important;
            }

            .header-reporte {
                background: #218cff !important;
                -webkit-print-color-adjust: exact;
            }

            .card-reporte {
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .table-dark {
                background: #343a40 !important;
                -webkit-print-color-adjust: exact;
            }

            .badge {
                border: 1px solid #000;
            }

            body {
                font-size: 12px;
            }

            .container {
                width: 100%;
                max-width: none;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header-reporte">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-chart-line me-3"></i>Sistema de Reportes</h1>
                    <p class="lead mb-0">Módulo de generación de reportes - SICMEC</p>
                </div>
                <div class="col-md-4 text-end no-print">
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-calendar me-1"></i>
                        <?= date('d/m/Y') ?>
                    </span>
                </div>
                <div style="text-align:right;">
                    <a href="/sicmec/public/home" class="btn btn-outline-light no-print">
                        <i class="fas fa-home me-1"></i>Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Estadísticas Rápidas - Ocultar al imprimir -->
        <div class="row mb-4 no-print">
            <div class="col-md-3">
                <div class="card card-reporte">
                    <div class="card-body estadistica-card">
                        <div class="estadistica-numero"><?= count($clientes) ?></div>
                        <div class="text-muted">Total Beneficiarios</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-reporte">
                    <div class="card-body estadistica-card">
                        <div class="estadistica-numero"><?= count($productos) ?></div>
                        <div class="text-muted">Total Productos</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-reporte">
                    <div class="card-body estadistica-card">
                        <div class="estadistica-numero"><?= count($facturas) ?></div>
                        <div class="text-muted">Solicitudes Recientes</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-reporte">
                    <div class="card-body estadistica-card">
                        <button onclick="imprimirLaravelPDF()" class="btn btn-primary btn-lg">
                            <i class="fas fa-print me-2"></i>Imprimir
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navegación - Ocultar al imprimir -->
        <ul class="nav nav-tabs mb-4 no-print">
            <li class="nav-item">
                <a class="nav-link <?= $tipo_reporte == 'beneficiarios' ? 'active' : '' ?>" href="?tipo=beneficiarios">
                    <i class="fas fa-users me-2"></i>Beneficiarios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $tipo_reporte == 'inventario' ? 'active' : '' ?>" href="?tipo=inventario">
                    <i class="fas fa-boxes me-2"></i>Inventario
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $tipo_reporte == 'solicitudes' ? 'active' : '' ?>" href="?tipo=solicitudes">
                    <i class="fas fa-file-invoice me-2"></i>Solicitudes
                </a>
            </li>
        </ul>

        <!-- Filtros - Ocultar al imprimir -->
        <div class="filtros-section no-print">
            <h5><i class="fas fa-filter me-2"></i>Filtros de Búsqueda</h5>
            <?php if ($tipo_reporte == 'beneficiarios'): ?>
                <form method="GET" class="row g-3">
                    <input type="hidden" name="tipo" value="beneficiarios">
                    <div class="col-md-4">
                        <input type="text" name="cedula" class="form-control" placeholder="Filtrar por cédula"
                            value="<?= $filtro_cedula ?>">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="nombre" class="form-control" placeholder="Filtrar por nombre"
                            value="<?= $filtro_nombre ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>Filtrar
                        </button>
                        <a href="?tipo=beneficiarios" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-1"></i>Limpiar
                        </a>
                    </div>
                </form>

            <?php elseif ($tipo_reporte == 'inventario'): ?>
                <form method="GET" class="row g-3">
                    <input type="hidden" name="tipo" value="inventario">
                    <div class="col-md-6">
                        <select name="filtro_tipo" class="form-control">
                            <option value="">Todos los tipos</option>
                            <option value="medicamento" <?= $filtro_tipo == 'medicamento' ? 'selected' : '' ?>>Medicamentos
                            </option>
                            <option value="insumo" <?= $filtro_tipo == 'insumo' ? 'selected' : '' ?>>Insumos</option>
                            <option value="ayudasTecnicas" <?= $filtro_tipo == 'ayudasTecnicas' ? 'selected' : '' ?>>Ayudas
                                Técnicas</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>Filtrar
                        </button>
                        <a href="?tipo=inventario" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-1"></i>Limpiar
                        </a>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <!-- Contenido del Reporte -->
        <div class="card card-reporte">
            <div class="card-body">
                <?php if ($tipo_reporte == 'beneficiarios'): ?>

                    <h4 class="card-title mb-4">
                        <i class="fas fa-users me-2"></i>Reporte de Beneficiarios
                        <span class="badge bg-primary ms-2"><?= count($clientes) ?> registros</span>
                    </h4>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Saldo</th>
                                    <th>Expediente</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clientes as $cliente): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($cliente->cedula) ?></strong></td>
                                        <td><?= htmlspecialchars($cliente->nombre) ?></td>
                                        <td><?= htmlspecialchars($cliente->telefono) ?></td>
                                        <td><?= htmlspecialchars($cliente->direccion) ?></td>
                                        <td><span
                                                class="badge bg-<?= (isset($cliente->saldo) && $cliente->saldo > 0) ? 'warning' : 'success' ?>">
                                                <?= number_format($cliente->saldo ?? 0, 2) ?>
                                            </span></td>
                                        <td><?= htmlspecialchars($cliente->nro_expediente) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php elseif ($tipo_reporte == 'inventario'): ?>

                    <h4 class="card-title mb-4">
                        <i class="fas fa-boxes me-2"></i>Reporte de Inventario
                        <span class="badge bg-primary ms-2"><?= count($productos) ?> productos</span>
                    </h4>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Existencia</th>
                                    <th>Tipo</th>
                                    <th>Unidad</th>
                                    <th>Peso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos as $producto): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($producto->codigo) ?></strong></td>
                                        <td><?= htmlspecialchars($producto->nombre_producto) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $producto->existencia > 0 ? 'success' : 'danger' ?>">
                                                <?= htmlspecialchars($producto->existencia) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?=
                                                $producto->tipo == 'medicamento' ? 'primary' :
                                                ($producto->tipo == 'insumo' ? 'info' : 'warning')
                                                ?>">
                                                <?= htmlspecialchars($producto->tipo) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($producto->unidad) ?></td>
                                        <td><?= htmlspecialchars($producto->peso) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php elseif ($tipo_reporte == 'solicitudes'): ?>

                    <h4 class="card-title mb-4">
                        <i class="fas fa-file-invoice me-2"></i>Reporte de Solicitudes Recientes
                        <span class="badge bg-primary ms-2"><?= count($facturas) ?> solicitudes</span>
                    </h4>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Total Medicamentos</th>
                                    <th>Estatus</th>
                                    <th>Atendido Por</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($facturas as $factura): ?>
                                    <tr>
                                        <td><strong>#<?= $factura->id ?></strong></td>
                                        <td><?= htmlspecialchars($factura->cliente_nombre) ?></td>
                                        <td><?= number_format($factura->total_medicamentos, 0) ?></td>
                                        <td>
                                            <span
                                                class="badge bg-<?= $factura->estatus == 'Finalizada' ? 'success' : 'warning' ?>">
                                                <?= htmlspecialchars($factura->estatus) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($factura->atendido_por) ?></td>
                                        <td><?= date('d/m/Y', strtotime($factura->created_at)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php endif; ?>
            </div>
        </div>

        <!-- Pie de página -->
        <div class="text-center mt-4 text-muted">
            <p>&copy; 2026 Sicmec. Todos los derechos reservados. - Sistema SICMEC v1.0</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function imprimirLaravelPDF() {
            const urlParams = new URLSearchParams(window.location.search);
            const tipo = urlParams.get('tipo') || 'beneficiarios';
            const cedula = urlParams.get('cedula') || '';
            const nombre = urlParams.get('nombre') || '';
            const filtro_tipo = urlParams.get('filtro_tipo') || '';

            let baseUrl = '/sicmec/public/reportes/';
            let finalUrl = '';

            if (tipo === 'beneficiarios') {
                finalUrl = `${baseUrl}ficha-beneficiario?generar_pdf=1&cedula=${cedula}&nombre=${nombre}`;
            } else if (tipo === 'inventario') {
                finalUrl = `${baseUrl}inventario?generar_pdf=1&tipo=${filtro_tipo}`;
            } else if (tipo === 'solicitudes') {
                finalUrl = `${baseUrl}solicitudes?generar_pdf=1`;
            }

            if (finalUrl) {
                window.open(finalUrl, '_blank');
            }
        }

        function imprimirReporte() {
            // Fallback for browser print if needed
            window.print();
        }
    </script>
</body>

</html>