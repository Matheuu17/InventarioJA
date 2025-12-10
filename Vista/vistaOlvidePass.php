<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Contraseña</title>
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
        /* Estilo para el fondo claro y el texto oscuro principal */
        .bg-page {
            background-color: #f8f9ff;
        }
    </style>
</head>
<body class="font-display bg-page text-immersive-blue-black min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-2xl bg-resilient-turquoise/10 text-resilient-turquoise">
                <span class="material-symbols-outlined text-3xl">mail</span>
            </div>
            <h1 class="text-3xl font-black mb-2 leading-tight">¿Olvidaste tu contraseña?</h1>
            <p class="text-immersive-blue-black/70 text-base">Ingresa tu correo asociado a la cuenta</p>
        </div>

        <div class="bg-startup-white rounded-2xl shadow-xl p-6 sm:p-8 border border-ice/50">
            <?php 
                // Aquí podrías agregar lógica para mostrar mensajes usando $datos['mensaje'] o $_GET['status']
                /* if (isset($_GET['status']) && $_GET['status'] === 'enviado') {
                    echo '<div class="bg-sustainable-green/10 text-sustainable-green p-3 rounded-lg mb-4 text-sm font-medium border border-sustainable-green/50 flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">check_circle</span>
                            Enlace de recuperación enviado. Revisa tu bandeja.
                          </div>';
                }
                */
            ?>

            <form method="POST" action="../Controlador/controladorPassword.php?accion=solicitar" class="space-y-6">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-immersive-blue-black">
                        Correo electrónico
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined text-resilient-turquoise absolute left-4 top-1/2 -translate-y-1/2 text-xl">
                            alternate_email
                        </span>
                        <input
                            type="email"
                            name="correo"
                            required
                            placeholder="ejemplo@empresa.com"
                            class="w-full h-12 pl-12 pr-4 rounded-xl border-2 border-ice focus:border-resilient-turquoise focus:ring-4 focus:ring-resilient-turquoise/30 focus:outline-none text-lg font-medium placeholder:text-immersive-blue-black/50 transition-all"
                        />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <a href="../index.php" 
                       class="flex-1 w-full flex items-center justify-center h-12 px-6 rounded-xl 
                              bg-ice text-immersive-blue-black font-bold hover:bg-ice/80 transition shadow-sm">
                        <span class="material-symbols-outlined mr-2">arrow_back</span>
                        Volver al inicio
                    </a>
                    <button type="submit" 
                            class="flex-1 w-full flex items-center justify-center h-12 px-6 rounded-xl 
                                   bg-resilient-turquoise text-startup-white font-bold hover:bg-immersive-blue-black transition shadow-md gap-2">
                        <span class="material-symbols-outlined">send</span>
                        Enviar enlace
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-immersive-blue-black/60 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-resilient-turquoise text-base">info</span>
                Si el correo no llega en 5 minutos, revisa tu carpeta de spam o contacta al administrador.
            </p>
        </div>
    </div>
</body>
</html>