<?php
// Incluye el controlador para acceder a los datos.
// $datos['productos'], $datos['usuarios'], y $datos['movimientos'] deben estar definidos aquí.
require_once('../Controlador/controladorProducto.php');

// --- INICIO DE LA CORRECCIÓN ---
// 1. Obtener una copia de los parámetros GET.
$filtered_get = $_GET;

// 2. Eliminar el parámetro 'accion' de los filtros para que no entre en la URL de exportación,
//    ya que la acción 'exportar' se añade explícitamente.
unset($filtered_get['accion']); 

// 3. Codificación de todos los parámetros de filtro restantes para usarlos en el enlace de exportación.
//    array_filter() elimina los valores vacíos o nulos.
$filter_query = http_build_query(array_filter($filtered_get));
// --- FIN DE LA CORRECCIÓN ---

// Codificación individual de fechas (originalmente proporcionado por el usuario)
$fi = urlencode($_GET['fecha_inicio'] ?? '');
$ff = urlencode($_GET['fecha_fin'] ?? '');

// Nuevos parámetros de filtro (producto y usuario)
$ip = urlencode($_GET['id_producto'] ?? '');
$iu = urlencode($_GET['id_usuario'] ?? '');
?>
<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Registro de Movimientos de Inventario</title>
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
<body class="font-display bg-background-light dark:bg-background-dark min-h-screen flex items-start justify-center px-4">
<div class="w-full max-w-[1200px] my-4">
    <!-- HEADER -->
    <header class="flex items-center justify-between whitespace-nowrap border border-ice/70 dark:border-gray-700 bg-startup-white dark:bg-background-dark rounded-t-xl px-6 py-3 shadow-sm">
        <div class="flex items-center gap-3 text-immersive-blue-black dark:text-startup-white">
            <div class="size-8 flex items-center justify-center rounded-full bg-resilient-turquoise/10 text-resilient-turquoise">
                <span class="material-symbols-outlined text-[26px]">sync_alt</span>
            </div>
            <div>
                <h2 class="text-lg font-bold leading-tight tracking-[-0.015em]">Movimientos de inventario</h2>
                <p class="text-xs text-immersive-blue-black/60 dark:text-gray-400">
                    Historial de entradas, salidas y devoluciones.
                </p>
            </div>
        </div>
    </header>

    <!-- MAIN CARD -->
    <main class="bg-startup-white dark:bg-background-dark rounded-b-xl shadow-sm border-x border-b border-ice/70 dark:border-gray-700 min-h-[70vh] flex flex-col">
        <div class="flex flex-col gap-5 p-6 border-b border-ice/70 dark:border-gray-800">
            <!-- Título y Descripción -->
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="flex flex-col gap-1.5">
                    <p class="text-immersive-blue-black dark:text-startup-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">
                        Registro de movimientos
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">
                        Filtra por fecha, producto, usuario y revisa el detalle de cada operación.
                    </p>
                </div>
            </div>

            <!-- Filtros -->
            <form method="GET" action="../Controlador/controladorProducto.php" class="flex flex-col md:flex-row gap-4 items-end flex-wrap">
                <input type="hidden" name="accion" value="movimientos" />

                <!-- Filtro por Producto -->
                <div class="flex flex-col gap-1.5 min-w-[180px] flex-grow">
                    <label for="id_producto" class="text-immersive-blue-black dark:text-startup-white text-sm font-medium">Producto</label>
                    <select name="id_producto" id="id_producto"
                            class="form-select rounded-lg px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-startup-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">-- Todos --</option>
                        <?php foreach ($datos['productos'] as $producto): ?>
                            <?php $selected = ($_GET['id_producto'] ?? '') == $producto['idProducto'] ? 'selected' : ''; ?>
                            <option value="<?= htmlspecialchars($producto['idProducto']) ?>" <?= $selected ?>>
                                <?= htmlspecialchars($producto['nombreP']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Filtro por Usuario -->
                <div class="flex flex-col gap-1.5 min-w-[180px] flex-grow">
                    <label for="id_usuario" class="text-immersive-blue-black dark:text-startup-white text-sm font-medium">Usuario</label>
                    <select name="id_usuario" id="id_usuario"
                            class="form-select rounded-lg px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-startup-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">-- Todos --</option>
                        <?php foreach ($datos['usuarios'] as $usuario): ?>
                            <?php 
                            // 💡 CAMBIO CLAVE: Comprobar si el nombre de usuario NO es 'admin'
                            // Ajusta 'nombreU' si el campo es diferente (ej: 'nombre_usuario')
                            if ($usuario['nombreU'] !== 'Admin'): 
                            ?>
                                <?php $selected = ($_GET['id_usuario'] ?? '') == $usuario['idUsuario'] ? 'selected' : ''; ?>
                                <option value="<?= htmlspecialchars($usuario['idUsuario']) ?>" <?= $selected ?>>
                                    <?= htmlspecialchars($usuario['nombreU']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex flex-col gap-1.5 min-w-[150px]">
                    <label class="text-immersive-blue-black dark:text-startup-white text-sm font-medium">Desde</label>
                    <input type="date" name="fecha_inicio"
                           value="<?= htmlspecialchars($_GET['fecha_inicio'] ?? '') ?>"
                           class="form-input rounded-lg px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-startup-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>

                <div class="flex flex-col gap-1.5 min-w-[150px]">
                    <label class="text-immersive-blue-black dark:text-startup-white text-sm font-medium">Hasta</label>
                    <input type="date" name="fecha_fin"
                           value="<?= htmlspecialchars($_GET['fecha_fin'] ?? '') ?>"
                           class="form-input rounded-lg px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-startup-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>

                <button type="submit"
                        class="flex items-center justify-center gap-2 rounded-full h-10 px-5 bg-resilient-turquoise text-startup-white text-sm font-bold hover:bg-immersive-blue-black transition self-start md:self-end mt-4 sm:mt-0">
                    <span class="material-symbols-outlined text-base">search</span>
                    <span>Filtrar</span>
                </button>
            </form>

            <!-- Botones de Acción (Volver y Exportar) -->
            <div class="flex flex-col sm:flex-row gap-3 flex-wrap pt-4 border-t border-ice/70 dark:border-gray-800">
                <a href="../Controlador/controladorProducto.php?accion=listar"
                   class="flex items-center justify-center gap-2 rounded-full h-10 px-4 bg-startup-white dark:bg-gray-700 text-immersive-blue-black dark:text-white text-sm font-bold hover:bg-ice/70 dark:hover:bg-gray-600 border border-ice dark:border-gray-600 transition">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    <span>Volver a inventario</span>
                </a>
                
                <!-- Enlace de Exportar: Pasa todos los parámetros GET activos -->
                <a href="../Controlador/controladorProducto.php?accion=exportar&<?= htmlspecialchars($filter_query) ?>"
                   class="flex items-center justify-center gap-2 rounded-full h-10 px-4 bg-resilient-turquoise text-startup-white text-sm font-bold hover:bg-immersive-blue-black transition">
                    <span class="material-symbols-outlined text-base">download</span>
                    <span>Exportar CSV</span>
                </a>
            </div>
        </div>

        <!-- Tabla de movimientos -->
        <div class="px-6 py-3 flex-1 overflow-auto">
            <div class="flex overflow-hidden rounded-xl border border-ice dark:border-gray-700">
                <table class="min-w-full table-auto">
                    <thead class="bg-ice/60 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide">ID movimiento</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide">ID producto</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide">Producto</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide">Tipo</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide">Cantidad</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide">Usuario</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide">Fecha y hora</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($datos['movimientos'])) : ?>
                        <?php foreach ($datos['movimientos'] as $fila) : ?>
                            <tr class="border-t border-t-ice dark:border-t-gray-700 hover:bg-ice/40 dark:hover:bg-gray-800 transition">
                                <td class="px-4 py-3 text-immersive-blue-black dark:text-white text-sm font-mono whitespace-nowrap">
                                    <?= htmlspecialchars($fila['idMovimiento']) ?>
                                </td>
                                <td class="px-4 py-3 text-immersive-blue-black dark:text-white text-sm whitespace-nowrap">
                                    <?= htmlspecialchars($fila['idProducto'] ?? 'N/A') ?>
                                </td>
                                <td class="px-4 py-3 text-immersive-blue-black dark:text-white text-sm font-medium whitespace-nowrap">
                                    <?= htmlspecialchars($fila['nombreP']) ?>
                                </td>

                                <!-- Tipo -->
                                <td class="px-4 py-3 text-sm whitespace-nowrap">
                                    <?php if ($fila['tipo'] === 'entrada') : ?>
                                        <div class="inline-flex items-center gap-1.5 rounded-full bg-green-100 dark:bg-green-900/50 px-3 py-1 text-sm font-medium text-green-700 dark:text-green-300">
                                            <span class="material-symbols-outlined text-base">arrow_upward</span>
                                            <span>Entrada</span>
                                        </div>
                                    <?php elseif ($fila['tipo'] === 'devolucion') : ?>
                                        <div class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 dark:bg-blue-900/50 px-3 py-1 text-sm font-medium text-blue-700 dark:text-blue-300">
                                            <span class="material-symbols-outlined text-base">undo</span>
                                            <span>Devolución</span>
                                        </div>
                                    <?php else : /* salida */ ?>
                                        <div class="inline-flex items-center gap-1.5 rounded-full bg-red-100 dark:bg-red-900/50 px-3 py-1 text-sm font-medium text-red-700 dark:text-red-300">
                                            <span class="material-symbols-outlined text-base">arrow_downward</span>
                                            <span>Salida</span>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Cantidad -->
                                <td class="px-4 py-3 text-sm font-medium whitespace-nowrap
                                    <?= $fila['tipo'] === 'salida' ? 'text-red-600 dark:text-red-400'
                                         : 'text-green-600 dark:text-green-400' ?>">
                                    <?= $fila['tipo'] === 'salida' ? '-' : '+' ?>
                                    <?= htmlspecialchars($fila['cantidad']) ?>
                                </td>

                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm whitespace-nowrap">
                                    <?= htmlspecialchars($fila['nombreU']) ?>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm whitespace-nowrap">
                                    <?= htmlspecialchars($fila['fechaM']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan='7' class='p-4 text-center text-gray-500 dark:text-gray-300'>
                                No se encontraron movimientos con los filtros aplicados.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer buttons (ya estaban correctos, solo se ajustó el enlace de exportación) -->
        <footer class="flex flex-col sm:flex-row items-center justify-between gap-3 px-6 pb-4 pt-3 bg-background-light dark:bg-gray-800/60 rounded-b-xl border-t border-ice/70 dark:border-gray-700">
            <a href="../Controlador/controladorProducto.php?accion=listar"
               class="w-full sm:w-auto flex min-w-[120px] max-w-[220px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-9 px-4 bg-startup-white dark:bg-gray-700 text-immersive-blue-black dark:text-white text-xs sm:text-sm font-bold gap-2 border border-ice dark:border-gray-600 hover:bg-ice/70 dark:hover:bg-gray-600">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span class="truncate">Volver a inventario</span>
            </a>
            <a href="../Controlador/controladorProducto.php?accion=exportar&<?= htmlspecialchars($filter_query) ?>"
               class="w-full sm:w-auto flex min-w-[120px] max-w-[220px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-9 px-4 bg-resilient-turquoise text-startup-white text-xs sm:text-sm font-bold gap-2 hover:bg-immersive-blue-black">
                <span class="material-symbols-outlined text-base">download</span>
                <span class="truncate">Exportar a CSV</span>
            </a>
            
        </footer>
    </main>
</div>
</body>
</html>