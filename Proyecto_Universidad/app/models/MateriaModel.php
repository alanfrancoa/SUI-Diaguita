<?php

class MateriaModel


{
    //propiedades//
    private $db;
    private $error_mensaje;

    public function __construct()
    {
        $this->db = new Database;
    }


      // ----- Funciones del MateriaModel ----- //

      //Asociar profesor y Materia//
    //metodo para desvincular profesor
    public function desvincularProfesorDeMateria($id_materia, $dni_profesor) {
        $this->db->query("
            DELETE FROM materia_profesor 
            WHERE id_materia = :id_materia AND dni_profesor = :dni_profesor
        ");
        $this->db->bind(':id_materia', $id_materia);
        $this->db->bind(':dni_profesor', $dni_profesor);
    
        return $this->db->execute();
    }
    
    public function obtenerProfesoresPorMateria($id_materia)
    {
        // Preparamos la consulta SQL para obtener los profesores asociadas a la materia.
        // Utilizamos un INNER JOIN para relacionar las tablas profesores y materia_profesor.
        $sql = "
        SELECT p.* 
        FROM profesor p
        INNER JOIN materia_profesor mp ON mp.dni_profesor = p.dni_profesor
        WHERE mp.id_materia = :id_materia
    ";

        // Ejecutamos la consulta y vinculamos el parámetro :id_materia
        $this->db->query($sql);
        $this->db->bind(':id_materia', $id_materia);

        // Obtenemos los resultados de la consulta y los retornamos
        return $this->db->registers();
    }


     // ----- Funciones del AuthModel ----- //

     public function getMensajeError()
     {
         return $this->error_mensaje;
     }

    
    // -----Funciones----- //


// Método para verificar si existe una materia con el mismo nombre y comision_id
    public function buscar_materia_por_nombre($nombre_materia, $comision_id)
    {
    // Consulta para verificar si existe una materia con el mismo nombre y comision_id
    $query = "SELECT * FROM materia WHERE nombre_materia = :nombre_materia AND comision_id = :comision_id AND deletedAt IS NULL";
    $this->db->query($query);

    // Vincular los parámetros
    $this->db->bind(':nombre_materia', $nombre_materia);
    $this->db->bind(':comision_id', $comision_id);

    // Ejecutar la consulta y obtener el resultado
    $result = $this->db->register();

    // Si encuentra una materia, retorna el resultado (significa que ya existe)
    return $result;
    }

    // Create: Crear una nueva materia
    public function crear_materia($data)
    {
        // Verificar si la materia ya existe antes de intentar crearla
        if ($this->buscar_materia_por_nombre($data['nombre_materia'], $data['comision_id'])) {
            $this->error_mensaje = "La materia con el nombre " . $data['nombre_materia'] . " ya existe en esta comisión.";
            return false; // Retorna una bandera si la materia ya existe
        }

        unset($data['id_materia']);

        // preparamos la Consulta para insertar una nueva materia
        $queryCrearMateria = "INSERT INTO materia (nombre_materia, comision_id) 
                               VALUES (:nombre_materia, :comision_id)";
        $this->db->query($queryCrearMateria);

        // Vincular los parámetros
        $this->db->bind(':nombre_materia', $data['nombre_materia']);
        $this->db->bind(':comision_id', $data['comision_id']);

        // Ejecutar la consulta
        return $this->db->execute();
    }

    // Read: busca por id una materia con el ID proporcionado
    public function buscar_materia_por_id($id_materia)
    {
        // Consulta para verificar si la materia existe
        $queryExisteMateria = "SELECT * FROM materia WHERE id_materia = :id_materia";

        //pasamos la query al metodo
        $this->db->query($queryExisteMateria);
        $this->db->bind(':id_materia', $id_materia);

        // Obtener el resultado único
        $result = $this->db->register();

        // Verificar si la consulta encontró alguna materia
        return $result;
    }



    //  // Read: Obtener la lista de todas las materias
    //  public function obtener_materias()
    //  {  //preparo query//
    //      $queryObtenerMaterias = "SELECT id_materia , nombre_materia, comision_id FROM materia";

    //      //pasamos la consulta a la query//
    //      $this->db->query($queryObtenerMaterias);
    
    //     //retorno metodo php para consultas select registers//
    //      return $this->db->registers();
    //     }


    //SOFT-DELETE materias activas e inactivas//

     // Read: Obtener la lista de todas las materias
     public function obtener_materias_todas()
     {
         $queryObtenerMaterias = "SELECT * FROM materia";
         $this->db->query($queryObtenerMaterias);
         return $this->db->registers(); // Cambia a registers() para obtener los datos
     }
    //Read: Obtener la lista de materias activas
    public function obtener_materias_activas()
    {
        $queryObtenerMaterias = "SELECT * FROM materia WHERE materia.deletedAt IS NULL";
        $this->db->query($queryObtenerMaterias);
        return $this->db->registers(); // Cambia a registers() para obtener los datos
    }

    //Read: Obtener la lista de materias activas
    public function obtener_materias_inactivas()
    {
        $queryObtenerMaterias = "SELECT * FROM materia WHERE materia.deletedAt IS NOT NULL";
        $this->db->query($queryObtenerMaterias);
        return $this->db->registers(); // Cambia a registers() para obtener los datos
    }
    

    public function editar_materia($data)
    {
            // Verificar si la materia existe
            if (!$this->buscar_materia_por_id($data['id_materia'])) {
                $this->error_mensaje = "La materia con ID " . $data['id_materia'] . " no existe.";
                return false; // Retorna una bandera indicando que no se encontró la materia
            }
    
            // Consulta para actualizar solo los campos que no son ID
            $queryEditarMateria = "UPDATE materia 
             SET nombre_materia = :nombre_materia, comision_id = :comision_id 
             WHERE id_materia = :id_materia";
             
             $this->db->query($queryEditarMateria);
    

              
            // Vincular los parámetros (sin modificar el ID)
            $this->db->bind(':id_materia', $data['id_materia']);
            $this->db->bind(':nombre_materia', $data['nombre_materia']);
            $this->db->bind(':comision_id', $data['comision_id']);
    
            // Ejecutar la consulta
            return $this->db->execute();
        }


         // Delete: Soft Delete de una materia configurando el campo deletedAt
    public function eliminar_materia($id_materia)
    {
        // Verificar si la materia existe
        $materia = $this->buscar_materia_por_id($id_materia);
        if (!$materia) {
            $this->error_mensaje = "La materia con ID " . $id_materia . " no existe.";
            return false;
        }


        // Consulta para establecer el campo deletedAt con la fecha y hora actuales
        $querySoftDeleteMateria = "UPDATE materia 
                                SET deletedAt = :deletedAt 
                                WHERE id_materia = :id_materia";
        $this->db->query($querySoftDeleteMateria);

        // Vincular los parámetros
        $this->db->bind(':id_materia', $id_materia);
        $this->db->bind(':deletedAt', date('Y-m-d H:i:s')); // Establecer la fecha y hora actual

        // Ejecutar la consulta
        return $this->db->execute();
    }

// Delete: Subir de una materia ya dada de baja.
public function subir_materia($id_materia)
{
    // Verificar si la materia existe
    $materia = $this->buscar_materia_por_id($id_materia);
    if (!$materia) {
        $this->error_mensaje = "La materia con ID " . $id_materia . " no existe.";
        return false;
    }

    // Consulta para establecer el campo deletedAt con la fecha y hora actuales
    $queryUpdateMateria = "UPDATE materia 
                                SET deletedAt = NULL 
                                WHERE id_materia = :id_materia";
    $this->db->query($queryUpdateMateria);

    // Vincular los parámetros
    $this->db->bind(':id_materia', $id_materia);

    // Ejecutar la consulta
    return $this->db->execute();
}

  
    public function obtenerProfesoresDisponibles($id_materia)
    {
        // Preparamos la consulta SQL para obtener todas los profesores
        // que no estén asociadas a la materia especificada.
        $sql = "
        SELECT * FROM profesor
        WHERE dni_profesor NOT IN (
            SELECT dni_profesor 
            FROM materia_profesor 
            WHERE id_materia = :id_materia
        )
    ";

        // Ejecutamos la consulta y vinculamos el parámetro :id_materia
        $this->db->query($sql);
        $this->db->bind(':id_materia', $id_materia);

        // Obtenemos los resultados de la consulta y los retornamos
        return $this->db->registers();
    }

   
    // Asocia un profesor a una materia específica.
    //
    // Esta función inserta un nuevo registro en la tabla materia_profesor
    // para establecer la relación entre el profesor y la materia.//
    public function asociarProfesorAMateria($id_materia, $dni_profesor)
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