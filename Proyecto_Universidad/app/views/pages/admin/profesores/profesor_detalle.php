<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>

<h3 class="titulo-fuente text-black">Detalle de Carrera</h3>

<a href="<?php echo RUTA_URL; ?>/adminController/abmProfesores" class="btn btn-primary">Volver a listado</a>

<!-- Mostrar mensaje de éxito o error -->
<?php if (!empty($data['mensaje'])): ?>
    <div class="alert alert-info"><?php echo $data['mensaje']; ?></div>
<?php endif; ?>

<?php if ($data['profesor']): ?>
    <div class="container p-5">
        <!-- Información del profesor-->
        <h2 class="text-center mb-4">Detalle del profesor</h2>
        <div class="mb-3">
            <label for="dni_profesor" class="form-label">DNI del profesor:</label>
            <input type="text" class="form-control" id="dni_profesor"
                value="<?php echo $data['profesor']->dni_profesor; ?>" readonly>

            <label for="nombre_profesor" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre_profesor"
                value="<?php echo $data['profesor']->nombre_profesor; ?>" readonly>

            <label for="apellido_profesor" class="form-label">Apellido:</label>
            <input type="text" class="form-control" id="apellido_profesor"
                value="<?php echo $data['profesor']->apellido_profesor; ?>" readonly>
        </div>
    

        <!-- Formulario para asociar una materia -->
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
                        <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/desvincularMateriaProfesor" class="m-0">
                            <input type="hidden" name="dni_profesor" value="<?php echo $data['profesor']->dni_profesor; ?>">
                            <input type="hidden" name="id_materia" value="<?php echo $materia->id_materia; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" title="Desvincular Materia">
                                🗑️
                            </button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="alert alert-info">No hay materias asociadas a este profesor.</p>
        <?php endif; ?>

        <!-- Formulario para asociar una materia -->
        <h3 class="mt-4">Asociar Materia</h3>
        <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/asociarMateriaProfesor">
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
            <input type="hidden" name="dni_profesor" value="<?php echo $data['profesor']->dni_profesor; ?>">
            <button type="submit" class="btn btn-success w-100 my-2">Asignar Materia</button>
        </form>

        <!-- Botón para editar -->
        <a href="<?php echo RUTA_URL; ?>/adminController/modificarProfesorVista/<?php echo $data['profesor']->dni_profesor; ?>"
            class="btn btn-warning w-100 my-3">Modificar Profesor</a>
    </div>
<?php else: ?>
    <p class="alert alert-danger text-center">No se encontró la carrera.</p>
<?php endif; ?>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>
