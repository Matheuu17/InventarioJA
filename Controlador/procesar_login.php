<?php
session_start();

/* ============================================================
 *  Includes
 * ============================================================ */

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../Modelo/conexion.php";
require_once __DIR__ . "/../Modelo/modeloUsuario.php";

/* ============================================================
 *  Instanciar modelo con PDO
 * ============================================================ */

$db            = (new Database())->conectar();
$modeloUsuario = new modeloUsuario($db);

/* ============================================================
 *  Procesar login
 * ============================================================ */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombreU = trim($_POST['nombreU'] ?? '');
    $pass    = $_POST['pass'] ?? '';

    if ($nombreU === '' || $pass === '') {
        header("Location: " . BASE_URL . "index.php?error=vacio");
        exit();
    }

    // Buscar usuario por nombreU
    $row = $modeloUsuario->buscarPorNombreU($nombreU);

    if ($row && password_verify($pass, $row['pass'])) {

        $_SESSION['idUsuario'] = $row['idUsuario'];
        $_SESSION['nombreU']   = $row['nombreU'];
        $_SESSION['esAdmin']   = (bool)$row['esAdmin'];

        if ($row['esAdmin']) {
            header("Location: " . BASE_URL . "Controlador/controladorAdministrador.php?seccion=usuarios");
        } else {
            header("Location: " . BASE_URL . "Controlador/controladorProducto.php?accion=listar");
        }
        exit();
    }

    header("Location: " . BASE_URL . "index.php?error=incorrecto");
    exit();
}
