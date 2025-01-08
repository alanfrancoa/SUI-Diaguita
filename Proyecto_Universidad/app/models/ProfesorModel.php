<?php

class ProfesorModel
{
    private $db;
    private $error_mensaje;

    public function __construct()
    {
        $this->db = new Database;
    }

    // -----Funciones----- //

    //metodo para desvincular materia
    public function desvincularMateriaDeProfesor($id_materia, $dni_profesor) {
        $this->db->query("
            DELETE FROM materia_profesor 
            WHERE id_materia = :id_materia
            AND  dni_profesor = :dni_profesor;
        ");
        $this->db->bind(':id_materia', $id_materia);
        $this->db->bind(':dni_profesor', $dni_profesor);
    
        return $this->db->execute();
    }

    public function obtenerMateriasPorProfesor($dni_profesor)
    {
        // Preparamos la consulta SQL para obtener las materias asociadas al profesor
        // Utilizamos un INNER JOIN para relacionar las tablas materia y materia_profesor.
        $sql = "
        SELECT m.* 
        FROM materia m
        INNER JOIN materia_profesor cm ON cm.id_materia = m.id_materia
        WHERE cm.dni_profesor = :dni_profesor
    ";

        // Ejecutamos la consulta y vinculamos el parámetro :dni_profesor
        $this->db->query($sql);
        $this->db->bind(':dni_profesor', $dni_profesor);

        // Obtenemos los resultados de la consulta y los retornamos
        return $this->db->registers();
    }

    public function getMensajeError()
    {
        return $this->error_mensaje;
    }

    // Create: Crear una nueva profesor
    public function crear_profesor($data)
    {
        // Verificar si el profesor ya existe antes de intentar crearlo
        if ($this->buscar_profesor_por_dni($data['dni_profesor'])) {
            $this->error_mensaje = "El profesor con DNI " . $data['dni_profesor'] . " ya existe.";
            return false; //retorna una bandera 
        }

        // preparamos la consulta para insertar un nuevo profesor
        $queryCrearProfesor = "INSERT INTO profesor (dni_profesor,
                                                     nombre_profesor,	
                                                     apellido_profesor,	
                                                     email_profesor) 
                               VALUES (:dni_profesor,
                                        :nombre_profesor,	
                                        :apellido_profesor,	
                                        :email_profesor)";
        $this->db->query($queryCrearProfesor);

        // Vincular los parámetros
        $this->db->bind(':dni_profesor', $data['dni_profesor']);
        $this->db->bind(':nombre_profesor', $data['nombre_profesor']);
        $this->db->bind(':apellido_profesor', $data['apellido_profesor']);
        $this->db->bind(':email_profesor', $data['email_profesor']);

        // Ejecutar la consulta
        return $this->db->execute();
    }

     // Read: busca por id 
     public function buscar_profesor_por_dni($dni_profesor)
     {
         // Consulta para verificar si la profesor existe
         $queryExisteProfesor = "SELECT * FROM profesor WHERE dni_profesor = :dni_profesor";
 
         //pasamos la query al metodo
         $this->db->query($queryExisteProfesor);
         $this->db->bind(':dni_profesor', $dni_profesor);
 
         // Obtener el resultado único
         $result = $this->db->register();
 
         // Verificar si la consulta encontró alguna profesor
         return $result;
     }

     // Read: Obtener la lista de todas las profesores
     public function obtener_profesores()
     {
         $queryObtenerProfesores = "SELECT * FROM profesor";
         $this->db->query($queryObtenerProfesores);
         return $this->db->registers();
     }

     //Read: Obtener profesores activos
    public function obtener_profesores_activos()
    {
        $queryObtenerProfesores = "SELECT * FROM profesor 
                                   WHERE profesor.deletedAt IS NULL";

        $this->db->query($queryObtenerProfesores);
        return $this->db->registers();
    }

