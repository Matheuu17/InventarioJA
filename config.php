<?php

// Ruta absoluta al proyecto (funciona en XAMPP y Render)
define("APP_PATH", __DIR__);

// Base URL dinámica — leer desde variable de entorno si está en Render
$envBaseUrl = getenv("BASE_URL");

if ($envBaseUrl) {
    define("BASE_URL", rtrim($envBaseUrl, "/") . "/");
} else {
    // URL en local (ajusta si tu carpeta se llama distinto)
    define("BASE_URL", "http://localhost:8012/inventario/");
}
?>
