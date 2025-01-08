<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>
<style>

    /* Ocultar las flechas de incremento */
    .no-spinners::-webkit-inner-spin-button,
    .no-spinners::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Ocultar las flechas de incremento (Firefox) */
    .no-spinners {
        -appearance: textfield;
    }

</style>


<h3 class="titulo-fuente text-black">Alta Materia</h3>

<a href="<?php echo RUTA_URL; ?>/adminController/abmMaterias" class="btn btn-primary">Volver a listado</a>


<!-- FORM -->
<div class="container p-5">
    <h2 class="text-center mb-4">Crear Materia</h2>
    <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/altaMateriaAction">
        <div class="mb-3">
           
            <label for="nombreMateria" class="form-label">Ingrese el nombre de la Materia</label>
            <input type="text" class="form-control" id="nombreMateria" name="nombre-materia" placeholder="Ingresa el nombre de la materia" required>
            
            <label for="id_comision" class="form-label">Seleccionar ID de Comision:</label>
            <select id="id_comisionSelect" name="comision-materia" class="form-select" required>
             <option value="" selected disabled>Selecciona ID Comision</option>

 <!-- Iterar sobre las comisiones y mostrar sus opciones -->
    <?php foreach ($data['comisiones'] as $comision): ?>
        <option value="<?php echo $comision->id_comision; ?>">
            ID: <?php echo $comision->id_comision; ?> |
            Turno: <?php echo $comision->horario_comision; ?> |
            Días: <?php echo $comision->dia_comision; ?>
        </option>
    <?php endforeach; ?>
</select>

            
        </div>
        <?php if (!empty($data['error_crear_materia'])): ?>
            <div class="alert alert-danger"><?php echo $data['error_crear_materia']; ?></div>
        <?php endif; ?>


        <button type="submit" class="estilo-botones w-100 my-2">Agregar</button>
    </form>
</div>



<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>