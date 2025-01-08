<?php

require_once RUTA_APP . '/helpers/password_creator.php';


class AuthController extends BaseController
{
    // ---- Atributos del AuthController ---- //
    private $authModel;

    // ---- Constructor: Instanciamos los modelos necesarios para la autenticacion ---- //
    public function __construct()
    {
        // AuthModel
        $this->authModel = $this->model('AuthModel');
    }

    // [GET] Login: Llamamos a la vista del login con blaqueo de error //  
    public function login()
    {
        $data = [
            'error_login' => '',
        ];
        $this->view('pages/index', $data);
    }


    // [POST] LoginUsuario: Verifica los datos, realiza el logueo y redirige al panel de Uusuario //
    public function loginUsuario()
    {

        // --- Obtenemos el valor del nombre del input ---//
        $data = [
            'nombre_usuario' => $_POST['username']
        ];

        // --- Buscamos el usuario por nombre (llamamos a la funcion de buscar) //
        $usuario = $this->authModel->buscar_por_nombre($data);

        // Validaciones //

        // --- Valido la existencia del usuario --- //
        if ($usuario) {

            // Obtengo el valor del input de la constraseña
            $clave = $_POST['password'];

            // Si existe, valido que la contraseña sea correcta
            if ($clave == $usuario->pass) {

                // Si es correcta, me redireccina a la vista usuario o admin
                if ($_POST['username'] == 'univ2024') {
                    // Obtengo los datos de la sesion del usuario
                    $_SESSION['id_usuario'] = $usuario->id_usuario;
                    $_SESSION['nombre_usuario'] = $usuario->nombre_usuario;
                    $this->view('pages/admin/portalAdmin', $data);
                } else {

                    // Obteno el usuario completo que relaciona al alumno
                    $usuarioCompleto = $this->authModel->obtener_usuario_completo($usuario->nombre_usuario);

                    // Obtengo los datos de la sesion del usuario
                    $_SESSION['id_usuario'] = $usuario->id_usuario;
                    $_SESSION['nombre_usuario'] = $usuario->nombre_usuario;
                    $_SESSION['nombre_alumno'] = $usuarioCompleto->nombre_alumno;
                    $_SESSION['carrera_alumno'] = $usuarioCompleto->carrera_id;
                    $this->view('pages/alumno/portalAlumno', $data);
                }
            } else {
                // Caso contrario, se muestra un mensaje de error
                $data = [
                    'error_login' => 'Contraseña incorrecta.',
                ];

                $this->view('pages/index', $data);
            }
        } else {

            // Caso contrario, se muestra un mensaje de error
            $data = [
                'error_login' => 'Usuario o contraseña incorrectos.',
            ];
            $this->view('pages/index', $data);
        }
    }

    public function reset()
    {

        $data = [
            'error_recupero_clave' => '',
            'exito_recupero_clave' => ''
        ];
        $this->view('pages/auth/reset', $data);
    }


    public function resetPasswordAction()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitizar y almacenar los datos del formulario
            $data = [
                'email_alumno' => trim($_POST['email']),
                'error_recupero_clave' => '',
                'exito_recupero_clave' => ''
            ];

            // Buscar el usuario asociado al mail
            $usuario = $this->authModel->buscar_por_email($data['email_alumno']);

            if (!$usuario) {

                // Si no se encuentra el usuario, mostrar error
                $data['error_recupero_clave'] = 'El correo electrónico ingresado no está registrado.';
                $this->view('pages/auth/reset', $data);

                return;
            }

            // Generar una clave temporal
            $nuevaClave = create_pass(8);

            // Intentar modificar la clave
            if (!$this->authModel->change_pass($nuevaClave, $usuario->id_usuario)) {
                // Muestra el error si el usuario ya existe
                $data['error_recupero_clave'] = $this->authModel->getMensajeError();

                $this->view('pages/auth/reset', $data);
                return;
            } else {

                // Enviar un correo electrónico al usuario con la nueva contraseña
                $to = $data['email_alumno'];
                $subject = "Recuperación de contraseña";
                $message = "
                Hola,
                
                Tu contraseña ha sido reestablecida exitosamente. Aquí está tu nueva contraseña:
                
                Contraseña: $nuevaClave
                
                Te recomendamos cambiar tu contraseña una vez inicies sesión.
                
                Saludos,
                Equipo de Soporte.
            ";
                $headers = "From: no-reply@tu-sitio.com\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                // Enviar correo
                if (mail($to, $subject, $message, $headers)) {
                    $data['exito_recupero_clave'] = 'Recupero de clave exitoso. Revisa tu correo.';
                } else {
                    $data['error_recupero_clave'] = 'No se pudo enviar el correo con la nueva contraseña.';
                }

                // Mostrar mensajes en la vista
                $this->view('pages/auth/reset', $data);
            }
        } else {
            $data = ['error_crear_usuario' => ''];
            $data = ['exito_recupero_clave' => ''];
            $this->view('pages/auth/reset', $data);
        }
    }

    /* Método para cerrar la sesión */

    public function logout()
    {

        session_unset();
        session_destroy();

        $this->view('pages/index');
    }
}
