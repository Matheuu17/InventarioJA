<?php
// Incluye el controlador para acceder a los datos.
// $datos['productos'], $datos['usuarios'], y $datos['movimientos'] deben estar definidos aquí.
require_once('../Controlador/controladorProducto.php');

// --- INICIO DE LA CORRECCIÓN DE FILTROS (LÓGICA ORIGINAL DEL USUARIO) ---
// 1. Obtener una copia de los parámetros GET.
$filtered_get = $_GET;

// 2. Eliminar el parámetro 'accion' de los filtros para que no entre en la URL de exportación,
//    ya que la acción 'exportar' se añade explícitamente.
unset($filtered_get['accion']); 

// 3. Codificación de todos los parámetros de filtro restantes para usarlos en el enlace de exportación.
//    array_filter() elimina los valores vacíos o nulos.
$filter_query = http_build_query(array_filter($filtered_get));
// --- FIN DE LA CORRECCIÓN DE FILTROS ---

// Codificación individual de fechas (originalmente proporcionado por el usuario)
// Aunque filter_query ya tiene esto, se deja aquí por si la lógica de control lo necesita.
$fi = urlencode($_GET['fecha_inicio'] ?? '');
$ff = urlencode($_GET['fecha_fin'] ?? '');

// Nuevos parámetros de filtro (producto y usuario)
$ip = urlencode($_GET['id_producto'] ?? '');
$iu = urlencode($_GET['id_usuario'] ?? '');

