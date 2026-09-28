<?php
/**
 * ARCHIVO: crear_producto.php
 * DESCRIPCIÓN: Formulario HTML/PHP para ingresar los datos de un nuevo producto.
 * Envía la información vía POST a guardar_producto.php.
 */
require_once __DIR__ . '/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto - Evaluación PHP 4G</title>
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h3 class="card-title fw-bold m-0 text-dark">
                            <i class="bi bi-plus-circle me-2 text-primary"></i>Registrar Nuevo Producto
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <!-- Formulario de creación con action dirigido a guardar_producto.php -->
                        <form action="guardar_producto.php" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label fw-semibold">Nombre del Producto *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" placeholder="Ej: Laptop Gamer 16GB" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="precio" class="form-label fw-semibold">Precio ($) *</label>
                                    <input type="number" class="form-control" id="precio" name="precio" min="0" placeholder="Ej: 650000" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="stock" class="form-label fw-semibold">Stock (Cantidad) *</label>
                                    <input type="number" class="form-control" id="stock" name="stock" min="0" placeholder="Ej: 15" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="categoria" class="form-label fw-semibold">Categoría *</label>
                                <input type="text" class="form-control" id="categoria" name="categoria" maxlength="100" placeholder="Ej: Computación" required>
                            </div>

                            <div class="d-flex justify-content-between pt-2">
                                <a href="index.php" class="btn btn-secondary px-4">
                                    <i class="bi bi-arrow-left me-1"></i> Cancelar / Volver
                                </a>
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="bi bi-save me-1"></i> Guardar Producto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
