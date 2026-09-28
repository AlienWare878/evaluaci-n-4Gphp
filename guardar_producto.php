<?php
/**
 * ARCHIVO: guardar_producto.php
 * DESCRIPCIÓN: Script PHP para procesar y guardar un nuevo producto en la tabla productos mediante PDO.
 */

// Inclusión del archivo de conexión
require_once __DIR__ . '/conexion.php';

$mensaje = '';
$tipo_alerta = 'danger';

// Verificar que la solicitud sea por el método POST
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    // Obtener y sanitizar los datos del formulario
    $nombre    = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $precio    = isset($_POST['precio']) ? filter_var($_POST['precio'], FILTER_VALIDATE_INT) : false;
    $stock     = isset($_POST['stock']) ? filter_var($_POST['stock'], FILTER_VALIDATE_INT) : false;
    $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';

    // Validaciones del servidor
    if (empty($nombre) || strlen($nombre) > 100) {
        $mensaje = 'El nombre del producto es obligatorio y debe tener máximo 100 caracteres.';
    } elseif ($precio === false || $precio < 0) {
        $mensaje = 'El precio es obligatorio y debe ser un número entero válido (≥ 0).';
    } elseif ($stock === false || $stock < 0) {
        $mensaje = 'El stock es obligatorio y debe ser un número entero válido (≥ 0).';
    } elseif (empty($categoria) || strlen($categoria) > 100) {
        $mensaje = 'La categoría es obligatoria y debe tener máximo 100 caracteres.';
    } elseif (!$conexion_exitosa || !$pdo) {
        $mensaje = 'No se pudo conectar a la base de datos: ' . $mensaje_conexion;
    } else {
        try {
            // Sentencia SQL preparada para inserción de datos
            $sql = "INSERT INTO productos (nombre, precio, stock, categoria) 
                    VALUES (:nombre, :precio, :stock, :categoria)";
            
            $stmt = $pdo->prepare($sql);
            
            // Vincular parámetros y ejecutar
            $ejecutado = $stmt->execute([
                ':nombre'    => $nombre,
                ':precio'    => $precio,
                ':stock'     => $stock,
                ':categoria' => $categoria
            ]);

            if ($ejecutado) {
                // Redireccionar exitosamente a index.php con mensaje de confirmación
                $msg_exito = "Producto '$nombre' registrado exitosamente.";
                header("Location: index.php?status=success&msg=" . urlencode($msg_exito));
                exit();
            } else {
                $mensaje = 'Error al intentar guardar el registro en la base de datos.';
            }
        } catch (PDOException $e) {
            $mensaje = 'Error PDO en la inserción: ' . $e->getMessage();
        }
    }
} else {
    $mensaje = 'Acceso denegado: El formulario debe ser enviado mediante el método POST.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Producto - Evaluación PHP 4G</title>
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

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-body p-4 text-center">
                        <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill fs-2 me-3"></i>
                            <div class="text-start">
                                <h5 class="alert-heading fw-bold mb-1">No se pudo guardar el producto</h5>
                                <span><?= htmlspecialchars($mensaje) ?></span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="crear_producto.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Volver al Formulario
                            </a>
                            <a href="index.php" class="btn btn-primary">
                                <i class="bi bi-house me-1"></i> Ir al Inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
