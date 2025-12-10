<?php
// PHP Lógica: No se modifica la lógica, solo se utiliza el token.
// aquí nada de SQL ni $mantenimiento, solo recibes $token
// Asumimos que $token está definido aquí, por ejemplo: $token = $_GET['token'] ?? '';
$token = $token ?? ''; // Usamos la variable $token (si existe)
?>
<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restablecer Contraseña</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Paleta de colores consistente
                        "immersive-blue-black": "#22404D",
                        "resilient-turquoise": "#00A0AF",
                        "empowered-yellow": "#E3E24F",
                        "sustainable-green": "#008B61",
                        "startup-white": "#FFFFFF",
                        "background-light": "#f6f6f8",
                        "background-dark": "#111621",
                        "ice": "#C3E5F5" // Usamos ICE para los acentos de fondo y bordes claros
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.5rem", "lg": "0.75rem", "xl": "1rem", "full": "9999px"},
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .bg-page {
            background-color: #f8f9ff;
        }
    </style>
</head>
<body class="font-display bg-page text-immersive-blue-black min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-2xl bg-resilient-turquoise/10 text-resilient-turquoise">
                <span class="material-symbols-outlined text-3xl">lock_reset</span>
            </div>
            <h1 class="text-3xl font-black mb-2 leading-tight">Establecer nueva clave</h1>
            <p class="text-immersive-blue-black/70 text-base">Ingresa y confirma tu nueva contraseña segura.</p>
        </div>

        <div class="bg-startup-white rounded-2xl shadow-xl p-6 sm:p-8 border border-ice/50">
            
            <form method="POST" action="../Controlador/controladorPassword.php?accion=reset" class="space-y-6">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-immersive-blue-black flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">lock</span>
                        Nueva contraseña
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            name="pass1"
                            id="pass1"
                            required
                            minlength="8"
                            placeholder="Mínimo 8 caracteres"
                            class="w-full h-12 pl-4 pr-12 rounded-xl border-2 border-ice focus:border-resilient-turquoise focus:ring-4 focus:ring-resilient-turquoise/30 focus:outline-none text-lg font-medium placeholder:text-immersive-blue-black/50 transition-all peer"
                        />
                        <span class="material-symbols-outlined text-immersive-blue-black/50 absolute right-4 top-1/2 -translate-y-1/2 text-xl cursor-pointer eye-icon" data-target="pass1" id="eye1">visibility_off</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-immersive-blue-black flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">lock_outline</span>
                        Confirmar contraseña
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            name="pass2"
                            id="pass2"
                            required
                            minlength="8"
                            placeholder="Repite la contraseña"
                            class="w-full h-12 pl-4 pr-12 rounded-xl border-2 border-ice focus:border-resilient-turquoise focus:ring-4 focus:ring-resilient-turquoise/30 focus:outline-none text-lg font-medium placeholder:text-immersive-blue-black/50 transition-all peer"
                        />
                        <span class="material-symbols-outlined text-immersive-blue-black/50 absolute right-4 top-1/2 -translate-y-1/2 text-xl cursor-pointer eye-icon" data-target="pass2" id="eye2">visibility_off</span>
                    </div>
                </div>

                <div class="space-y-2 text-sm text-immersive-blue-black/80 p-3 bg-ice/50 rounded-lg">
                    <p class="font-semibold text-immersive-blue-black">Requisitos de seguridad:</p>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-resilient-turquoise text-base">check_circle</span>
                        <span>Mínimo 8 caracteres de longitud.</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-empowered-yellow text-base">check_circle</span>
                        <span>Combinación de letras, números y símbolos.</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <a href="../index.php" 
                       class="flex-1 w-full flex items-center justify-center h-12 px-6 rounded-xl 
                              bg-ice text-immersive-blue-black font-bold hover:bg-ice/80 transition shadow-sm">
                        <span class="material-symbols-outlined mr-2">arrow_back</span>
                        Volver
                    </a>
                    <button type="submit" 
                            class="flex-1 w-full flex items-center justify-center h-12 px-6 rounded-xl 
                                   bg-sustainable-green text-startup-white font-bold hover:bg-immersive-blue-black transition shadow-md gap-2">
                        <span class="material-symbols-outlined">save</span>
                        Guardar contraseña
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-immersive-blue-black/60 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-resilient-turquoise text-base">verified_user</span>
                Tu información se encriptará de forma segura.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para toggle password visibility
            function togglePasswordVisibility(targetId, iconId) {
                const passwordInput = document.getElementById(targetId);
                const eyeIcon = document.getElementById(iconId);
                
                if (passwordInput && eyeIcon) {
                    eyeIcon.addEventListener('click', function() {
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);
                        
                        // Cambiar icono
                        eyeIcon.textContent = type === 'password' ? 'visibility_off' : 'visibility';
                    });
                }
            }

            // Aplicar a ambos campos
            togglePasswordVisibility('pass1', 'eye1');
            togglePasswordVisibility('pass2', 'eye2');
        });
    </script>
</body>
</html>