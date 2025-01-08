<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>

<h3 class="titulo-fuente text-black">Detalle de Carrera</h3>

<a href="<?php echo RUTA_URL; ?>/adminController/abmCarreras" class="btn btn-primary">Volver a listado</a>

<!-- Mostrar mensaje de éxito o error -->
<?php if (!empty($data['mensaje'])): ?>
    <div class="alert alert-info"><?php echo $data['mensaje']; ?></div>
<?php endif; ?>

<!-- Verificar si se obtuvo una carrera para mostrar -->
<?php if ($data['carrera']): ?>
    <div class="container p-5">
        <!-- Información de la carrera -->
        <h2 class="text-center mb-4">Detalle de la Carrera</h2>
        <div class="mb-3">
            <label for="idCarrera" class="form-label">ID de carrera:</label>
            <input type="text" class="form-control" id="idCarrera"
                value="<?php echo $data['carrera']->id_carrera; ?>" readonly>

            <label for="nombreCarrera" class="form-label">Nombre de la carrera:</label>
            <input type="text" class="form-control" id="nombreCarrera"
                value="<?php echo $data['carrera']->nombre_carrera; ?>" readonly>
        </div>

        <!-- Mostrar las materias asociadas a la carrera -->
        <h3 class="mt-4">Materias Asociadas</h3>
        <?php if (!empty($data['materias'])): ?>
            <ul class="list-group mb-3">
                <?php foreach ($data['materias'] as $materia): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <?php echo $materia->nombre_materia; ?> 
                            (ID: <?php echo $materia->id_materia; ?>)
                        </span>
                        <!-- Formulario para desvincular -->
                        <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/desvincularMateria" class="m-0">
                            <input type="hidden" name="id_carrera" value="<?php echo $data['carrera']->id_carrera; ?>">
                            <input type="hidden" name="id_materia" value="<?php echo $materia->id_materia; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" title="Desvincular Materia">
                                🗑️
                            </button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="alert alert-info">No hay materias asociadas a esta carrera.</p>
        <?php endif; ?>

        <!-- Formulario para asociar una materia -->
        <h3 class="mt-4">Asociar Materia</h3>
        <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/asociarMateria">
            <div class="mb-3">
                <label for="materiaSelect" class="form-label">Seleccionar Materia:</label>
                <select id="materiaSelect" name="id_materia" class="form-select" required>
                    <option value="" selected disabled>Selecciona una materia</option>
                    <?php foreach ($data['materiasDisponibles'] as $materia): ?>
                        <option value="<?php echo $materia->id_materia; ?>">
                            <?php echo $materia->nombre_materia; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="id_carrera" value="<?php echo $data['carrera']->id_carrera; ?>">
            <button type="submit" class="btn btn-success w-100 my-2">Asignar Materia</button>
        </form>

        <!-- Botón para editar -->
        <a href="<?php echo RUTA_URL; ?>/adminController/modificarCarreraVista/<?php echo $data['carrera']->id_carrera; ?>"
            class="btn btn-warning w-100 my-3">Modificar Carrera</a>
    </div>
<?php else: ?>
    <p class="alert alert-danger text-center">No se encontró la carrera.</p>
<?php endif; ?>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>
