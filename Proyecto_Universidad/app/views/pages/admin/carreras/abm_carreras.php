<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>


<div class="container mt-2">
    <h2>Listado de Carreras Activas</h2>
    <a href="<?php echo RUTA_URL; ?>/adminController/altaCarrerasVista" class="btn btn-primary">Agregar Carrera</a>

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
                            <!-- Enlace de editar con el ID de la carrera como parámetro -->
                            <a href="<?php echo RUTA_URL; ?>/adminController/modificarCarreraVista/<?php echo $carrera->id_carrera; ?>" class="btn btn-warning">Editar</a>
                            <a href="<?php echo RUTA_URL; ?>/adminController/bajarCarrera/<?php echo $carrera->id_carrera; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta carrera?');">Eliminar</a>
                            <a href="<?php echo RUTA_URL; ?>/adminController/detalleCarrera/<?php echo $carrera->id_carrera; ?>" class="btn btn-primary">Ver detalles</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4">No hay carreras activas registradas.</td>
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