<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
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
                <span class="material-symbols-outlined text-2xl">mail</span>
            </div>
            <h1 class="text-3xl font-bold mb-2">Recuperar contraseña</h1>
            <p class="text-blue-dark/70 text-lg">Ingresa tu correo corporativo</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-ice/50">
            <form method="POST" action="../Controlador/controladorPassword.php?accion=solicitar" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold mb-2 text-blue-dark">Correo corporativo</label>
                    <div class="relative">
                        <span class="material-symbols-outlined text-blue-dark/50 absolute left-4 top-1/2 -translate-y-1/2 text-xl">
                            alternate_email
                        </span>
                        <input
                            type="email"
                            name="correo"
                            required
                            placeholder="ejemplo@empresa.com"
                            class="w-full h-14 pl-12 pr-4 rounded-xl border-2 border-ice focus:border-turquoise focus:outline-none text-lg placeholder:text-blue-dark/50 transition-all"
                        />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <a href="../index.php" class="flex-1 flex items-center justify-center h-12 px-6 rounded-xl bg-ice text-blue-dark font-bold hover:bg-ice/80 transition">
                        <span class="material-symbols-outlined mr-2">arrow_back</span>
                        Volver
                    </a>
                    <button type="submit" class="flex-1 flex items-center justify-center h-12 px-6 rounded-xl bg-turquoise text-white font-bold hover:bg-blue-dark transition gap-2">
                        <span class="material-symbols-outlined">send</span>
                        Enviar enlace
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-blue-dark/60 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-turquoise">info</span>
                Revisa tu carpeta de spam si no ves el correo
            </p>
        </div>
    </div>
</body>
</html>
