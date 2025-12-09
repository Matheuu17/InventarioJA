<?php
define("APP_PATH", __DIR__);

$envBaseUrl = getenv("BASE_URL");

if ($envBaseUrl) {
    define("BASE_URL", rtrim($envBaseUrl, "/") . "/");
} else {
    // SOLO para local va la carpeta /inventario
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
    
    if (php_sapi_name() === 'cli-server' || strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
        // Entorno local (XAMPP)
        $host = $_SERVER['HTTP_HOST']; // localhost:8012
        define("BASE_URL", $protocol . $host . "/inventario/");
    } else {
        // Render (raíz del dominio)
        $host = $_SERVER['HTTP_HOST']; // inventarioja.onrender.com
        define("BASE_URL", $protocol . $host . "/");
    }
}
