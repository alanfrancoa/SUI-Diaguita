<?php

class AlumnoController extends BaseController
{
    // ---- Atributos del AuthController ---- //
    private $authModel;
    private $alumnoModel;

    // ---- Constructor: Instanciamos los modelos necesarios para la autenticacion ---- //
    public function __construct()
    {
        // AuthModel
        $this->authModel = $this->model('AuthModel');
        // AlumnoModel
        $this->alumnoModel = $this->model('AlumnoModel');
    }

    // Método para mostrar el portal del Alumno
    public function index()
    {
        $this->view('pages/alumno/portalAlumno');
    }

    // [GET] perfilAlumnoVista: Llamamos a la vista del pefil del alumno //  
    public function perfilAlumnoVista()
    {
        $nombre_usuario = $_SESSION['nombre_usuario'];

        $usuarioCompleto = $this->authModel->obtener_usuario_completo($nombre_usuario);

        // Inicializamos el arreglo de datos para pasar a la vista
        $data = ['usuario' => $usuarioCompleto];

        $this->view('pages/alumno/perfil/alumno_perfil', $data);
    }

    // [GET] editarClaveVista: Llamamos a la vista para editar la clave //  
    public function editarClaveVista()
    {
        $data = [
            'error_cambio_clave' => '',
            'exito_cambio_clave' => ''
        ];
        $this->view('pages/alumno/clave/editar_clave', $data);
    }

    // [POST] editarClaveAction: Llamamos a la vista para editar la clave //  
    public function editarClaveAction()
    {
        $nombre_usuario = $_SESSION['nombre_usuario'];

        $usuarioCompleto = $this->authModel->obtener_usuario_completo($nombre_usuario);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitizar y almacenar los datos del formulario
            $data = [
                'pass_antigua' => trim($_POST['old_password']),
                'pass_nueva' => trim($_POST['new_password']),
                'pass_nueva_confirmacion' => trim($_POST['confirm_password']),
                'error_cambio_clave' => '',
                'exito_cambio_clave' => ''
            ];

            // Verificamos que la clave antigua sea la correcta
            if ($data['pass_antigua'] != $usuarioCompleto->pass) {
                $data['error_cambio_clave'] = 'La clave actual es incorrecta';
                $this->view('pages/alumno/clave/editar_clave', $data);
                return;
            }

            // Verificamos la clave nueva debe tener al menos 8 caracteres
            if (strlen($data['pass_nueva']) < 8) {
                $data['error_cambio_clave'] = 'La nueva contraseña debe tener al menos 8 caracteres';
                $this->view('pages/alumno/clave/editar_clave', $data);
                return;
            }

            // Verificamos que tanto la clave nueva como la confirmacion sean iguales
            if ($data['pass_nueva'] == $data['pass_nueva_confirmacion']) {

                // Si ambas claves estan bien, realizo el cambio de calve
                if (!$this->authModel->change_pass($data['pass_nueva'], $usuarioCompleto->id_usuario)) {

                    // Muestra el error si hubo un error
                    $data['error_cambio_clave'] = 'No se pudo modificar la clave';

                    $this->view('pages/alumno/clave/editar_clave', $data);
                    return;
                } else {
                    $data['exito_cambio_clave'] = 'Cambio de clave exitoso';
                    $this->view('pages/alumno/clave/editar_clave', $data);
                    return;
                }
            } else {
                $data['error_cambio_clave'] = 'No coinciden las nuevas claves';
                $this->view('pages/alumno/clave/editar_clave', $data);
                return;
            }
        } else {
            $data = ['error_cambio_clave' => ''];
            $data = ['exito_cambio_clave' => ''];
            $this->view('pages/alumno/clave/editar_clave', $data);
        }
    }

    // [GET] editarClaveVista: Llamamos a la vista para editar la clave //  
    public function editarPerfilVista()
    {

        $nombre_usuario = $_SESSION['nombre_usuario'];

        $usuarioCompleto = $this->authModel->obtener_usuario_completo($nombre_usuario);

        $data = [
            'error_editar_perfil' => '',
            'exito_editar_perfil' => '',
            'alumno' => null
        ];

        $data['alumno'] = $usuarioCompleto;


        $this->view('pages/alumno/perfil/editar_perfil', $data);
    }

    // [POST] editarPerfilAction: Fucnio para realizar la accion de editar el perfil //  
    public function editarPerfilAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [
                'error_editar_perfil' => '',
                'exito_editar_perfil' => ''
            ];

            $nombre_usuario = $_SESSION['nombre_usuario'];
            $usuarioCompleto = $this->authModel->obtener_usuario_completo($nombre_usuario);

            // Recoger los datos del formulario
            $idAlumno = $usuarioCompleto->dni_alumno;
            $nombre = $_POST['nombre-alumno'] ?? '';
            $apellido = $_POST['apellido-alumno'] ?? '';
            $email = $_POST['email-alumno'] ?? '';
            $fechaNacimiento = $_POST['fecha-nacimiento-alumno'] ?? null; // Si la fecha está vacía, se mantiene como null

            // Validar los datos (opcional)
            if (empty($nombre) || empty($apellido) || empty($email)) {
                $data['error_editar_perfil'] = 'Todos los campos son obligatorios.';
            } else {
                // Verificar si el email ya está registrado
                if ($this->alumnoModel->verificarEmailExistente($email, $idAlumno)) {
                    $data['error_editar_perfil'] = 'El correo electrónico ya está registrado.';
                } else {
                    // Llamar al modelo para actualizar el perfil
                    if ($this->alumnoModel->editarAlumno($idAlumno, $nombre, $apellido, $email, $fechaNacimiento)) {
                        $data['exito_editar_perfil'] = 'Perfil actualizado correctamente.';
                        $_POST['nombre-alumno'] = '';
                        $_POST['apellido-alumno'] = '';
                        $_POST['email-alumno'] = '';
                        $_POST['fecha-nacimiento-alumno'] = '';
                    } else {
                        $data['error_editar_perfil'] = $this->alumnoModel->getMensajeError();
                    }
                }
            }

            // Pasar los datos al formulario de la vista
            $data['alumno'] = $usuarioCompleto;
            $this->view('pages/alumno/perfil/editar_perfil', $data);
        }
    }

    // Método para obtener las materias del alumno según la carrera
    public function getMateriasAlumno()
    {

        $idCarrera = $_SESSION['carrera_alumno'];

        // Obtener las materias asociadas a la carrera
        $materias = $this->alumnoModel->obtenerMateriasPorCarrera($idCarrera);

        // Cargar la vista y pasar los datos
        $data = [
            'materias' => $materias,
        ];

        $this->view('pages/alumno/materias/ver_materias', $data);
    }
}