// Variables para el valor actual del filtro (para mantener el estado en el formulario)
$current_id_producto = $_GET['id_producto'] ?? '';
$current_id_usuario = $_GET['id_usuario'] ?? '';
$current_fecha_inicio = $_GET['fecha_inicio'] ?? '';
$current_fecha_fin = $_GET['fecha_fin'] ?? '';
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

    <main class="bg-startup-white dark:bg-background-dark rounded-b-xl shadow-sm border-x border-b border-ice/70 dark:border-gray-700 min-h-[70vh] flex flex-col">
        <div class="flex flex-col gap-5 p-6 border-b border-ice/70 dark:border-gray-800">
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

            <form method="GET" action="../Controlador/controladorProducto.php" class="flex flex-col gap-4">
                <input type="hidden" name="accion" value="movimientos" />

                <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                    
                    <div class="flex flex-col gap-1.5 col-span-2 sm:col-span-1">
                        <label for="id_producto" class="text-immersive-blue-black dark:text-startup-white text-xs font-semibold uppercase">Producto</label>
                        <select name="id_producto" id="id_producto"
                                class="form-select rounded-lg px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-startup-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">-- Todos --</option>
                            <?php foreach ($datos['productos'] as $producto): ?>
                                <?php $selected = $current_id_producto == $producto['idProducto'] ? 'selected' : ''; ?>
                                <option value="<?= htmlspecialchars($producto['idProducto']) ?>" <?= $selected ?>>
                                    <?= htmlspecialchars($producto['nombreP']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1.5 col-span-2 sm:col-span-1">
                        <label for="id_usuario" class="text-immersive-blue-black dark:text-startup-white text-xs font-semibold uppercase">Usuario</label>
                        <select name="id_usuario" id="id_usuario"
                                class="form-select rounded-lg px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-startup-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">-- Todos --</option>
                            <?php foreach ($datos['usuarios'] as $usuario): ?>
                                <?php 
                                // Se mantiene la lógica de omitir al usuario 'Admin' si no es necesario filtrar por él.
                                if (($usuario['nombreU'] ?? '') !== 'Admin'): 
                                ?>
                                    <?php $selected = $current_id_usuario == $usuario['idUsuario'] ? 'selected' : ''; ?>
                                    <option value="<?= htmlspecialchars($usuario['idUsuario']) ?>" <?= $selected ?>>
                                        <?= htmlspecialchars($usuario['nombreU']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1.5 col-span-1">
                        <label class="text-immersive-blue-black dark:text-startup-white text-xs font-semibold uppercase">Desde</label>
                        <input type="date" name="fecha_inicio"
                               value="<?= htmlspecialchars($current_fecha_inicio) ?>"
                               class="form-input rounded-lg px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-startup-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>

                    <div class="flex flex-col gap-1.5 col-span-1">
                        <label class="text-immersive-blue-black dark:text-startup-white text-xs font-semibold uppercase">Hasta</label>
                        <input type="date" name="fecha_fin"
                               value="<?= htmlspecialchars($current_fecha_fin) ?>"
                               class="form-input rounded-lg px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-startup-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div class="col-span-2 lg:col-span-1 self-end">
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 rounded-lg h-10 px-5 bg-resilient-turquoise text-startup-white text-sm font-bold hover:bg-immersive-blue-black transition shadow-md">
                            <span class="material-symbols-outlined text-base">search</span>
                            <span>Filtrar</span>
                        </button>
                    </div>

                </div>
            </form>

            <div class="flex flex-col sm:flex-row gap-3 flex-wrap pt-4 border-t border-ice/70 dark:border-gray-800">
                <a href="../Controlador/controladorProducto.php?accion=listar"
                   class="flex items-center justify-center gap-2 rounded-full h-10 px-4 bg-startup-white dark:bg-gray-700 text-immersive-blue-black dark:text-white text-sm font-bold hover:bg-ice/70 dark:hover:bg-gray-600 border border-ice dark:border-gray-600 transition shadow-sm">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    <span>Volver a inventario</span>
                </a>
                
                <a href="../Controlador/controladorProducto.php?accion=exportar&<?= htmlspecialchars($filter_query) ?>"
                   class="flex items-center justify-center gap-2 rounded-full h-10 px-4 bg-sustainable-green text-startup-white text-sm font-bold hover:bg-immersive-blue-black transition shadow-sm">
                    <span class="material-symbols-outlined text-base">download</span>
                    <span>Exportar CSV</span>
                </a>
            </div>
        </div>

        <div class="px-6 py-3 flex-1 overflow-x-auto">
            <div class="flex overflow-hidden rounded-xl border border-ice dark:border-gray-700">
                <table class="min-w-[800px] table-auto w-full"> 
                    <thead class="bg-ice/60 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide whitespace-nowrap">ID movimiento</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide whitespace-nowrap">Producto</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide whitespace-nowrap">Tipo</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide whitespace-nowrap">Cantidad</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide whitespace-nowrap">Usuario</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide whitespace-nowrap">Fecha y hora</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide whitespace-nowrap">ID P.</th>
                        <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-200 text-xs md:text-sm font-semibold leading-normal uppercase tracking-wide whitespace-nowrap hidden">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($datos['movimientos'])) : ?>
                        <?php foreach ($datos['movimientos'] as $fila) : ?>
                            <tr class="border-t border-t-ice dark:border-t-gray-700 hover:bg-ice/40 dark:hover:bg-gray-800 transition">
                                <td class="px-4 py-3 text-immersive-blue-black dark:text-white text-sm font-mono whitespace-nowrap">
                                    <?= htmlspecialchars($fila['idMovimiento']) ?>
                                </td>
                                <td class="px-4 py-3 text-immersive-blue-black dark:text-white text-sm font-medium whitespace-nowrap">
                                    <?= htmlspecialchars($fila['nombreP']) ?>
                                </td>

                                <td class="px-4 py-3 text-sm whitespace-nowrap">
                                    <?php 
                                        $tipo = strtolower($fila['tipo']);
                                        $badgeStyle = '';
                                        $icon = '';

                                        if ($tipo === 'entrada') {
                                            $badgeStyle = 'bg-sustainable-green/10 dark:bg-green-900/50 text-sustainable-green dark:text-green-300';
                                            $icon = 'arrow_upward';
                                        } elseif ($tipo === 'devolucion') {
                                            $badgeStyle = 'bg-resilient-turquoise/10 dark:bg-blue-900/50 text-resilient-turquoise dark:text-blue-300';
                                            $icon = 'undo';
                                        } else { /* salida */
                                            $badgeStyle = 'bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300';
                                            $icon = 'arrow_downward';
                                        }
                                    ?>
                                    <div class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold <?= $badgeStyle ?>">
                                        <span class="material-symbols-outlined text-base"><?= $icon ?></span>
                                        <span><?= ucfirst($tipo) ?></span>
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-sm font-bold whitespace-nowrap
                                    <?= $tipo === 'salida' ? 'text-red-700 dark:text-red-400' : 'text-sustainable-green dark:text-green-400' ?>">
                                    <?= $tipo === 'salida' ? '-' : '+' ?>
                                    <?= htmlspecialchars($fila['cantidad']) ?>
                                </td>

                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm whitespace-nowrap">
                                    <?= htmlspecialchars($fila['nombreU']) ?>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm whitespace-nowrap">
                                    <?= htmlspecialchars($fila['fechaM']) ?>
                                </td>
                                <td class="px-4 py-3 text-gray-400 dark:text-gray-500 text-xs whitespace-nowrap">
                                     <?= htmlspecialchars($fila['idProducto'] ?? 'N/A') ?>
                                </td>
                                </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan='7' class='p-8 text-center text-gray-500 dark:text-gray-300'>
                                No se encontraron movimientos con los filtros aplicados.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>