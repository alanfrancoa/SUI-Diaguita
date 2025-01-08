<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>

<style>
    /* Ocultar las flechas de incremento */
    .no-spinners::-webkit-inner-spin-button,
    .no-spinners::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Ocultar las flechas de incremento (Firefox) */
    .no-spinners {
        -appearance: textfield;
    }
</style>

<div class="container my-5">

    <a href="<?php echo RUTA_URL; ?>/adminController/altaUsuarioVista" class="btn btn-primary mb-4">Alta de usuario</a>
    <h2 class="py-2">Listado de Usuarios</h2>

    <!-- Tabla de Usuarios -->
    <table class="table" style="max-width: 900px; margin: auto;">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Usuario</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data['usuarios'])) : ?>
                <?php foreach ($data['usuarios'] as $usuario) : ?>
                    <tr>
                        <td class="text-center"><?= $usuario->id_usuario ?></td>
                        <td class="text-center"><?= $usuario->nombre_usuario ?></td>
                        <?php if (is_null($usuario->deletedAt)) : ?>
                            <td class="text-center text-success">
                                <strong>
                                    Activo
                                </strong>
                            </td>
                        <?php else : ?>
                            <td class="text-center text-danger">
                                <strong>
                                    Inactivo
                                </strong>
                            </td>
                        <?php endif; ?>
                        <td class="text-center">
                            <a href="<?php echo RUTA_URL; ?>/adminController/detalleUsuarioVista/<?php echo $usuario->nombre_usuario; ?>" class="btn btn-warning">Detalles</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Buscador y Botones -->
    <div class="d-flex justify-content-between align-items-center mt-4 gap-3" style="max-width: 900px; margin: auto;">
        <form action="<?php echo RUTA_URL; ?>/adminController/abmUsuarios" method="GET" class="d-flex gap-1" style="width: 50%;">
            <input
                type="number" class="form-control no-spinners"
                placeholder="Buscar usuario..."
                name="query"
                aria-label="Buscar"
                value="<?php echo htmlspecialchars($data['query'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                required>
            <button class="btn btn-primary" type="submit">Buscar</button>
        </form>
        <div class="btn-group d-flex gap-2" role="group" aria-label="Filtro de usuarios" style="width: 50%;">
            <a href="<?php echo RUTA_URL; ?>/adminController/usuariosActivosVista" class="btn btn-success">Activos</a>
            <a href="<?php echo RUTA_URL; ?>/adminController/usuariosInactivosVista" class="btn btn-secondary">Inactivos</a>
            <a href="<?php echo RUTA_URL; ?>/adminController/abmUsuarios" class="btn btn-info">Todos</a>
        </div>
    </div>

</div>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>