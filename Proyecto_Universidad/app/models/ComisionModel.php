<?php

class ComisionModel
{
    private $db;
    private $error_mensaje;

    public function __construct()
    {
        $this->db = new Database;
    }
    // ----- Funciones del ComisionModel ----- //

    public function getMensajeError()
    {
        return $this->error_mensaje;
    }
    // Create: Crear una nueva comisión
    public function crear_comision($data)
    {
        // Verificar si la comisión ya existe antes de intentar crearla
        if ($this->buscar_comision_por_id($data['id_comision'])) {
            $this->error_mensaje = "La comisión con ID " . $data['id_comision'] . " ya existe.";
            return false; //retorna una bandera 
        }

        // preparamos la Consulta para insertar una nueva comisión
        $queryCrearComision = "INSERT INTO comision (id_comision, horario_comision, dia_comision) 
                               VALUES (:id_comision, :horario_comision, :dia_comision)";
        $this->db->query($queryCrearComision);

        // Vincular los parámetros
        $this->db->bind(':id_comision', $data['id_comision']);
        $this->db->bind(':horario_comision', $data['horario_comision']);
        $this->db->bind(':dia_comision', $data['dia_comision']);

        // Ejecutar la consulta
        return $this->db->execute();
    }

    // Read: busca por id una comisión con el ID proporcionado
    public function buscar_comision_por_id($id_comision)
    {
        // Consulta para verificar si la comisión existe
        $queryExisteComision = "SELECT * FROM comision WHERE id_comision = :id_comision";

        //pasamos la query al metodo
        $this->db->query($queryExisteComision);
        $this->db->bind(':id_comision', $id_comision);

        // Obtener el resultado único
        $result = $this->db->register();

        // Verificar si la consulta encontró alguna comisión
        return $result;
    }

    // Read: Obtener la lista de todas las comisiones
    public function obtener_comisiones_todas()
    {
        $queryObtenerComisiones = "SELECT * FROM comision";
        $this->db->query($queryObtenerComisiones);
        return $this->db->registers(); // Cambia a registers() para obtener los datos
    }

    //Read: Obtener la lista de comisiones activas
    public function obtener_comisiones_activas()
    {
        $queryObtenerComisiones = "SELECT * FROM comision WHERE comision.deletedAt IS NULL";
        $this->db->query($queryObtenerComisiones);
        return $this->db->registers(); // Cambia a registers() para obtener los datos
    }

    //Read: Obtener la lista de comisiones inactivas
    public function obtener_comisiones_inactivas()
    {
        $queryObtenerComisiones = "SELECT * FROM comision WHERE comision.deletedAt IS NOT NULL";
        $this->db->query($queryObtenerComisiones);
        return $this->db->registers(); // Cambia a registers() para obtener los datos
    }

    // Update: Editar una comisión existente
    public function editar_comision($data)
    {
        // Verificar si la comisión existe
        if (!$this->buscar_comision_por_id($data['id_comision'])) {
            $this->error_mensaje = "La comisión con ID " . $data['id_comision'] . " no existe.";
            return false; // Retorna una bandera indicando que no se encontró la comisión
        }

        // Consulta para actualizar solo los campos que no son ID
        $queryEditarComision = "UPDATE comision 
                            SET horario_comision = :horario_comision, dia_comision = :dia_comision 
                            WHERE id_comision = :id_comision";
        $this->db->query($queryEditarComision);

        // Vincular los parámetros (sin modificar el ID)
        $this->db->bind(':id_comision', $data['id_comision']);
        $this->db->bind(':horario_comision', $data['horario_comision']);
        $this->db->bind(':dia_comision', $data['dia_comision']);

        // Ejecutar la consulta
        return $this->db->execute();
    }


    // Delete: Soft Delete de una comisión configurando el campo deletedAt
    public function eliminar_comision($id_comision)
    {
        // Verificar si la comisión existe
        $comision = $this->buscar_comision_por_id($id_comision);
        if (!$comision) {
            $this->error_mensaje = "La comisión con ID " . $id_comision . " no existe.";
            return false;
        }


        // Consulta para establecer el campo deletedAt con la fecha y hora actuales
        $querySoftDeleteComision = "UPDATE comision 
                                SET deletedAt = :deletedAt 
                                WHERE id_comision = :id_comision";
        $this->db->query($querySoftDeleteComision);

        // Vincular los parámetros
        $this->db->bind(':id_comision', $id_comision);
        $this->db->bind(':deletedAt', date('Y-m-d H:i:s')); // Establecer la fecha y hora actual

        // Ejecutar la consulta
        return $this->db->execute();
    }

    // Delete: Subir de una comisión ya dada de baja.
    public function subir_comision($id_comision)
    {
        // Verificar si la comisión existe
        $comision = $this->buscar_comision_por_id($id_comision);
        if (!$comision) {
            $this->error_mensaje = "La comisión con ID " . $id_comision . " no existe.";
            return false;
        }


        // Consulta para establecer el campo deletedAt con la fecha y hora actuales
        $queryUpdateComision = "UPDATE comision 
                                    SET deletedAt = NULL 
                                    WHERE id_comision = :id_comision";
        $this->db->query($queryUpdateComision);

        // Vincular los parámetros
        $this->db->bind(':id_comision', $id_comision);

        // Ejecutar la consulta
        return $this->db->execute();
    }
}
