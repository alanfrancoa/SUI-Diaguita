<?php

class AuthModel
{

    // ---- Defino la propiedad db ---- //
    private $db;
    private $error_mensaje;

    // ---- Constructor para instanciar la propiedad db ---- //
    public function __construct()
    {
        $this->db = new Database;
    }

    // ----- Funciones del AuthModel ----- //

    public function getMensajeError()
    {
        return $this->error_mensaje;
    }

    // Create: Dar de alta un usuario 
    public function crear_usuario($data)
    {

        // Verificamos si el usuario creado ya existe
        if ($this->buscar_por_nombre(['nombre_usuario' => $data['nombre_usuario']])) {
            $this->error_mensaje = "El usaurio ya existe, por favor intente otro nombre.";
            return false;
        }

        //Se crea la key para encriptar
        $keyw = "keyword";

        // Iniciamos la transacción
        $this->db->beginTransaction();

        // Preparamos la consulta para insertar un usuario en la tabla Autenticacion
        $queryCrearUsuario = "INSERT INTO autenticacion (nombre_usuario, clave_usuario) VALUES (:nombre_usuario, aes_encrypt(:clave_usuario, :keyw))";

        $this->db->query($queryCrearUsuario);

        // Vinculamos los parametros
        $this->db->bind('nombre_usuario', $data['nombre_usuario']);
        $this->db->bind('clave_usuario', $data['clave_usuario']);
        $this->db->bind('keyw', $keyw);

        // Ejecutamos la inserseccion en Autenticacion
        if ($this->db->execute()) {

            // Obtenemos el ID del nuevo usuario
            $idUsuario = $this->db->lastId();

            // Creamos la query de Cerar alumno
            $queryCrearAlumno = "INSERT INTO alumno (dni_alumno, nombre_alumno, apellido_alumno, email_alumno, usuario_id, carrera_id) VALUES (:dni_alumno, :nombre_alumno, :apellido_alumno, :email_alumno, :usuario_id, :carrera_id)";

            $this->db->query($queryCrearAlumno);

            // Vinculamos los parametros 
            $this->db->bind('dni_alumno', $data['nombre_usuario']);
            $this->db->bind('nombre_alumno', $data['nombre_alumno']);
            $this->db->bind('apellido_alumno', $data['apellido_alumno']);
            $this->db->bind('email_alumno', $data['email_alumno']);
            $this->db->bind('usuario_id', $idUsuario);
            $this->db->bind('carrera_id', $data['carrera_id']);

            // Ejecutamos la insercion de Alumno
            if ($this->db->execute()) {
                // Confirmamos la transacción si ambas inserciones fueron exitosas
                $this->db->commit();
                return true;
            } else {
                // Revertimos si la inserción en Alumno falla
                $this->db->rollBack();
                $this->error_mensaje = "Error al crear el registro en Alumno.";
                return false;
            }
        } else {
            // Revertimos si la inserción en Autenticacion falla
            $this->db->rollBack();
            $this->error_mensaje = "Error al crear el usuario.";
            return false;
        }
    }

    // Read: Busar por nombre para comprobar si existe
    public function buscar_por_nombre($data)
    {

        // Preparamos la consulta
        $queryBuscarUsuario = "SELECT id_usuario, nombre_usuario, aes_decrypt(clave_usuario, 'keyword') AS pass, deletedAt FROM autenticacion WHERE nombre_usuario = :nombre_usuario";

        // Pasamos la query al metodo 
        $this->db->query($queryBuscarUsuario);

        // Ejecutamos la consulta
        $this->db->bind('nombre_usuario', $data['nombre_usuario']);

        // Obtenemos un resultado
        $result = $this->db->register();

        // Devolvemos dicho resultado
        return $result;
    }

    // Read: Busar por email para comprobar si existe
    public function buscar_por_email($email)
    {
        // Consulta para obtener el usuario a partir del email
        $query = "SELECT a.id_usuario 
              FROM alumno al 
              INNER JOIN autenticacion a 
              ON al.usuario_id = a.id_usuario 
              WHERE al.email_alumno = :email";

        // Preparar la consulta
        $this->db->query($query);

        // Asociar el email al parámetro
        $this->db->bind(':email', $email);

        // Ejecutar y devolver el registro encontrado
        return $this->db->register();
    }

