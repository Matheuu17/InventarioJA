<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../index.php");
    exit();
}

$editingId = isset($_GET['editar']) ? $_GET['editar'] : null;
?>
<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sistema de Inventario</title>
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
<body class="font-display bg-background-light dark:bg-background-dark text-immersive-blue-black dark:text-startup-white min-h-screen">
<div class="flex min-h-screen w-full justify-center">
    <div class="flex flex-col max-w-[1200px] w-full px-4 sm:px-8 md:px-12 lg:px-20 xl:px-24 my-4">

        <!-- HEADER -->
        <header class="flex items-center justify-between whitespace-nowrap border border-ice/70 dark:border-gray-700 bg-startup-white dark:bg-background-dark rounded-t-xl px-6 py-3 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="size-8 flex items-center justify-center rounded-full bg-resilient-turquoise/10 text-resilient-turquoise">
                    <span class="material-symbols-outlined text-[28px]">inventory_2</span>
                </div>
                <div>
                    <h2 class="text-immersive-blue-black dark:text-startup-white text-lg font-bold leading-tight tracking-[-0.015em]">
                        Sistema de Inventario
                    </h2>
                    <p class="text-xs text-immersive-blue-black/60 dark:text-gray-400">
                        Sesión de <?= htmlspecialchars($_SESSION['nombreU'] ?? 'Usuario') ?>
                    </p>
                </div>
            </div>
            <span class="inline-flex items-center gap-2 rounded-full bg-empowered-yellow/20 px-3 py-1 text-xs font-semibold text-immersive-blue-black">
                <span class="w-2 h-2 rounded-full bg-empowered-yellow"></span>
                Inventario activo
            </span>
        </header>

        <!-- MAIN CARD -->
        <main class="bg-startup-white dark:bg-background-dark flex-grow rounded-b-xl shadow-sm border-x border-b border-ice/70 dark:border-gray-700 min-h-[70vh] flex flex-col">
            <!-- Barra superior -->
            <div class="flex flex-wrap justify-between gap-4 px-6 pt-4 pb-3 border-b border-ice/70 dark:border-gray-800">
                <div class="flex min-w-72 flex-col gap-1.5">
                    <p class="text-immersive-blue-black dark:text-startup-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">
                        Inventario de productos
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">
                        Gestiona y visualiza todos los productos de tu inventario.
                    </p>
                </div>
                <a href="../Controlador/controladorProducto.php?accion=agregar"
                   class="flex min-w-[140px] max-w-[260px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 md:h-11 px-5 bg-resilient-turquoise text-startup-white text-sm font-bold gap-2 shadow-sm hover:bg-immersive-blue-black transition">
                    <span class="material-symbols-outlined">add_circle</span>
                    <span class="truncate">Nuevo producto</span>
                </a>
            </div>

            <!-- Tabla -->
            <div class="px-6 py-3 flex-1">
                <div class="flex overflow-hidden rounded-xl border border-ice dark:border-gray-700 bg-startup-white dark:bg-background-dark/80">
                    <table class="w-full flex-1">
                        <thead>
                        <tr class="bg-ice/60 dark:bg-gray-800">
                            <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-100 text-xs md:text-sm font-semibold uppercase tracking-wide">
                                Nombre producto
                            </th>
                            <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-100 text-xs md:text-sm font-semibold uppercase tracking-wide">
                                ID producto
                            </th>
                            <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-100 text-xs md:text-sm font-semibold uppercase tracking-wide">
                                Descripción
                            </th>
                            <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-100 text-xs md:text-sm font-semibold uppercase tracking-wide">
                                Stock
                            </th>
                            <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-100 text-xs md:text-sm font-semibold uppercase tracking-wide">
                                Fecha ingreso
                            </th>
                            <th class="px-4 py-3 text-left text-immersive-blue-black dark:text-gray-100 text-xs md:text-sm font-semibold uppercase tracking-wide">
                                Acciones
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($datos['productos'])) : ?>
                            <?php foreach ($datos['productos'] as $prod) : ?>
                                <tr class="border-t border-t-ice dark:border-t-gray-700 hover:bg-ice/40 dark:hover:bg-gray-800 transition">
                                    <?php if ($editingId == $prod['idProducto']) : ?>
                                        <!-- MODO EDICIÓN EN LÍNEA -->
                                        <form method="POST" action="../Controlador/controladorProducto.php?accion=editar" class="contents">
                                            <td class="px-4 py-3 text-immersive-blue-black dark:text-startup-white text-sm">
                                                <input type="hidden" name="idProducto" value="<?= htmlspecialchars($prod['idProducto']) ?>" />
                                                <input type="hidden" name="accion" value="editar" />
                                                <input type="text" name="nombreP"
                                                       value="<?= htmlspecialchars($prod['nombreP']) ?>"
                                                       class="form-input rounded-lg w-full border border-ice dark:border-gray-600 bg-startup-white dark:bg-background-dark text-sm"
                                                       required />
                                            </td>
                                            <td class="px-4 py-3 text-immersive-blue-black dark:text-startup-white text-sm">
                                                <?= htmlspecialchars($prod['idProducto']) ?>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm">
                                                <input type="text" name="descripcionP"
                                                       value="<?= htmlspecialchars($prod['descripcionP']) ?>"
                                                       class="form-input rounded-lg w-full border border-ice dark:border-gray-600 bg-startup-white dark:bg-background-dark text-sm" />
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <input type="number" name="stock"
                                                       value="<?= htmlspecialchars($prod['stock']) ?>" min="1"
                                                       class="form-input rounded-lg w-full border border-ice dark:border-gray-600 bg-startup-white dark:bg-background-dark text-sm"
                                                       required />
                                            </td>
                                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm">
                                                <?= htmlspecialchars($prod['fechaI']) ?>
                                            </td>
                                            <td class="px-4 py-3 flex flex-wrap gap-2">
                                                <button type="submit"
                                                        class="bg-resilient-turquoise text-startup-white px-4 py-2 rounded-full hover:bg-immersive-blue-black text-xs font-bold">
                                                    Guardar
                                                </button>
                                                <a href="../Controlador/controladorProducto.php?accion=listar"
                                                   class="bg-ice text-immersive-blue-black px-4 py-2 rounded-full hover:bg-ice/80 text-xs font-bold">
                                                    Cancelar
                                                </a>
                                            </td>
                                        </form>
                                    <?php else : ?>
                                        <!-- MODO VISUALIZACIÓN -->
                                        <td class="px-4 py-3 text-immersive-blue-black dark:text-startup-white text-sm">
                                            <?= htmlspecialchars($prod['nombreP']) ?>
                                        </td>
                                        <td class="px-4 py-3 text-immersive-blue-black dark:text-startup-white text-sm">
                                            <?= htmlspecialchars($prod['idProducto']) ?>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm">
                                            <?= htmlspecialchars($prod['descripcionP']) ?>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="inline-flex items-center justify-center rounded-full h-8 px-4
                                                        <?= $prod['stock'] > 0
                                                            ? 'bg-sustainable-green/10 text-sustainable-green'
                                                            : 'bg-red-100 text-red-700' ?>
                                                        text-sm font-medium">
                                                <?= htmlspecialchars($prod['stock']) ?>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm">
                                            <?= htmlspecialchars($prod['fechaI']) ?>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm font-bold">
                                            <div class="flex gap-1 md:gap-2">
                                                <a href="../Controlador/controladorProducto.php?accion=listar&editar=<?= urlencode($prod['idProducto']) ?>"
                                                   class="p-2 rounded-full hover:bg-ice dark:hover:bg-gray-800"
                                                   title="Editar">
                                                    <span class="material-symbols-outlined text-base">edit</span>
                                                </a>
                                                <a href="../Controlador/controladorProducto.php?accion=eliminar&id=<?= urlencode($prod['idProducto']) ?>"
                                                   class="p-2 rounded-full hover:bg-ice dark:hover:bg-gray-800"
                                                   onclick="return confirm('¿Eliminar este producto?');"
                                                   title="Eliminar">
                                                    <span class="material-symbols-outlined text-base">delete</span>
                                                </a>
                                                <a href="../Controlador/controladorProducto.php?accion=devolucion&id=<?= urlencode($prod['idProducto']) ?>"
                                                   class="p-2 rounded-full hover:bg-ice dark:hover:bg-gray-800"
                                                   title="Devolver">
                                                    <span class="material-symbols-outlined text-base">undo</span>
                                                </a>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan='6' class='p-4 text-center text-gray-500 dark:text-gray-300'>
                                    No hay datos para mostrar.
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer buttons -->
            <footer class="mt-auto flex flex-col sm:flex-row items-center justify-center gap-3 px-6 pb-4 pt-3 bg-background-light dark:bg-gray-800/60 rounded-b-xl border-t border-ice/70 dark:border-gray-700">
                <a href="../Controlador/controladorProducto.php?accion=agregar"
                   class="w-full sm:w-auto flex min-w-[120px] max-w-[240px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-resilient-turquoise text-startup-white text-sm font-bold gap-2 hover:bg-immersive-blue-black">
                    <span class="material-symbols-outlined text-base">add_circle</span>
                    <span class="truncate">Nuevo producto</span>
                </a>
                <a href="../Controlador/controladorProducto.php?accion=salida"
                   class="w-full sm:w-auto flex min-w-[120px] max-w-[240px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-startup-white dark:bg-gray-700 text-immersive-blue-black dark:text-gray-200 border border-ice dark:border-gray-600 text-sm font-bold gap-2 hover:bg-ice/70 dark:hover:bg-gray-600">
                    <span class="material-symbols-outlined text-base">arrow_upward</span>
                    <span class="truncate">Nueva salida</span>
                </a>
                <a href="../Controlador/controladorProducto.php?accion=movimientos"
                   class="w-full sm:w-auto flex min-w-[120px] max-w-[240px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-startup-white dark:bg-gray-700 text-immersive-blue-black dark:text-gray-200 border border-ice dark:border-gray-600 text-sm font-bold gap-2 hover:bg-ice/70 dark:hover:bg-gray-600">
                    <span class="material-symbols-outlined text-base">sync_alt</span>
                    <span class="truncate">Ver movimientos</span>
                </a>
                <div class="hidden sm:block flex-grow"></div>
                <a href="../Controlador/controladorCerrarSesion.php"
                   class="w-full sm:w-auto flex min-w-[120px] max-w-[240px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-immersive-blue-black text-startup-white text-sm font-bold gap-2 hover:bg-black">
                    <span class="material-symbols-outlined text-base">logout</span>
                    <span class="truncate">Cerrar sesión</span>
                </a>
            </footer>
        </main>
    </div>
</div>
</body>
</html>
