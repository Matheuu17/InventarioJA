<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8" />
    <title>Sistema de Inventario - Registrar Salida</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
<?php require_once('../Controlador/controladorProducto.php'); ?>
<body class="font-display bg-background-light dark:bg-background-dark min-h-screen flex items-start sm:items-center justify-center px-4">
<div class="w-full max-w-[640px] my-6">
    <!-- HEADER -->
    <header class="flex items-center justify-between whitespace-nowrap border border-ice/70 dark:border-gray-700 bg-startup-white dark:bg-background-dark rounded-t-xl px-6 py-3 shadow-sm">
        <div class="flex items-center gap-3 text-immersive-blue-black dark:text-startup-white">
            <div class="size-8 flex items-center justify-center rounded-full bg-resilient-turquoise/10 text-resilient-turquoise">
                <span class="material-symbols-outlined text-[26px]">arrow_upward</span>
            </div>
            <div>
                <h2 class="text-lg font-bold leading-tight tracking-[-0.015em]">Registrar salida</h2>
                <p class="text-xs text-immersive-blue-black/60 dark:text-gray-400">
                    Actualiza el stock restando unidades.
                </p>
            </div>
        </div>
    </header>

    <!-- MAIN CARD -->
    <main class="bg-startup-white dark:bg-background-dark rounded-b-xl shadow-sm border-x border-b border-ice/70 dark:border-gray-700">
        <div class="px-6 pt-4 pb-3">
            <p class="text-immersive-blue-black dark:text-startup-white text-2xl sm:text-3xl font-black leading-tight tracking-[-0.03em] mb-1">
                Registrar salida de producto
            </p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Completa el formulario para actualizar el inventario.
            </p>
        </div>

        <div class="px-6 pb-4">
            <div class="flex flex-col gap-5 bg-startup-white dark:bg-background-dark border border-ice dark:border-gray-700 p-5 rounded-xl">

                <!-- Mensaje de Error -->
                <?php if (!empty($datos['error'])) : ?>
                    <div class="flex items-start gap-3 rounded-lg bg-red-100 dark:bg-red-900/30 p-4 border border-red-300 dark:border-red-800">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 flex-shrink-0">error</span>
                        <p class="text-red-700 dark:text-red-300 text-sm font-medium">
                            <?= htmlspecialchars($datos['error']) ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Formulario -->
                <form method="POST" action="../Controlador/controladorProducto.php?accion=salida" class="flex flex-col gap-5">
                    <input type="hidden" name="accion" value="salida" />

                    <!-- Seleccionar Producto -->
                    <label class="flex flex-col w-full gap-1.5">
                        <p class="text-immersive-blue-black dark:text-startup-white text-sm font-medium">Producto</p>
                        <select
                            name="idProducto"
                            id="idProducto"
                            required
                            class="form-select w-full rounded-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-resilient-turquoise/50 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 h-10 px-3 text-sm"
                        >
                            <option value="">Seleccionar un producto...</option>
                            <?php if (!empty($datos['productos'])) : ?>
                                <?php foreach ($datos['productos'] as $prod) : ?>
                                    <option value="<?= htmlspecialchars($prod['idProducto']) ?>" data-stock="<?= htmlspecialchars($prod['stock']) ?>">
                                        <?= htmlspecialchars($prod['nombreP']) ?> (Stock: <?= htmlspecialchars($prod['stock']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </label>

                    <!-- Cantidad y Stock Actual -->
                    <div class="flex flex-col sm:flex-row gap-4 w-full">
                        <label class="flex flex-col flex-1 gap-1.5">
                            <p class="text-immersive-blue-black dark:text-startup-white text-sm font-medium">Cantidad a retirar</p>
                            <input
                                type="number"
                                name="cantidad"
                                id="cantidad"
                                placeholder="0"
                                min="1"
                                required
                                class="form-input w-full rounded-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-resilient-turquoise/50 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 h-10 px-3 text-sm"
                            />
                        </label>
                        <label class="flex flex-col flex-1 gap-1.5">
                            <p class="text-immersive-blue-black dark:text-startup-white text-sm font-medium">Stock actual</p>
                            <input
                                type="text"
                                id="stockActual"
                                disabled
                                class="form-input w-full rounded-lg text-gray-600 dark:text-gray-400 focus:outline-0 focus:ring-0 border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800/50 h-10 px-3 text-sm cursor-not-allowed"
                                value=""
                            />
                        </label>
                    </div>

                    <!-- Botones -->
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
                            <span>Confirmar salida</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <footer class="flex flex-col sm:flex-row items-center justify-between gap-3 px-6 pb-4 pt-3 bg-background-light dark:bg-gray-800/60 rounded-b-xl border-t border-ice/70 dark:border-gray-700">
            <a href="../Controlador/controladorProducto.php?accion=listar"
               class="w-full sm:w-auto flex min-w-[120px] max-w-[220px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-9 px-4 bg-startup-white dark:bg-gray-700 text-immersive-blue-black dark:text-white text-xs sm:text-sm font-bold gap-2 border border-ice dark:border-gray-600 hover:bg-ice/70 dark:hover:bg-gray-600">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span class="truncate">Volver a inventario</span>
            </a>
        </footer>
    </main>
</div>

<script>
    // Actualizar stock cuando se selecciona un producto
    document.getElementById('idProducto').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const stock = selectedOption.getAttribute('data-stock') || '';
        document.getElementById('stockActual').value = stock;
    });

    // Al cargar la página, mostrar el stock del primer producto si hay
    /*window.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('idProducto');
        if (select.options.length > 1) {
            select.selectedIndex = 1;
            select.dispatchEvent(new Event('change'));
        }
    });*/
</script>
</body>
</html>