    //Read: Obtener la lista de comisiones activas
    public function obtener_profesores_inactivos()
    {
        $queryObtenerProfesores = "SELECT * FROM profesor 
                                    WHERE profesor.deletedAt IS NOT NULL";

        $this->db->query($queryObtenerProfesores);
        return $this->db->registers(); 
    }
      // Update: Editar una profesor existente
    public function editar_profesor($data)
    {
        // Verificar si la profesor existe
        if (!$this->buscar_profesor_por_dni($data['dni_profesor'])) {
            $this->error_mensaje = "El profesor con DNI " . $data['dni_profesor'] . " no existe.";
            return false; // Retorna una bandera indicando que no se encontró la profesor
        }

        // Consulta para actualizar solo los campos que no son DNI
        $queryEditarProfesor = "UPDATE profesor 
                            SET dni_profesor = :dni_profesor,
                            nombre_profesor = :nombre_profesor,	
                            apellido_profesor = :apellido_profesor,	
                            email_profesor = :email_profesor
                            WHERE dni_profesor = :dni_profesor";
        $this->db->query($queryEditarProfesor);

        // Vincular los parámetros
        $this->db->bind(':dni_profesor', $data['dni_profesor']);
        $this->db->bind(':nombre_profesor', $data['nombre_profesor']);
        $this->db->bind(':apellido_profesor', $data['apellido_profesor']);
        $this->db->bind(':email_profesor', $data['email_profesor']);

        // Ejecutar la consulta
        return $this->db->execute();
    }

      // Delete: Soft Delete de un profesor configurando el campo deletedAt
      public function eliminar_profesor($dni_profesor)
      {
          // Verificar si la comisión existe
          $profesor = $this->buscar_profesor_por_dni($dni_profesor);
          if (!$profesor) {
              $this->error_mensaje = "El profesor con DNI " . $dni_profesor . " no existe.";
              return false;
          }
  
  
          // Consulta para establecer el campo deletedAt con la fecha y hora actuales
          $querySoftDeleteProfesor = "UPDATE profesor 
                                  SET deletedAt = :deletedAt 
                                  WHERE dni_profesor = :dni_profesor";
          $this->db->query($querySoftDeleteProfesor);
  
          // Vincular los parámetros
          $this->db->bind(':dni_profesor', $dni_profesor);
          $this->db->bind(':deletedAt', date('Y-m-d H:i:s')); // Establecer la fecha y hora actual
  
          // Ejecutar la consulta
          return $this->db->execute();
      }

        // Delete: Subir de una comisión ya dada de baja.
    public function subir_profesor($dni_profesor)
    {
        // Verificar si la comisión existe
        $profesor = $this->buscar_profesor_por_dni($dni_profesor);
        if (!$profesor) {
            $this->error_mensaje = "El profesor con el DNI " . $dni_profesor . " no existe.";
            return false;
        }

        // Consulta para establecer el campo deletedAt con la fecha y hora actuales
        $queryUpdateProfesor = "UPDATE profesor
                                    SET deletedAt = NULL 
                                    WHERE dni_profesor = :dni_profesor";
        $this->db->query($queryUpdateProfesor);

        // Vincular los parámetros
        $this->db->bind(':dni_profesor', $dni_profesor);

        // Ejecutar la consulta
        return $this->db->execute();
    }

    public function obtenerMateriasDisponibles($dni_profesor)
    {
        // Preparamos la consulta SQL para obtener todas las materias
        // que no estén asociadas a la profesor especificada.
        $sql = "
        SELECT * FROM materia
        WHERE id_materia NOT IN (
            SELECT id_materia 
            FROM materia_profesor 
            WHERE dni_profesor = :dni_profesor
        )
    ";

        // Ejecutamos la consulta y vinculamos el parámetro :dni_profesor
        $this->db->query($sql);
        $this->db->bind(':dni_profesor', $dni_profesor);

        // Obtenemos los resultados de la consulta y los retornamos
        return $this->db->registers();
    }

        public function asociarMateriaProfesor($id_materia, $dni_profesor)
    {
        // Preparamos la consulta SQL para insertar un nuevo registro
        // en la tabla materia_profesor.
        $sql = "
        INSERT INTO materia_profesor (id_materia, dni_profesor)
        VALUES (:id_materia, :dni_profesor)
    ";

        // Ejecutamos la consulta y vinculamos los parámetros
        $this->db->query($sql);
        $this->db->bind(':id_materia', $id_materia);
        $this->db->bind(':dni_profesor', $dni_profesor);


        // Retornamos el resultado de la ejecución de la consulta
        return $this->db->execute();
    }
}

?>