    // Read: Obtener un Usuario compleot con su Alukno relacionado
    public function obtener_usuario_completo($nombre_usuario)
    {
        // Consulta para obtener datos del usuario y del alumno relacionado
        $query = "
        SELECT 
            a.id_usuario, 
            a.nombre_usuario, 
            aes_decrypt(a.clave_usuario, 'keyword') AS pass, 
            a.createdAt,
            a.deletedAt,
            al.dni_alumno, 
            al.nombre_alumno, 
            al.apellido_alumno, 
            al.email_alumno, 
            al.fecha_nacimiento, 
            al.carrera_id, 
            c.nombre_carrera
        FROM 
            autenticacion AS a
        LEFT JOIN 
            alumno AS al 
        ON 
            a.id_usuario = al.usuario_id
        LEFT JOIN 
            carrera AS c
        ON 
            al.carrera_id = c.id_carrera
        WHERE 
            a.nombre_usuario = :nombre_usuario";

        // Pasamos la query al método
        $this->db->query($query);

        // Vinculamos el parámetro
        $this->db->bind('nombre_usuario', $nombre_usuario);

        // Obtenemos un resultado
        return $this->db->register();
    }

    // Read: Obtener una lista de los usuarios
    public function obtener_usuarios()
    {

        // Preparo la query
        $queryObtenerUsuarios = "SELECT * FROM autenticacion WHERE autenticacion.id_usuario >= 2";

        // Paso la query a la funcion para realizar la cosulta
        $this->db->query($queryObtenerUsuarios);

        // Ejecuto la consulta y me devuelve un registro de los usuarios
        return $this->db->registers();
    }

    //Read: Obtener la lista de usuarios activos
    public function obtener_usuarios_activos()
    {
        $queryObtenerUsuariosActivos = "SELECT * FROM autenticacion WHERE autenticacion.deletedAt IS NULL AND autenticacion.id_usuario >= 2";
        $this->db->query($queryObtenerUsuariosActivos);
        return $this->db->registers();
    }

    //Read: Obtener la lista de usuarios inactivos
    public function obtener_usuarios_inactivos()
    {
        $queryObtenerUsuariosInactivos = "SELECT * FROM autenticacion WHERE autenticacion.deletedAt IS NOT NULL";
        $this->db->query($queryObtenerUsuariosInactivos);
        return $this->db->registers();
    }

    // Update: Editar la clave del usuario
    public function change_pass($pass, $idUsuario)
    {

        // Se crea la key para encriptar
        $keyw = 'keyword';

        // Preparo la query para editar la clave del usuario
        $queryEditarUsuario = "UPDATE autenticacion SET
							   clave_usuario = aes_encrypt(:new_pass,:keyword)
							   WHERE id_usuario=:id_usuario";

        // Paso la query a la funcion para realizar la cosulta
        $this->db->query($queryEditarUsuario);

        // Pasamos por parametros los valores 
        $this->db->bind(':new_pass', $pass);
        $this->db->bind(':keyword', $keyw);
        $this->db->bind(':id_usuario', $idUsuario);

        // Ejectuamos la consulta
        if ($this->db->execute()) {
            return true;
        } else {
            $this->error_mensaje = "Error al enviar el mail de recupero de contraseña.";
            return false;
        }
    }

    // Delete: Eliminar al usuario
    public function eliminar_usuario($nombre_usuario)
    {
        $this->db->query(
            "UPDATE autenticacion SET
							deletedAt= CURRENT_TIMESTAMP
						 WHERE autenticacion.nombre_usuario=:nombre_usuario"
        );

        $this->db->bind('nombre_usuario', $nombre_usuario);
        if ($this->db->execute()) {
            return true;
        } else {
            $this->error_mensaje = "Error al eliminar el usuario.";
            return false;
        }
    }

    // Reactivar Uusario
    public function reactivar_usuario($nombre_usuario)
    {
        // Verificar si el usurio
        $usuario = $this->obtener_usuario_completo($nombre_usuario);
        if (!$usuario) {
            $this->error_mensaje = "El usuario " . $nombre_usuario . " no existe.";
            return false;
        }


        // Consulta para establecer el campo deletedAt con la fecha y hora actuales
        $queryUpdateComision = "UPDATE autenticacion 
                                    SET deletedAt = NULL 
                                    WHERE autenticacion.nombre_usuario=:nombre_usuario";

        $this->db->query($queryUpdateComision);

        // Vincular los parámetros
         $this->db->bind(':nombre_usuario', $nombre_usuario);

        // Ejecutar la consulta
        if ($this->db->execute()) {
            return true;
        } else {
            $this->error_mensaje = "Error al reactivar al usuario.";
            return false;
        }
    }

    
}
