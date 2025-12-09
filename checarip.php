<?php
// Este script utiliza un servicio externo para determinar la IP pública de salida de Render.

// Inicializar cURL
$ch = curl_init();

// Establecer la URL del servicio
curl_setopt($ch, CURLOPT_URL, "http://checkip.amazonaws.com");

// Devolver la respuesta como una cadena en lugar de imprimirla directamente
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Ejecutar la solicitud
$ip_publica_render = curl_exec($ch);

// Cerrar el handle de cURL
curl_close($ch);

if ($ip_publica_render) {
    // Limpiar la IP de saltos de línea (que a veces añade cURL)
    $ip_limpia = trim($ip_publica_render);

    echo "<h1>✅ IP de Salida de Render Identificada:</h1>";
    echo "<p>Copia esta IP y agrégala al Security Group de AWS:</p>";
    echo "<h2>" . $ip_limpia . "/32</h2>";

    // **IMPORTANTE:** Si no ves la IP, asegúrate de que cURL esté instalado en tu contenedor Docker/PHP.
} else {
    echo "Error al obtener la IP. Asegúrate de que cURL esté disponible.";
}
?>