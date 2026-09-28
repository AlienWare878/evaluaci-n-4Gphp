<?php
/**
 * ARCHIVO: conexion.php
 * DESCRIPCIÓN: Script de conexión a la base de datos MySQL utilizando PDO dentro de un bloque try-catch.
 * BASE DE DATOS: evaluacion_php4g
 */

// Parámetros de configuración de la base de datos
$host     = 'localhost';
$dbname   = 'evaluacion_php4g';
$username = 'root';
$password = ''; // Modificar si tu MySQL/MariaDB utiliza contraseña

$mensaje_conexion = '';
$conexion_exitosa = false;
$pdo = null;

try {
    // Configuración del DSN (Data Source Name)
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    
    // Opciones de configuración PDO para mayor seguridad y control de errores
    $opciones = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanzar excepciones ante errores
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // Retornar arrays asociativos
        PDO::ATTR_EMULATE_PREPARES   => false,                 // Desactivar emulación de sentencias preparadas
    ];

    // Creación de la instancia de PDO
    $pdo = new PDO($dsn, $username, $password, $opciones);
    
    $conexion_exitosa = true;
    $mensaje_conexion = "Conexión a la base de datos '$dbname' realizada con éxito.";

} catch (PDOException $e) {
    $conexion_exitosa = false;
    $mensaje_conexion = "Error crítico de conexión a la base de datos: " . $e->getMessage();
}

// Si se ingresa directamente a conexion.php en el navegador, renderiza el mensaje
if (basename(__FILE__) === basename($_SERVER['PHP_SELF'] ?? '')) {
    header('Content-Type: text/html; charset=utf-8');
    echo "<div style='font-family: Arial, sans-serif; padding: 15px; margin: 20px; border-radius: 6px; " .
         ($conexion_exitosa ? "background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;'" : "background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;'") . ">" .
         "<strong>" . ($conexion_exitosa ? "✓ ÉXITO: " : "✗ ERROR: ") . "</strong>" . htmlspecialchars($mensaje_conexion) .
         "</div>";
}
