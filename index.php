<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Iniciar Sesión - Sistema de Inventario</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
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
                    borderRadius: { "DEFAULT": "0.5rem", "lg": "0.75rem", "xl": "1rem", "full": "9999px" }
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
            'opsz' 24
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-immersive-blue-black dark:text-startup-white">
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
    <div class="layout-container flex h-full grow flex-col">
        <main class="flex flex-1">
            <div class="flex flex-1 flex-col items-center justify-center">
                <div class="w-full max-w-6xl p-4 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 rounded-xl shadow-lg overflow-hidden bg-startup-white dark:bg-background-dark dark:border dark:border-white/10">

                        <!-- Left illustration block -->
                        <div class="relative hidden md:flex flex-col justify-between p-10 bg-ice/60 dark:bg-black/20">
                            <div class="z-10">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-resilient-turquoise text-3xl">inventory_2</span>
                                    <h2 class="font-bold text-2xl text-immersive-blue-black dark:text-startup-white">Sistema de Inventario</h2>
                                </div>
                                <p class="text-lg mt-4 text-immersive-blue-black/70 dark:text-gray-300">
                                    Control total de tu inventario.
                                </p>
                            </div>
                            <div class="w-full h-full flex items-center justify-center">
                                <div class="w-full aspect-square bg-center bg-no-repeat bg-contain"
                                     style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuADGj51DgIAOHnNbS67CR2hmXwoL53xiq6dM4Lg4gHabL4AuASpor0O3N31ienw8vNNNSwUdjxJw0Ch_whe7uM9DkAEc-C9o-w4yv_AlX5AO6C4evI3jTQ9yoy5c1R3rUMw2z1vUgmrsPc-BRfkJy6wZQUdUnK2Z3On9Qliya5stehoQUfluxuxAQcNOk9HNbq4RF1ZrgHfOjpRvDdQeC1HteYJFi8k_w_bfD-lbAYjknEWGaU0jc2V2ltDFpAkaO93ENuF2uq1VLo");'></div>
                            </div>
                        </div>

                        <!-- Right form block -->
                        <div class="flex flex-col justify-center p-8 sm:p-12">
                            <h1 class="text-immersive-blue-black dark:text-startup-white tracking-tight text-[32px] font-bold leading-tight text-left">
                                Bienvenido de nuevo
                            </h1>
                            <p class="text-immersive-blue-black/70 dark:text-gray-300 text-base font-normal leading-normal pt-1">
                                Accede a tu cuenta para gestionar tu inventario.
                            </p>
                            <form action="Controlador/procesar_login.php" method="post" class="mt-8 flex flex-col gap-6">
                                <!-- Usuario -->
                                <div class="flex flex-col w-full">
                                    <label class="text-immersive-blue-black dark:text-startup-white text-base font-medium leading-normal pb-2" for="nombreU">
                                        Usuario
                                    </label>
                                    <div class="relative">
                                        <span class="material-symbols-outlined text-immersive-blue-black/60 absolute left-3 top-1/2 -translate-y-1/2">person</span>
                                        <input
                                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-immersive-blue-black dark:text-startup-white dark:bg-background-dark focus:outline-0 focus:ring-2 focus:ring-resilient-turquoise/50 border border-ice dark:border-white/20 bg-startup-white focus:border-resilient-turquoise h-14 placeholder:text-immersive-blue-black/60 pl-11 pr-4 py-[15px] text-base font-normal leading-normal"
                                            type="text" id="nombreU" name="nombreU" required placeholder="Ingresa tu usuario"/>
                                    </div>
                                </div>
                                <!-- Contraseña -->
                                <div class="flex flex-col w-full">
                                    <label class="text-immersive-blue-black dark:text-startup-white text-base font-medium leading-normal pb-2" for="pass">
                                        Contraseña
                                    </label>
                                    <div class="relative flex w-full flex-1 items-stretch">
                                        <span class="material-symbols-outlined text-immersive-blue-black/60 absolute left-3 top-1/2 -translate-y-1/2">lock</span>
                                        <input
                                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-immersive-blue-black dark:text-startup-white dark:bg-background-dark focus:outline-0 focus:ring-2 focus:ring-resilient-turquoise/50 border border-ice dark:border-white/20 bg-startup-white focus:border-resilient-turquoise h-14 placeholder:text-immersive-blue-black/60 pl-11 pr-11 py-[15px] text-base font-normal leading-normal"
                                            type="password" id="pass" name="pass" required placeholder="Ingresa tu contraseña"/>
                                    </div>
                                </div>

                                <!-- Enlaces -->
                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    <!-- espacio para recordar cuenta si quieres -->
                                </div>
                                <a href="Vista/vistaOlvidePass.php" class="text-resilient-turquoise hover:text-immersive-blue-black text-sm font-semibold">
                                    ¿Olvidaste tu contraseña?
                                </a>

                                <button type="submit"
                                        class="flex items-center justify-center text-center font-medium relative rounded-full px-6 py-3 h-14 w-full text-base bg-resilient-turquoise text-startup-white hover:bg-immersive-blue-black transition">
                                    Iniciar Sesión
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
