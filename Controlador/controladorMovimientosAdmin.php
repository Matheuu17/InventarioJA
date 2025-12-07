<?php
session_start();

// Verificar que solo el admin accede
if (empty($_SESSION['esAdmin'])) {
    header("Location: ../index.php");
    exit();
}

// =========================================================
// 💡 CAMBIO CLAVE: Usar __DIR__ para rutas robustas
// =========================================================

// Cargar configuración (asumimos que está un nivel arriba)
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../Modelo/modeloMovimientos.php";
require_once __DIR__ . "/../Modelo/conexion.php"; // Necesario para la clase Database

// Crear conexión
// NOTA: Si tu modeloMovimientos espera la conexión por inyección de dependencia, 
// esta línea es correcta.
$db = (new Database())->conectar(); 

// Instanciar modelo con conexión
$modeloMov = new modeloMovimientos($db);

// Si hay parámetro GET idUsuario, lo convertimos a entero
// Usar null como valor por defecto es más claro que 0 si 0 no es un ID válido.
$idUsuario = isset($_GET['idUsuario']) ? (int)$_GET['idUsuario'] : null;

// Obtener movimientos según corresponda
if ($idUsuario !== null && $idUsuario > 0) {
    // Movimientos filtrados por usuario
    $movimientos = $modeloMov->obtenerMovimientosPorUsuario($idUsuario);
} else {
    // Todos los movimientos
    $movimientos = $modeloMov->obtenerMovimientos();
}

// Mostrar vista
include __DIR__ . "/../Vista/vistaMovimientosAdmin.php";

?>