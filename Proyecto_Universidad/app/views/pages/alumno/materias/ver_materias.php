<?php require RUTA_APP . '/views/layout/alumno/header.php'; ?>

<h3 class="titulo-fuente text-black">Materias de tu Carrera</h3>

<!-- Mostrar listado de materias -->
<?php if (!empty($data['materias'])): ?>
    <ul class="list-group">
        <?php foreach ($data['materias'] as $materia): ?>
            <li class="list-group-item">
                <?php echo $materia->nombre_materia; ?> (ID: <?php echo $materia->id_materia; ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="alert alert-info">No hay materias asociadas a tu carrera.</p>
<?php endif; ?>

<!-- Footer -->
<?php require RUTA_APP . '/views/layout/alumno/footer.php'; ?>
