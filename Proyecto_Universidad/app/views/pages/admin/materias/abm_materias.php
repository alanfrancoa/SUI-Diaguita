<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>


<div class="container mt-2">
    <h2>Listado de Materias</h2>
    <a href="<?php echo RUTA_URL; ?>/adminController/altaMateriaView" class="btn btn-primary  mb-2">Agregar Materia</a>
    <?php if (!empty($data['mensaje'])) : ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($data['mensaje']); ?></div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Comision</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data['materias'])) : ?>
                <?php foreach ($data['materias'] as $materia) : ?>
                    <tr>
                        <td><?= isset($materia->id_materia) ? htmlspecialchars($materia->id_materia) : 'N/A' ?></td>
                        <td><?= isset($materia->nombre_materia) ? htmlspecialchars($materia->nombre_materia) : 'N/A' ?></td>
                        <td><?= isset($materia->comision_id) ? htmlspecialchars($materia->comision_id) : 'N/A' ?></td>
                         <td>
                            <!-- Enlace de editar con el ID de la materia como parámetro -->
                            <a href="<?php echo RUTA_URL; ?>/adminController/modificarMateriasVista/<?php echo $materia->id_materia; ?>" class="btn btn-warning">Editar</a>
                                                      
                            <a href="<?php echo RUTA_URL; ?>/adminController/bajarMateria/<?php echo $materia->id_materia; ?>"class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta materia?');">Eliminar</a>

                            <a href="<?php echo RUTA_URL; ?>/adminController/detalleMateria/<?php echo $materia->id_materia; ?>" class="btn btn-primary">Ver detalles</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4">No hay materias activas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div>
    <a href="<?php echo RUTA_URL; ?>/adminController/abmMaterias" class="btn btn-success">Ver materias Activas</a>
    <a href="<?php echo RUTA_URL; ?>/adminController/abmMateriasInactivas" class="btn btn-secondary">Ver materias Inactivas</a>
    <a href="<?php echo RUTA_URL; ?>/adminController/abmMateriasTodas" class="btn btn-info">Ver todas las materias</a>

</div>
</div>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>