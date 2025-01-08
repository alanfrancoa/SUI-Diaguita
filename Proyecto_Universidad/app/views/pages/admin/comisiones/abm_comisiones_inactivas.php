<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>


<div class="container mt-2">
    <h2>Listado de Comisiones Inactivas</h2>
    <a href="<?php echo RUTA_URL; ?>/adminController/altaComisionesVista" class="btn btn-primary">Agregar Comisión</a>

    <?php if (!empty($data['mensaje'])) : ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($data['mensaje']); ?></div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Turno</th>
                <th>Días</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data['comisiones'])) : ?>
                <?php foreach ($data['comisiones'] as $comision) : ?>
                    <tr>
                        <td><?= isset($comision->id_comision) ? htmlspecialchars($comision->id_comision) : 'N/A' ?></td>
                        <td><?= isset($comision->horario_comision) ? htmlspecialchars($comision->horario_comision) : 'N/A' ?></td>
                        <td><?= isset($comision->dia_comision) ? htmlspecialchars($comision->dia_comision) : 'N/A' ?></td>
                        <td>
                            <!-- Enlace de editar con el ID de la comisión como parámetro -->
                            
                            <a href="<?php echo RUTA_URL; ?>/adminController/subirComision/<?php echo $comision->id_comision; ?>" class="btn btn-warning" onclick="return confirm('¿Estás seguro de reactivar esta comisión?');">Activar</a> 

                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4">No hay comisiones inactivas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div>
    <a href="<?php echo RUTA_URL; ?>/adminController/abmComisiones" class="btn btn-success">Ver comisiones Activas</a>
    <a href="<?php echo RUTA_URL; ?>/adminController/abmComisionesInactivas" class="btn btn-secondary">Ver comisiones Inactivas</a>
    <a href="<?php echo RUTA_URL; ?>/adminController/abmComisionesTodas" class="btn btn-info">Ver todas las comisiones</a>
    </div>
</div>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>