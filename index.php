<?php
/**
 * ARCHIVO: index.php
 * DESCRIPCIÓN: Página principal de la aplicación web.
 * Incluye obligatoriamente conexion.php, muestra el estado de conexión, el listado de productos y enlace a crear_producto.php.
 */

// Inclusión obligatoria del archivo de conexión
require_once __DIR__ . '/conexion.php';

// Obtención de productos registrados si la conexión fue exitosa
$productos = [];
if ($conexion_exitosa && $pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM productos ORDER BY fecha_registro DESC");
        $productos = $stmt->fetchAll();
    } catch (PDOException $e) {
        // En caso de error en la consulta
        $productos = [];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación PHP 4G - Gestión de Productos</title>
    <!-- CDN Bootstrap 5 para un diseño visual limpio y profesional -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-box-seam me-2"></i>Evaluación PHP 4G
            </a>
        </div>
    </nav>

    <main class="container my-4">
        
        <!-- Header Principal -->
        <div class="p-4 p-md-5 mb-4 rounded text-bg-dark text-center shadow">
            <h1 class="display-5 fw-bold">Sistema de Gestión de Productos</h1>
            <p class="lead my-3">Aplicación Web PHP - Primera Parte Evaluada Académicamente</p>
        </div>

        <!-- Alerta de resultado tras guardar un producto (Redirección desde guardar_producto.php) -->
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success' && !empty($_GET['msg'])): ?>
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <strong>¡Éxito!</strong> <?= htmlspecialchars($_GET['msg']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Muestra visual obligatoria de la conexión a la base de datos -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <?php if ($conexion_exitosa): ?>
                    <div class="alert alert-success d-flex align-items-center shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill fs-3 me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1 fw-bold">¡Conexión Exitosa!</h5>
                            <span><?= htmlspecialchars($mensaje_conexion) ?></span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger d-flex align-items-center shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-3 me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1 fw-bold">Error de Conexión</h5>
                            <span><?= htmlspecialchars($mensaje_conexion) ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Botón claro que redirige a crear_producto.php -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 d-flex justify-content-between align-items-center">
                <h3 class="fw-bold m-0"><i class="bi bi-list-task me-2 text-primary"></i>Lista de Productos</h3>
                <a href="crear_producto.php" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i>Crear Nuevo Producto
                </a>
            </div>
        </div>

        <!-- Tabla con el listado de productos -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle m-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Precio ($)</th>
                                        <th>Stock</th>
                                        <th>Categoría</th>
                                        <th>Fecha Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($productos)): ?>
                                        <?php foreach ($productos as $prod): ?>
                                            <tr>
                                                <td class="fw-bold"><?= htmlspecialchars($prod['id']) ?></td>
                                                <td><?= htmlspecialchars($prod['nombre']) ?></td>
                                                <td>$<?= number_format($prod['precio'], 0, ',', '.') ?></td>
                                                <td>
                                                    <span class="badge <?= $prod['stock'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                                        <?= htmlspecialchars($prod['stock']) ?> unidades
                                                    </span>
                                                </td>
                                                <td><span class="badge bg-secondary"><?= htmlspecialchars($prod['categoria']) ?></span></td>
                                                <td><small class="text-muted"><?= htmlspecialchars($prod['fecha_registro']) ?></small></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                                No hay productos registrados aún en la base de datos.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <footer class="text-center py-4 text-muted border-top mt-5 bg-white">
        <div class="container">
            <small>Desarrollado para Evaluación Académica PHP 4G &copy; <?= date('Y') ?></small>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
