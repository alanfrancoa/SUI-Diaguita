<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>

<h3 class="titulo-fuente text-black">Modificar materias</h3>
<a href="<?php echo RUTA_URL; ?>/adminController/abmMaterias" class="btn btn-primary">Volver a listado</a>

<!-- FORM -->
<div class="container p-5">
    <h2 class="text-center mb-4">Modificar materias</h2>

    <!-- Mostrar mensaje de éxito o error -->
    <?php if (!empty($data['mensaje'])): ?>
        <div class="alert alert-info"><?php echo $data['mensaje']; ?></div>
    <?php endif; ?>

    <!-- Verificar si se obtuvo una materia para modificar -->
    
    <?php if (!empty($data['materia'])): ?>
    <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/modificarMateriaAction">
        <div class="mb-3">
            <label for="idMateria" class="form-label">ID de Materia (no editable):</label>
            <input type="text" class="form-control" id="idMateria" name="id-materia"
                value="<?php echo $data['materia']->id_materia; ?>" readonly>

            <label for="nombreMateria" class="form-label">Nombre de la Materia:</label>
            <input type="text" class="form-control" id="nombreMateria" name="nombre-materia"
                value="<?php echo $data['materia']->nombre_materia; ?>" required>

            <label for="comisionId" class="form-label">Seleccione la Comisión:</label>
            <select class="form-control" id="comisionId" name="comision-id" required>
                <?php foreach ($data['comisiones'] as $comision): ?>
                    <option value="<?php echo $comision->id_comision; ?>" 
                    <?php echo ($data['materia']->comision_id == $comision->id_comision) ? 'selected' : ''; ?>>
                    <?php echo "ID: " . htmlspecialchars($comision->id_comision) . " - Días: " . htmlspecialchars($comision->dia_comision) . " - Turno: " . htmlspecialchars($comision->horario_comision); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Mensaje de error en caso de que falle la modificación -->
        <?php if (!empty($data['error_modificar_materia'])): ?>
            <div class="alert alert-danger"><?php echo $data['error_modificar_materia']; ?></div>
        <?php endif; ?>

        <button type="submit" class="estilo-botones w-100 my-2">Modificar</button>
    </form>
<?php else: ?>
    <p>No se encontró la materia para modificar.</p>
<?php endif; ?>
</div>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>