<?php
define("APP_PATH", __DIR__);

$envBaseUrl = getenv("BASE_URL");

if ($envBaseUrl) {
    define("BASE_URL", rtrim($envBaseUrl, "/") . "/");
} else {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
    $host     = $_SERVER['HTTP_HOST']; // en local será localhost:8012; en Render, tuapp.onrender.com
    define("BASE_URL", $protocol . $host . "/inventario/");
}
?>