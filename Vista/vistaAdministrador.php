<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Administrador - Donde Patty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        :root {
            --immersive-blue-black: #22404D;  /* fondo y texto principal */
            --resilient-turquoise: #00A0AF;  /* botones primarios */
            --empowered-yellow: #E3E24F; /* acentos */
            --startup-white:#FFFFFF;
            --sustainable-green: #008B61; /* estados OK */
            --ice: #C3E5F5; 
        }

        body {
            background-color: #f6f6f8;
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--immersive-blue-black), #0c2028);
        }

        .sidebar .nav-link {
            color: var(--startup-white);
            border-radius: .5rem;
            margin-bottom: .4rem;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: var(--resilient-turquoise);
            color: var(--startup-white);
        }

        .badge-admin {
            background-color: var(--empowered-yellow);
            color: #12202a;
        }

        .card-header {
            border-bottom: 0;
            background: linear-gradient(90deg, var(--ice), var(--startup-white));
            color: var(--immersive-blue-black);
            font-weight: 600;
        }

        .btn-primary-brand {
            background-color: var(--resilient-turquoise);
            border-color: var(--resilient-turquoise);
        }

        .btn-primary-brand:hover {
            background-color: var(--immersive-blue-black);
            border-color: var(--immersive-blue-black);
        }

        .page-title {
            color: var(--immersive-blue-black);
            border-left: 6px solid var(--empowered-yellow);
            padding-left: .75rem;
            font-weight: 700;
        }
    </style>
</head>

<?php

$seccion = $_GET['seccion'] ?? 'usuarios';

if (empty($_SESSION['esAdmin'])) {
    header("Location: ../index.php");
    exit();
}
?>

<body>
<div class="d-flex min-vh-100">
    <aside class="sidebar d-flex flex-column p-3 text-white vh-100 position-sticky top-0" style="width: 260px;">
        <div class="mb-4">
            <h5 class="mb-1 text-uppercase small text-white-50">Panel</h5>
            <h4 class="mb-1 fw-bold">Administrador</h4>
        </div>

        <nav class="flex-grow-1">
            <a href="../Controlador/controladorAdministrador.php?seccion=usuarios"
               class="nav-link d-block <?= $seccion === 'usuarios' ? 'active' : '' ?>">
                Usuarios
            </a>
            <a href="../Controlador/controladorAdministrador.php?seccion=movimientos"
               class="nav-link d-block <?= $seccion === 'movimientos' ? 'active' : '' ?>">
                Movimientos
            </a>
        </nav>

        <hr class="text-white mt-auto">
        <a href="../Controlador/controladorCerrarSesion.php" class="btn btn-outline-light w-100">
            Cerrar sesión
        </a>
    </aside>

    <main class="flex-grow-1 p-4">
        <?php if ($seccion === 'usuarios'): ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-title mb-0">Gestión de usuarios</h2>
            </div>

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header">
                    <?= !empty($idUsuario)
                        ? "Editar usuario ID: " . htmlspecialchars($idUsuario)
                        : "Registrar nuevo usuario" ?>
                </div>
                <div class="card-body">
                    <form method="POST" action="controladorAdministrador.php?seccion=usuarios">
                        <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($idUsuario ?? '') ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre</label>
                                <input required type="text" name="nombreU"
                                       value="<?= htmlspecialchars($nombreU ?? '') ?>"
                                       class="form-control" placeholder="Nombre del usuario" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apellido</label>
                                <input required type="text" name="apellidoU"
                                       value="<?= htmlspecialchars($apellidoU ?? '') ?>"
                                       class="form-control" placeholder="Apellido del usuario" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Correo</label>
                                <input required type="email" name="correo"
                                       value="<?= htmlspecialchars($correo ?? '') ?>"
                                       class="form-control" placeholder="correo@ejemplo.com" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Contraseña <?= !empty($idUsuario) ? '(dejar vacío para mantener)' : '' ?>
                                </label>
                                <input type="<?= !empty($idUsuario) ? 'text' : 'password' ?>" name="pass"
                                       class="form-control" placeholder="Mínimo 6 caracteres"
                                       <?= !empty($idUsuario) ? '' : 'required' ?> />
                            </div>
                        </div>

                        <?php if (!empty($idUsuario)): ?>
                            <button type="submit" name="update" class="btn btn-primary-brand me-2">Actualizar</button>
                            <a href="controladorAdministrador.php?seccion=usuarios" class="btn btn-outline-secondary">Cancelar</a>
                        <?php else: ?>
                            <button type="submit" name="add" class="btn btn-primary-brand">Registrar usuario</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Usuarios registrados (<?= is_array($usuarios) ? count($usuarios) : 0 ?>)
                    </h5>
                    <?php
                    $totalAdmins = 0;
                    if (!empty($usuarios)) {
                        foreach ($usuarios as $u) {
                            if (!empty($u['esAdmin'])) {
                                $totalAdmins++;
                            }
                        }
                    }
                    ?>
                    <span class="badge badge-admin"><?= $totalAdmins ?> Admins</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead style="background-color: var(--ice);">
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($usuarios)): ?>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($usuario['idUsuario']) ?></strong></td>
                                        <td><?= htmlspecialchars($usuario['nombreU'] . ' ' . $usuario['apellidoU']) ?></td>
                                        <td><?= htmlspecialchars($usuario['correo']) ?></td>
                                        <td>
                                            <?php $esAdmin = !empty($usuario['esAdmin']); ?>
                                            <span class="badge <?= $esAdmin ? 'badge-admin' : 'bg-secondary' ?>">
                                                <?= $esAdmin ? 'ADMIN' : 'Usuario' ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <?php if (!$esAdmin): ?>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="controladorAdministrador.php?seccion=usuarios&edit=<?= $usuario['idUsuario'] ?>" class="btn btn-outline-primary">Editar</a>
                                                    <form method="POST" class="d-inline"
                                                          onsubmit="return confirm('¿Eliminar a <?= htmlspecialchars($usuario['nombreU']) ?>?');">
                                                        <input type="hidden" name="idUsuario" value="<?= $usuario['idUsuario'] ?>">
                                                        <button type="submit" name="delete" class="btn btn-outline-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted small">Acciones bloqueadas</span>
                                            <?php endif; ?>
                                            </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No hay usuarios registrados</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php elseif ($seccion === 'movimientos'): ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-title mb-0">Movimientos de inventario por usuario</h2>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="mb-0">Historial de movimientos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead style="background-color: var(--ice);">
                            <tr>
                                <th>ID Mov</th>
                                <th>ID Usuario</th>
                                <th>Usuario</th>
                                <th>Producto</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($movimientos)): ?>
                                <?php foreach ($movimientos as $m): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($m['idMovimiento']) ?></td>
                                        <td><?= htmlspecialchars($m['idUsuario'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($m['nombreU'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($m['nombreP'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($m['tipo']) ?></td>
                                        <td><?= htmlspecialchars($m['cantidad']) ?></td>
                                        <td><?= htmlspecialchars($m['fechaM']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No hay movimientos registrados
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>