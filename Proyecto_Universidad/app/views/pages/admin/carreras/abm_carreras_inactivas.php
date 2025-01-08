<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>


<div class="container mt-2">
    <h2>Listado de Carreras Inactivas</h2>
    <a href="<?php echo RUTA_URL; ?>/adminController/altaCarrerasVista" class="btn btn-primary">Agregar Comisión</a>

    <?php if (!empty($data['mensaje'])) : ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($data['mensaje']); ?></div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data['carreras'])) : ?>
                <?php foreach ($data['carreras'] as $carrera) : ?>
                    <tr>
                        <td><?= isset($carrera->id_carrera) ? htmlspecialchars($carrera->id_carrera) : 'N/A' ?></td>
                        <td><?= isset($carrera->nombre_carrera) ? htmlspecialchars($carrera->nombre_carrera) : 'N/A' ?></td>
                        <td>
                            <!-- Enlace de editar con el ID de la comisión como parámetro -->

                            <a href="<?php echo RUTA_URL; ?>/adminController/subirCarrera/<?php echo $carrera->id_carrera; ?>" class="btn btn-warning" onclick="return confirm('¿Estás seguro de reactivar esta carrera?');">Activar</a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="3">No hay carreras.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div>
        <a href="<?php echo RUTA_URL; ?>/adminController/abmCarreras" class="btn btn-success">Ver carreras Activas</a>
        <a href="<?php echo RUTA_URL; ?>/adminController/abmCarrerasInactivas" class="btn btn-secondary">Ver carreras Inactivas</a>
        <a href="<?php echo RUTA_URL; ?>/adminController/abmCarrerasTodas" class="btn btn-info">Ver todas las carreras</a>
    </div>
</div>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>