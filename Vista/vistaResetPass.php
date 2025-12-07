<?php
// aquí nada de SQL ni $mantenimiento, solo recibes $token
?>
<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "blue-dark": "#22404D",
                        "turquoise": "#00A0AF",
                        "yellow": "#E3E24F",
                        "white": "#FFFFFF",
                        "bg-light": "#f8f9ff",
                        "ice": "#E0F2FE"
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="font-['Inter'] bg-gradient-to-br from-bg-light to-white text-blue-dark min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-2xl bg-turquoise/10 text-turquoise">
                <span class="material-symbols-outlined text-2xl">lock_reset</span>
            </div>
            <h1 class="text-3xl font-bold mb-2">Nueva contraseña</h1>
            <p class="text-blue-dark/70 text-lg">Ingresa tu nueva clave segura</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-ice/50">
            <form method="POST" action="../Controlador/controladorPassword.php?accion=reset" class="space-y-6">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <!-- Nueva contraseña -->
                <div>
                    <label class="block text-sm font-semibold mb-2 text-blue-dark flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">lock</span>
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
                            class="w-full h-14 pl-12 pr-12 rounded-xl border-2 border-ice focus:border-turquoise focus:outline-none text-lg placeholder:text-blue-dark/50 transition-all peer"
                        />
                        <span class="material-symbols-outlined text-blue-dark/50 absolute right-4 top-1/2 -translate-y-1/2 text-xl cursor-pointer eye-icon" data-target="pass1" id="eye1">visibility_off</span>
                    </div>
                </div>

                <!-- Confirmar contraseña -->
                <div>
                    <label class="block text-sm font-semibold mb-2 text-blue-dark flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">lock_outline</span>
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
                            class="w-full h-14 pl-12 pr-12 rounded-xl border-2 border-ice focus:border-turquoise focus:outline-none text-lg placeholder:text-blue-dark/50 transition-all peer"
                        />
                        <span class="material-symbols-outlined text-blue-dark/50 absolute right-4 top-1/2 -translate-y-1/2 text-xl cursor-pointer eye-icon" data-target="pass2" id="eye2">visibility_off</span>
                    </div>
                </div>

                <!-- Requisitos mínimos -->
                <div class="space-y-2 text-sm text-blue-dark/60">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-turquoise"></div>
                        <span>Mínimo 8 caracteres</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-yellow"></div>
                        <span>Letras + números</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <a href="../index.php" class="flex-1 flex items-center justify-center h-12 px-6 rounded-xl bg-ice text-blue-dark font-bold hover:bg-ice/80 transition gap-2">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Volver
                    </a>
                    <button type="submit" class="flex-1 flex items-center justify-center h-12 px-6 rounded-xl bg-turquoise text-white font-bold hover:bg-blue-dark transition gap-2">
                        <span class="material-symbols-outlined">check_circle</span>
                        Guardar contraseña
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-blue-dark/60 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-turquoise">shield</span>
                Tu contraseña será encriptada con AES-256
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
