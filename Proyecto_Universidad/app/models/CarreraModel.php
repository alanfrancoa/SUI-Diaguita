<?php

class CarreraModel
{
    private $db;
    private $error_mensaje;

    public function __construct()
    {
        $this->db = new Database;
    }

    // ----- Funciones del CarreraModel ----- //

    //metodo para desvincular materia
    public function desvincularMateriaDeCarrera($id_carrera, $id_materia)
    {
        $this->db->query("
            DELETE FROM carrera_materia 
            WHERE id_carrera = :id_carrera AND id_materia = :id_materia
        ");
        $this->db->bind(':id_carrera', $id_carrera);
        $this->db->bind(':id_materia', $id_materia);

        return $this->db->execute();
    }



    /**
     * Obtiene una lista de materias asociadas a una carrera específica.
     *
     * Esta función realiza una consulta a la base de datos para obtener todas las materias
     * que están asociadas a la carrera indicada por el ID proporcionado.
     *
     * **Diferencia clave:** En lugar de buscar las materias que *no* están asociadas a la carrera,
     * esta función busca las materias que sí están asociadas.
     * Esto se logra utilizando un `INNER JOIN` entre las tablas `materia` y `carrera_materia`.
     *
     * @param int $id_carrera El ID de la carrera para la cual se buscan las materias.
     * @return array Un arreglo asociativo con los datos de las materias asociadas a la carrera.
     */
    public function obtenerMateriasPorCarrera($id_carrera)
    {
        // Preparamos la consulta SQL para obtener las materias asociadas a la carrera.
        // Utilizamos un INNER JOIN para relacionar las tablas materia y carrera_materia.
        $sql = "
        SELECT m.* 
        FROM materia m
        INNER JOIN carrera_materia cm ON cm.id_materia = m.id_materia
        WHERE cm.id_carrera = :id_carrera
    ";

        // Ejecutamos la consulta y vinculamos el parámetro :id_carrera
        $this->db->query($sql);
        $this->db->bind(':id_carrera', $id_carrera);

        // Obtenemos los resultados de la consulta y los retornamos
        return $this->db->registers();
    }


    public function getMensajeError()
    {
        return $this->error_mensaje;
    }

    //Crear una nueva Carrera
    public function crear_carrera($data)
    {
        // Validaciones de entrada
        # if (empty($data['id_carrera']) || !is_numeric($data['id_carrera'])) {
        #     $this->error_mensaje = "El ID de la carrera es inválido.";
        #     return false;
        # }
        if (empty($data['nombre_carrera']) || !is_string($data['nombre_carrera'])) {
            $this->error_mensaje = "El nombre de la carrera es inválido.";
            return false;
        }

        // Preparamos la Consulta.
        $queryCrearComision = "INSERT INTO carrera (nombre_carrera) VALUES (:nombre_carrera)";
        $this->db->query($queryCrearComision);

        // Vincular los parámetros
        #$this->db->bind(':id_carrera', $data['id_carrera']);
        $this->db->bind(':nombre_carrera', $data['nombre_carrera']);

        // Ejecutar la consulta
        return $this->db->execute();
    }

    // Read
    //Método para buscar una carrera por ID
    public function buscar_carrera_por_id($id_carrera)
    {
        // Validaciones de entrada
        if (empty($id_carrera) || !is_numeric($id_carrera)) {
            $this->error_mensaje = "El ID de la carrera es inválido.";
            return false;
        }

        $queryBuscarCarrera = "SELECT * FROM carrera WHERE id_carrera = :id_carrera";

        // Pasamos la consulta al método query
        $this->db->query($queryBuscarCarrera);
        $this->db->bind(':id_carrera', $id_carrera);

        // Retornamos el resultado.
        return $this->db->register();
    }

    // Read: Obtener la lista de todas las comisiones
    public function obtener_carreras_todas()
    {
        $queryObtenerCarreras = "SELECT * FROM carrera";
        $this->db->query($queryObtenerCarreras);
        return $this->db->registers(); // Cambia a registers() para obtener los datos
    }

    // METODO para obtener todas las carreras activas //
    public function obtener_carreras_activas()
    {
        $queryObtenerCarreras = "SELECT id_carrera, nombre_carrera FROM carrera WHERE deletedAt IS NULL";

        // Pasamos la consulta al método query
        $this->db->query($queryObtenerCarreras);

        // Ejecutamos y obtenemos todos los registros
        return $this->db->registers();
    }

    // METODO para obtener todas las carreras activas //
    public function obtener_carreras_inactivas()
    {
        $queryObtenerCarreras = "SELECT id_carrera, nombre_carrera FROM carrera WHERE deletedAt IS NOT NULL";

        // Pasamos la consulta al método query
        $this->db->query($queryObtenerCarreras);

        // Ejecutamos y obtenemos todos los registros
        return $this->db->registers();
    }

    //Update: 
    //Editar una Carrera
    public function editar_carrera($data)
    {
        // Validaciones de entrada
        if (empty($data['id_carrera']) || !is_numeric($data['id_carrera'])) {
            $this->error_mensaje = "El ID de la carrera es inválido.";
            return false;
        }
        if (empty($data['nombre_carrera']) || !is_string($data['nombre_carrera'])) {
            $this->error_mensaje = "El nombre de la carrera es inválido.";
            return false;
        }

        // Verificar si la carrera ya existe antes de intentar editarla.
        if (!$this->buscar_carrera_por_id($data['id_carrera'])) {
            $this->error_mensaje = "La carrera con ID " . $data['id_carrera'] . " no existe.";
            return false;
        }

        // Preparamos la Consulta.
        $queryEditarCarrera = "UPDATE carrera SET nombre_carrera = :nombre_carrera WHERE id_carrera = :id_carrera";
        $this->db->query($queryEditarCarrera);

        // Vincular los parámetros
        $this->db->bind(':id_carrera', $data['id_carrera']);
        $this->db->bind(':nombre_carrera', $data['nombre_carrera']);

        // Ejecutar la consulta
        return $this->db->execute();
    }

    public function subir_carrera($id_carrera)
    {

        // Validaciones de entrada
        if (empty($id_carrera) || !is_numeric($id_carrera)) {
            $this->error_mensaje = "El ID de la carrera es inválido.";
            return false;
        }

        // Verificar si la carrera existe antes de activar
        if (!$this->buscar_carrera_por_id($id_carrera)) {
            $this->error_mensaje = "La carrera con ID " . $id_carrera . " no existe.";
            return false;
        }

        // Consulta para establecer el campo deletedAt con la fecha y hora actuales
        $queryUpdateCarrera =   "UPDATE carrera 
                                    SET deletedAt = NULL 
                                    WHERE id_carrera = :id_carrera";

        // Preparar y ejecutar la consulta
        $this->db->query($queryUpdateCarrera);
        $this->db->bind(':id_carrera', $id_carrera);
       
        // Ejecutar la consulta
        return $this->db->execute();
    }

    //Delate: 
    //Eliminar una Carrera
    public function eliminar_carrera($id_carrera)
    {

        // Validaciones de entrada
        if (empty($id_carrera) || !is_numeric($id_carrera)) {
            $this->error_mensaje = "El ID de la carrera es inválido.";
            return false;
        }

        // Verificar si la carrera existe antes de eliminarla
        if (!$this->buscar_carrera_por_id($id_carrera)) {
            $this->error_mensaje = "La carrera con ID " . $id_carrera . " no existe.";
            return false;
        }

        // Consulta para establecer el campo deletedAt con la fecha y hora actuales
        $querySoftDeleteCarrera =   "UPDATE carrera 
                                    SET deletedAt = :deletedAt 
                                    WHERE id_carrera = :id_carrera";

        // Preparar y ejecutar la consulta
        $this->db->query($querySoftDeleteCarrera);
        $this->db->bind(':id_carrera', $id_carrera);
        $this->db->bind(':deletedAt', date('Y-m-d H:i:s')); // Establecer la fecha y hora actual

        // Ejecutar la consulta
        return $this->db->execute();
    }


    /**
     * Obtiene una lista de materias disponibles para una carrera dada.
     *
     * Esta función realiza una consulta a la base de datos para obtener todas las materias
     * que no están asociadas a la carrera especificada.
     *
     * @param int $id_carrera El ID de la carrera para la cual se buscan las materias.
     * @return array Un arreglo asociativo con los datos de las materias disponibles.
     */
    public function obtenerMateriasDisponibles($id_carrera)
    {
        // Preparamos la consulta SQL para obtener todas las materias
        // que no estén asociadas a la carrera especificada.
        $sql = "
        SELECT * FROM materia
        WHERE id_materia NOT IN (
            SELECT id_materia 
            FROM carrera_materia 
            WHERE id_carrera = :id_carrera
        )
    ";

        // Ejecutamos la consulta y vinculamos el parámetro :id_carrera
        $this->db->query($sql);
        $this->db->bind(':id_carrera', $id_carrera);

        // Obtenemos los resultados de la consulta y los retornamos
        return $this->db->registers();
    }

    /**
     * Asocia una materia a una carrera específica.
     *
     * Esta función inserta un nuevo registro en la tabla carrera_materia
     * para establecer la relación entre la carrera y la materia.
     *
     * @param int $id_carrera El ID de la carrera a la que se asociará la materia.
     * @param int $id_materia El ID de la materia que se asociará a la carrera.
     * @return bool TRUE si la operación se realizó con éxito, FALSE en caso contrario.
     */
    public function asociarMateriaACarrera($id_carrera, $id_materia)
    {
        // Preparamos la consulta SQL para insertar un nuevo registro
        // en la tabla carrera_materia.
        $sql = "
        INSERT INTO carrera_materia (id_carrera, id_materia)
        VALUES (:id_carrera, :id_materia)
    ";

        // Ejecutamos la consulta y vinculamos los parámetros
        $this->db->query($sql);
        $this->db->bind(':id_carrera', $id_carrera);
        $this->db->bind(':id_materia', $id_materia);

        // Retornamos el resultado de la ejecución de la consulta
        return $this->db->execute();
    }
}
