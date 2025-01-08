<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>

<h3 class="titulo-fuente text-black">Detalle de Materia</h3>

<a href="<?php echo RUTA_URL; ?>/adminController/abmMaterias" class="btn btn-primary">Volver a listado</a>

<!-- Mostrar mensaje de éxito o error -->
<?php if (!empty($data['mensaje'])): ?>
    <div class="alert alert-info"><?php echo $data['mensaje']; ?></div>
<?php endif; ?>

<!-- Verificar si se obtuvo una materia para mostrar -->
<?php if ($data['materia']): ?>
    <div class="container p-5">
         
        <!-- Información de la materia -->
        <h2 class="text-center mb-4">Detalle de la Materia</h2>
        <div class="mb-3">
            <label for="idMateria" class="form-label">ID de Materia:</label>
            <input type="text" class="form-control" id="idProfesor"
                value="<?php echo $data['materia']->id_materia; ?>" readonly>
            <label for="nombreCarrera" class="form-label">Nombre de la materia:</label>
            <input type="text" class="form-control" id="nombreMateria"
                value="<?php echo $data['materia']->nombre_materia; ?>" readonly>
        </div>

<!-- Mostrar los profesores asociadas a la materia -->
<h3 class="mt-4">Profesores Asociados</h3>
        <?php if (!empty($data['profesores'])): ?>
            <ul class="list-group mb-3">
                <?php foreach ($data['profesores'] as $profesor): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                    <?php echo $profesor->nombre_profesor . " " . $profesor->apellido_profesor; ?> 
                    (ID: <?php echo $profesor->dni_profesor; ?>)
                    </span>
                        <!-- Formulario para desvincular -->
                        <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/desvincularProfesor" class="m-0">
                            <input type="hidden" name="id_materia" value="<?php echo $data['materia']->id_materia; ?>">
                            <input type="hidden" name="dni_profesor" value="<?php echo $profesor->dni_profesor; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" title="Desvincular Profesor">
                                🗑️
                            </button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="alert alert-info">No hay profesores asociados a esta materia.</p>
        <?php endif; ?>

        <!-- Formulario para asociar un profesor -->
        <h3 class="mt-4">Asociar Profesor</h3>
        <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/asociarProfesor">
            <div class="mb-3">
                <label for="materiaSelect" class="form-label">Seleccionar profesor:</label>
                <select id="dni_profesorSelect" name="dni_profesor" class="form-select" required>
                    <option value="" selected disabled>Selecciona un profesor</option>
                    <?php foreach ($data['profesoresDisponibles'] as $profesor): ?>
                        <option value="<?php echo $profesor->dni_profesor; ?>">
                        <?php echo $profesor->nombre_profesor . " " . $profesor->apellido_profesor; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="id_materia" value="<?php echo isset($data['materia']->id_materia) ? $data['materia']->id_materia : ''; ?>">

            <button type="submit" class="btn btn-success w-100 my-2">Asignar Profesor</button>
        </form>

        <!-- Botón para editar -->
       
       <a href="<?php echo RUTA_URL; ?>/adminController/modificarMateriasVista/<?php echo $data['materia']->id_materia; ?>"
            class="btn btn-warning w-100 my-3">Modificar Materia</a>
    </div>
<?php else: ?>
    <p class="alert alert-danger text-center">No se encontró la materia.</p>
<?php endif; ?>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>
       