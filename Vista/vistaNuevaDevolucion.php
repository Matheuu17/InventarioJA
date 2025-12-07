<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../index.php");
    exit();
}

$idProducto = $_GET['id'] ?? null;
?>
<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <title>Nueva devolución</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "immersive-blue-black": "#22404D",
                        "resilient-turquoise": "#00A0AF",
                        "empowered-yellow": "#E3E24F",
                        "sustainable-green": "#008B61",
                        "startup-white": "#FFFFFF",
                        "background-light": "#f6f6f8",
                        "background-dark": "#111621",
                        "ice": "#C3E5F5"
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.5rem", "lg": "0.75rem", "xl": "1rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24;
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark min-h-screen flex items-start sm:items-center justify-center px-4">
<div class="w-full max-w-[640px] my-6">
    <!-- HEADER -->
    <header class="flex items-center justify-between whitespace-nowrap border border-ice/70 dark:border-gray-700 bg-startup-white dark:bg-background-dark rounded-t-xl px-6 py-3 shadow-sm">
        <div class="flex items-center gap-3 text-immersive-blue-black dark:text-startup-white">
            <div class="size-8 flex items-center justify-center rounded-full bg-resilient-turquoise/10 text-resilient-turquoise">
                <span class="material-symbols-outlined text-[26px]">undo</span>
            </div>
            <div>
                <h2 class="text-lg font-bold leading-tight tracking-[-0.015em]">Registrar devolución</h2>
                <p class="text-xs text-immersive-blue-black/60 dark:text-gray-400">
                    Devuelve unidades al inventario.
                </p>
            </div>
        </div>
    </header>

    <!-- MAIN CARD -->
    <main class="bg-startup-white dark:bg-background-dark rounded-b-xl shadow-sm border-x border-b border-ice/70 dark:border-gray-700">
        <div class="px-6 pt-4 pb-3">
            <p class="text-immersive-blue-black dark:text-startup-white text-2xl sm:text-3xl font-black leading-tight tracking-[-0.03em] mb-1">
                Nueva devolución
            </p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Indica cuántas unidades regresan al stock.
            </p>
        </div>

        <div class="px-6 pb-4">
            <form method="POST" action="../Controlador/controladorProducto.php?accion=devolucion"
                  class="flex flex-col gap-5 bg-startup-white dark:bg-background-dark border border-ice dark:border-gray-700 p-5 rounded-xl">
                <input type="hidden" name="idProducto" value="<?= htmlspecialchars($idProducto) ?>">

                <label class="flex flex-col w-full gap-1.5">
                    <p class="text-immersive-blue-black dark:text-startup-white text-sm font-medium">Cantidad a devolver</p>
                    <input
                        type="number"
                        name="cantidad"
                        min="1"
                        required
                        placeholder="0"
                        class="form-input w-full rounded-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-resilient-turquoise/50 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 h-10 px-3 text-sm"
                    />
                </label>

                <div class="flex flex-col-reverse sm:flex-row gap-3 justify-end pt-4 border-t border-ice dark:border-gray-700 mt-2">
                    <a href="../Controlador/controladorProducto.php?accion=listar"
                       class="flex items-center justify-center gap-2 h-10 px-5 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-200 text-sm font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        <span class="material-symbols-outlined text-base">close</span>
                        <span>Cancelar</span>
                    </a>
                    <button
                        type="submit"
                        class="flex items-center justify-center gap-2 h-10 px-5 rounded-full bg-resilient-turquoise text-startup-white text-sm font-bold hover:bg-immersive-blue-black transition">
                        <span class="material-symbols-outlined text-base">check_circle</span>
                        <span>Registrar devolución</span>
                    </button>
                </div>
            </form>
        </div>

        <footer class="flex flex-col sm:flex-row items-center justify-between gap-3 px-6 pb-4 pt-3 bg-background-light dark:bg-gray-800/60 rounded-b-xl border-t border-ice/70 dark:border-gray-700">
            <a href="../Controlador/controladorProducto.php?accion=listar"
               class="w-full sm:w-auto flex min-w-[120px] max-w-[220px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-9 px-4 bg-startup-white dark:bg-gray-700 text-immersive-blue-black dark:text-white text-xs sm:text-sm font-bold gap-2 border border-ice dark:border-gray-600 hover:bg-ice/70 dark:hover:bg-gray-600">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span class="truncate">Volver a inventario</span>
            </a>
        </footer>
    </main>
</div>
</body>
</html>
