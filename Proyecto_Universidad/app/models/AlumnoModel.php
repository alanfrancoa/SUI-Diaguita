<?php

class AlumnoModel

{
    //propiedades//
    private $db;
    private $error_mensaje;

    public function __construct()
    {
        $this->db = new Database;
    }


    // ----- Funciones del AuthModel ----- //

    public function getMensajeError()
    {
        return $this->error_mensaje;
    }


    // -----Funciones----- //

    // Editar el perfil del alumno
    public function editarAlumno($dniAlumno, $nombre, $apellido, $email, $fechaNacimiento)
    {
        // Verifica si la fecha de nacimiento fue proporcionada
        if (empty($fechaNacimiento)) {
            // Si no se proporcionó fecha, excluye la fecha de la consulta
            $queryEditarAlumno = "UPDATE alumno 
            SET nombre_alumno = :nombre, 
                apellido_alumno = :apellido, 
                email_alumno = :email
            WHERE dni_alumno = :dni_alumno";
        } else {
            // Si la fecha fue proporcionada, incluye la fecha en la consulta
            $queryEditarAlumno = "UPDATE alumno 
            SET nombre_alumno = :nombre, 
                apellido_alumno = :apellido, 
                email_alumno = :email, 
                fecha_nacimiento = :fechaNacimiento
            WHERE dni_alumno = :dni_alumno";
        }

        // Prepara y ejecuta la consulta
        $this->db->query($queryEditarAlumno);
        $this->db->bind(':nombre', $nombre);
        $this->db->bind(':apellido', $apellido);
        $this->db->bind(':email', $email);
        $this->db->bind(':dni_alumno', $dniAlumno);

        // Si la fecha fue proporcionada, vincúlala
        if (!empty($fechaNacimiento)) {
            $this->db->bind(':fechaNacimiento', $fechaNacimiento);
        }

        // Ejectuamos la consulta
        if ($this->db->execute()) {
            return true;
        } else {
            $this->error_mensaje = "Error al editar el perfil del alumno.";
            return false;
        }
    }

    // Verifica si el email existe
    public function verificarEmailExistente($email, $dniAlumno)
    {
        // Excluir el alumno actual al verificar si el email ya está en uso
        $query = "SELECT COUNT(*) as count FROM alumno WHERE email_alumno = :email AND dni_alumno != :dni_alumno";

        // Ejecutar la consulta
        $this->db->query($query);
        $this->db->bind(':email', $email);
        $this->db->bind(':dni_alumno', $dniAlumno);

        // Obtener el resultado
        $resultado = $this->db->register();

        /// Si el resultado es mayor que 0, significa que el correo ya está registrado
        return $resultado && $resultado->count > 0;
    }
    
    // Obtener materias por id_carrera
    public function obtenerMateriasPorCarrera($idCarrera)
    {
        $query = "SELECT m.id_materia, m.nombre_materia 
                  FROM materia AS m
                  INNER JOIN carrera_materia AS cm ON m.id_materia = cm.id_materia
                  WHERE cm.id_carrera = :id_carrera";
    
        $this->db->query($query);
        $this->db->bind(':id_carrera', $idCarrera);
    
        return $this->db->registers(); // Devuelve una lista de materias
    }
}
