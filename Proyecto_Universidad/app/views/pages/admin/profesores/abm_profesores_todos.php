<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>


<div class="container mt-2">
    <h2>Listado de Profesores Activos e Inactivos</h2>
    <a href="<?php echo RUTA_URL; ?>/adminController/altaProfesoresVista" class="btn btn-primary mb-2">Agregar profesor</a>

    <?php if (!empty($data['mensaje'])) : ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($data['mensaje']); ?></div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>eMail</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data['profesores'])) : ?>
                <?php foreach ($data['profesores'] as $profesor) : ?>
                    <tr>
                        <td><?= isset($profesor->dni_profesor) ? htmlspecialchars($profesor->dni_profesor) : 'N/A' ?></td>
                        <td><?= isset($profesor->nombre_profesor) ? htmlspecialchars($profesor->nombre_profesor) : 'N/A' ?></td>
                        <td><?= isset($profesor->apellido_profesor) ? htmlspecialchars($profesor->apellido_profesor) : 'N/A' ?></td>
                        <td><?= isset($profesor->email_profesor) ? htmlspecialchars($profesor->email_profesor) : 'N/A' ?></td>

                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="3">No hay comisiones.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div>
        <a href="<?php echo RUTA_URL; ?>/adminController/abmProfesores" class="btn btn-success">Ver profesores activos</a>
        <a href="<?php echo RUTA_URL; ?>/adminController/abmProfesoresInactivos" class="btn btn-secondary">Ver profesores inactivos</a>
        <a href="<?php echo RUTA_URL; ?>/adminController/abmProfesoresTodos" class="btn btn-info">Ver todas los profesores</a>
    </div>
</div>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>