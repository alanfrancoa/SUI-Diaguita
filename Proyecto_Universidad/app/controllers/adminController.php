<?php
// Clase controladora para la administración
class adminController extends BaseController
{
    // ---- Atributos del adminController ---- //
    private $comisionModel;
    private $profesorModel;
    private $carreraModel;
    private $authModel;
    private $materiaModel;

    // ---- Constructor: Instanciamos los modelos necesarios para los ABMs ---- //
    public function __construct()
    {
        // Instancia del modelo ComisionModel para gestionar comisiones
        $this->comisionModel = $this->model('ComisionModel');
        $this->profesorModel = $this->model('ProfesorModel');
        $this->carreraModel = $this->model('CarreraModel');
        $this->authModel = $this->model('AuthModel');
        $this->materiaModel = $this->model('MateriaModel');
    }

    // Método para mostrar el portal del Admin
    public function index()
    {
        $this->view('pages/admin/portalAdmin');
    }

    //--------------------ABM COMISIONES----------------------------


    // Método para mostrar la vista del ABM de comisiones, con listado de comisiones activas
    public function abmComisiones()
    {
        // Obtener listado de comisiones
        $comisiones = $this->comisionModel->obtener_comisiones_activas();
        $this->view('pages/admin/comisiones/abm_comisiones', ['comisiones' => $comisiones]);
    }

    // Método para mostrar la vista del ABM de comisiones, con listado de comisiones activas
    public function abmComisionesInactivas()
    {
        // Obtener listado de comisiones
        $comisiones = $this->comisionModel->obtener_comisiones_inactivas();
        $this->view('pages/admin/comisiones/abm_comisiones_inactivas', ['comisiones' => $comisiones]);
    }

    // Método para mostrar la vista del ABM de comisiones, con listado de todas las comisiones, activas e inactivas. 
    public function abmComisionesTodas()
    {
        // Obtener listado de comisiones
        $comisiones = $this->comisionModel->obtener_comisiones_todas();
        $this->view('pages/admin/comisiones/abm_comisiones_todas', ['comisiones' => $comisiones]);
    }

    // Get: Método para mostrar la vista de alta de comisiones
    public function altaComisionesVista()
    {

        $this->view('pages/admin/comisiones/alta_comisiones');
    }

    // Método para procesar la acción de alta de una comisión
    // POST : Acción para crear una nueva comisión con verificación de existencia
    public function altaComisionAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitizar y almacenar los datos del formulario
            $data = [
                'id_comision' => trim($_POST['id-comision']),
                'horario_comision' => trim($_POST['turno-comision']),
                'dia_comision' => trim($_POST['dias-comision']),
                'error_crear_comision' => ''
            ];

            // Intenta crear la comisión
            if (!$this->comisionModel->crear_comision($data)) {
                // Mostrar error si la comisión ya existe
                $data['error_crear_comision'] = $this->comisionModel->getMensajeError();
                $this->view('pages/admin/comisiones/alta_comisiones', $data);
            } else {
                // Obtener listado actualizado de comisiones y mensaje de éxito
                $comisiones = $this->comisionModel->obtener_comisiones_activas();
                $mensaje = "La comisión fue agregada exitosamente.";

                // Redirigir a la vista de ABM de comisiones con el listado y el mensaje
                $this->view('pages/admin/comisiones/abm_comisiones', [
                    'comisiones' => $comisiones,
                    'mensaje' => $mensaje
                ]);
            }
        } else {
            // En caso de que no sea POST, cargar la vista de alta de comisiones
            $data = ['error_crear_comision' => ''];
            $this->view('pages/admin/comisiones/alta_comisiones', $data);
        }
    }


    // POST: Acción para modificar una comisión
    public function modificarComisionAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitizar y almacenar los datos recibidos del formulario
            $data = [
                'id_comision' => trim($_POST['id-comision']),
                'horario_comision' => trim($_POST['turno-comision']),
                'dia_comision' => trim($_POST['dias-comision']),
                'error_modificar_comision' => ''
            ];

            // Intentar modificar la comisión usando el modelo
            if (!$this->comisionModel->editar_comision($data)) {
                // Si falla, obtener el mensaje de error y mostrarlo en la vista de modificación
                $data['error_modificar_comision'] = $this->comisionModel->getMensajeError();
                $this->view('pages/admin/comisiones/modificar_comisiones', $data);
            } else {
                // Si la modificación es exitosa, obtener todas las comisiones y redirigir a la vista de ABM
                $comisiones = $this->comisionModel->obtener_comisiones_activas();
                $mensaje = "Comisión con ID " . htmlspecialchars($data['id_comision']) . " editada correctamente.";
                $this->view('pages/admin/comisiones/abm_comisiones', [
                    'comisiones' => $comisiones,
                    'mensaje' => $mensaje
                ]);
            }
        } else {
            // En caso de que no sea una solicitud POST, redirigir a la vista de modificación
            $this->view('pages/admin/comisiones/modificar_comisiones');
        }
    }

    //GET
    public function modificarComisionesVista($id_comision = null, $mensaje = '')
    {
        // Inicializamos el arreglo de datos para pasar a la vista
        $data = [
            'comision' => null,
            'mensaje' => $mensaje
        ];

        // Si se proporciona un ID de comisión, intentamos obtener la comisión
        if ($id_comision) {
            $comision = $this->comisionModel->buscar_comision_por_id($id_comision);
            if ($comision) {
                // Cargar la comisión encontrada en los datos a enviar a la vista
                $data['comision'] = $comision;
            } else {
                // Si la comisión no existe, cargar un mensaje de error
                $data['mensaje'] = "La comisión con ID $id_comision no se encontró.";
            }
        }

        // Cargar la vista de modificación de comisiones con los datos de la comisión y mensaje
        $this->view('pages/admin/comisiones/modificar_comisiones', $data);
    }


    // Método para ejecutar baja de comisiones

    public function bajarComision($id_comision = null)
    {
        $mensaje = ''; // Variable para almacenar el mensaje de error o éxito

        // Verificar que se recibió un ID de comisión válido
        if ($id_comision) {
            // Intentar eliminar la comisión usando el modelo
            if (!$this->comisionModel->eliminar_comision($id_comision)) {
                // Si no se pudo eliminar, obtener el mensaje de error del modelo
                $mensaje = $this->comisionModel->getMensajeError();
            } else {
                $mensaje = "Comisión con ID $id_comision ha sido dada de baja.";
            }
        } else {
            $mensaje = "No se proporcionó un ID de comisión válido.";
        }

        // Obtener el listado actualizado de comisiones
        $comisiones = $this->comisionModel->obtener_comisiones_activas();

        // Redirigir a la vista de ABM de comisiones activas, pasando el mensaje y las comisiones
        $this->view('pages/admin/comisiones/abm_comisiones', [
            'comisiones' => $comisiones,
            'mensaje' => $mensaje
        ]);
    }

    public function subirComision($id_comision = null)
    {
        $mensaje = ''; // Variable para almacenar el mensaje de error o éxito

        // Verificar que se recibió un ID de comisión válido
        if ($id_comision) {
            // Intentar resubir la comisión usando el modelo
            if (!$this->comisionModel->subir_comision($id_comision)) {
                // Si no se pudo resubir, obtener el mensaje de error del modelo
                $mensaje = $this->comisionModel->getMensajeError();
            } else {
                $mensaje = "Comisión con ID $id_comision ha sido dada de alta nuevamente.";
            }
        } else {
            $mensaje = "No se proporcionó un ID de comisión válido.";
        }

        // Obtener el listado actualizado de comisiones
        $comisiones = $this->comisionModel->obtener_comisiones_activas();

        // Redirigir a la vista de ABM de comisiones activas, pasando el mensaje y las comisiones
        $this->view('pages/admin/comisiones/abm_comisiones', [
            'comisiones' => $comisiones,
            'mensaje' => $mensaje
        ]);
    }


    //--------------------ABM MATERIAS----------------------------//
    //Metodo para desvicular profesor de materia.
    public function desvincularProfesor()
    {
        $id_materia = $_POST['id_materia'];
        $dni_profesor = $_POST['dni_profesor'];

        if ($this->materiaModel->desvincularProfesorDeMateria($id_materia, $dni_profesor)) {
            $mensaje = 'Profesor desvinculado exitosamente.';
        } else {
            $mensaje = 'Error al desvincular el profesor.';
        }

        // Cargar nuevamente la vista con el mensaje
        $this->detalleMateria($id_materia);
    }
    // Método para mostrar la vista del ABM de materias
    public function abmMaterias()
    {
        $materias = $this->materiaModel->obtener_materias_activas();
        $data = [
            'materias' => $materias
        ];
        $this->view('pages/admin/materias/abm_materias', $data);
    }

    /**
     * Muestra los detalles de una materia, incluyendo sus profes asociados y disponibles.
     *
     * Esta función carga los datos de una materia específica, sus profes asociadas y los profes
     * que aún no están asociados, y luego renderiza la vista correspondiente para mostrar esta información.
     *
     * @param int $id_materia El ID de la materia que se desea mostrar.
     */
    public function detalleMateria($id_materia)
    {
        // Buscamos la información de la materia en el modelo
        $materia = $this->materiaModel->buscar_materia_por_id($id_materia);

        // Obtenemos los proesores asociadas a la materia
        $profesores = $this->materiaModel->obtenerProfesoresPorMateria($id_materia);

        // Obtenemos los profesores disponibles (no asociados) a la materia
        $profesoresDisponibles = $this->materiaModel->obtenerProfesoresDisponibles($id_materia);

        // Preparamos los datos para pasarlos a la vista
        $data = [
            'materia' => $materia,
            'profesores' => $profesores,
            'profesoresDisponibles' => $profesoresDisponibles,
            'mensaje' => '' // Inicializamos el mensaje vacío
        ];

        // Renderizamos la vista con los datos
        $this->view('pages/admin/materias/materia_detalle', $data);
    }

    /**
     * Asocia un profesor a una materia.
     *
     * Esta función recibe los IDs de la materia y el profesor a asociar, llama al modelo para realizar la asociación
     * y luego redirige a la vista de detalles de la materia para mostrar los cambios.
     */
    public function asociarProfesor()
    {
        // Obtenemos los IDs de la materia y el profesor desde el formulario
        $id_materia = $_POST['id_materia'];
        $dni_profesor = $_POST['dni_profesor'];

        // Llamamos al modelo para asociar la materia al profesor
        if ($this->materiaModel->asociarProfesorAMateria($id_materia, $dni_profesor)) {
            $mensaje = 'Profesor asociado exitosamente.';
        } else {
            $mensaje = 'Error al asociar el Profesor.';
        }

        // Redirigimos a la vista de detalles de la materia, pasando el mensaje como dato
        $data = ['mensaje' => $mensaje];
        $this->detalleMateria($id_materia, $data); // Pasamos el mensaje como segundo parámetro
    }




    // Método para mostrar la vista del ABM de materias, con listado de materias activas
    public function abmMateriasInactivas()
    {
        // Obtener listado de materias
        $materias = $this->materiaModel->obtener_materias_inactivas();
        $this->view('pages/admin/materias/abm_materias_inactivas', ['materias' => $materias]);
    }

    // Método para mostrar la vista del ABM de materias, con listado de todas las materias, activas e inactivas. 
    public function abmMateriasTodas()
    {
        // Obtener listado de comisiones
        $materias = $this->materiaModel->obtener_materias_todas();
        $this->view('pages/admin/materias/abm_materias_todas', ['materias' => $materias]);
    }

    //metodo para obtener la vistade materia//
    public function altaMateriaView()
    {
        // Obtener comisiones activas desde el modelo
        $comisiones = $this->comisionModel->obtener_comisiones_activas();

        $this->view('pages/admin/materias/alta_materia', ['comisiones' => $comisiones]);
    }

    //metodo para insertar la materia//
    public function altaMateriaAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitizar y almacenar los datos del formulario
            $data = [
                'nombre_materia' => trim($_POST['nombre-materia']),
                'comision_id' => trim($_POST['comision-materia']),
                'error_crear_materia' => ''
            ];

            // Intentar crear la materia
            if (!$this->materiaModel->crear_materia($data)) {
                // Muestra el error si la materia ya existe
                $data['error_crear_materia'] = $this->materiaModel->getMensajeError();
            } else {

                // Si se creo entonces vuelvo a obtener la lista de materias actualizada
                $materias = $this->materiaModel->obtener_materias_activas();

                // Lo guardo en un objeto
                $data = [
                    'materias' => $materias
                ];

                // Redirigir a la lista de materias con lo nuevo
                $this->view('pages/admin/materias/abm_materias', $data);
                return;
            }

            $this->view('pages/admin/materias/alta_materia', $data);
        } else {
            $data = ['error_crear_materia' => ''];
            $this->view('pages/admin/materias/alta_materia', $data);
        }
    }


    // POST: Acción para modificar una materia
    public function modificarMateriaAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitizar y almacenar los datos recibidos del formulario
            $data = [
                'id_materia' => trim($_POST['id-materia']),
                'nombre_materia' => trim($_POST['nombre-materia']),
                'comision_id' => trim($_POST['comision-id']),
                'error_modificar_materia' => ''
            ];

            // Intentar modificar la materia usando el modelo
            if (!$this->materiaModel->editar_materia($data)) {
                // Si falla, obtener el mensaje de error y mostrarlo en la vista de modificación
                $data['error_modificar_materia'] = $this->materiaModel->getMensajeError();
                $this->view('pages/admin/materias/modificar_materias', $data);
            } else {
                // Si la modificación es exitosa, obtener todas las materias y redirigir a la vista de ABM
                $materias = $this->materiaModel->obtener_materias_activas();
                $mensaje = "Materia con ID " . htmlspecialchars($data['id_materia']) . " editada correctamente.";
                $this->view('pages/admin/materias/abm_materias', [
                    'materias' => $materias,
                    'mensaje' => $mensaje
                ]);
            }
        } else {
            // En caso de que no sea una solicitud POST, redirigir a la vista de modificación
            $this->view('pages/admin/comisiones/modificar_materias');
        }
    }

    //GET
    public function modificarMateriasVista($id_materia = null, $mensaje = '')
    {
        $comisiones = $this->comisionModel->obtener_comisiones_activas();

        // Inicializamos el arreglo de datos para pasar a la vista
        $data = [
            'materia' => null,
            'comisiones' => $comisiones,
            'mensaje' => $mensaje
        ];
        // Si se proporciona un ID de materia, intentamos obtener la comisión
        if ($id_materia) {
            $materia = $this->materiaModel->buscar_materia_por_id($id_materia);
            if ($materia) {
                // Cargar la materia encontrada en los datos a enviar a la vista
                $data['materia'] = $materia;
            } else {
                // Si la materia no existe, cargar un mensaje de error
                $data['mensaje'] = "La materia con ID $id_materia no se encontró.";
            }
        }

        // Cargar la vista de modificación de comisiones con los datos de la materia y mensaje
        $this->view('pages/admin/materias/modificar_materias', $data);
    }

    // Método ejecucion baja de materia

    public function bajarMateria($id_materia = null)
    {
        $mensaje = ''; // Variable para almacenar el mensaje de error o éxito

        // Verificar que se recibió un ID de materia válido
        if ($id_materia) {
            // Intentar eliminar  materia usando el modelo
            if (!$this->materiaModel->eliminar_materia($id_materia)) {
                // Si no se pudo eliminar, obtener el mensaje de error del modelo
                $mensaje = $this->materiaModel->getMensajeError();
            } else {
                $mensaje = "Materia con ID $id_materia ha sido dada de baja.";
            }
        } else {
            $mensaje = "No se proporcionó un ID de Materia válido.";
        }

        // Obtener el listado actualizado de materias
        $materias = $this->materiaModel->obtener_materias_activas();

        // Redirigir a la vista de ABM de materias activas, pasando el mensaje y las comisiones
        $this->view('pages/admin/materias/abm_materias', [
            'materias' => $materias,
            'mensaje' => $mensaje
        ]);
    }

    public function subirMateria($id_materia = null)
    {
        $mensaje = ''; // Variable para almacenar el mensaje de error o éxito

        // Verificar que se recibió un ID de materia válido
        if ($id_materia) {
            // Intentar resubir la materia usando el modelo
            if (!$this->materiaModel->subir_materia($id_materia)) {
                // Si no se pudo resubir, obtener el mensaje de error del modelo
                $mensaje = $this->materiaModel->getMensajeError();
            } else {
                $mensaje = "Materia con ID $id_materia ha sido dada de alta nuevamente.";
            }
        } else {
            $mensaje = "No se proporcionó un ID de materia válido.";
        }

        // Obtener el listado actualizado de materias
        $materias = $this->materiaModel->obtener_materias_activas();

        // Redirigir a la vista de ABM de materias activas, pasando el mensaje y las materias
        $this->view('pages/admin/materias/abm_materias', [
            'materias' => $materias,
            'mensaje' => $mensaje
        ]);
    }




    //--------------------ABM PROFESORES----------------------------

    // Método para mostrar la vista del ABM de profesores
    public function abmProfesores()
    {
        $profesores = $this->profesorModel->obtener_profesores_activos();
        $this->view('pages/admin/profesores/abm_profesores', ['profesores' => $profesores]);
    }

    public function detalleProfesor($dni_profesor)
    {
        $profesor = $this->profesorModel->buscar_profesor_por_dni($dni_profesor);
        $materias = $this->profesorModel->obtenerMateriasPorProfesor($dni_profesor);
        $materiasDisponibles = $this->profesorModel->obtenerMateriasDisponibles($dni_profesor);

        $data = [
            'profesor' => $profesor,
            'materias' => $materias,
            'materiasDisponibles' => $materiasDisponibles,
            'mensaje' => ''
        ];

        $this->view('pages/admin/profesores/profesor_detalle', $data);
    }

    public function asociarMateriaProfesor()
    {
        $id_materia = $_POST['id_materia'];
        $dni_profesor = $_POST['dni_profesor'];

        if ($this->profesorModel->asociarMateriaProfesor($id_materia, $dni_profesor)) {
            $mensaje = 'Materia asociada exitosamente.';
        } else {
            $mensaje = 'Error al asociar la materia.';
        }

        $this->detalleProfesor($dni_profesor);
    }

    public function abmProfesoresInactivos()
    {
        // Obtener listado de profes
        $profesores = $this->profesorModel->obtener_profesores_inactivos();
        $this->view('pages/admin/profesores/abm_profesores_inactivos', ['profesores' => $profesores]);
    }

    // Método para mostrar la vista del ABM de profes. Se muestran todos, activos e inactivos
    public function abmProfesoresTodos()
    {
        // Obtener listado de profesores
        $profesores = $this->profesorModel->obtener_profesores();
        $this->view('pages/admin/profesores/abm_profesores_todos', ['profesores' => $profesores]);
    }

    public function altaProfesoresVista()
    {
        $this->view('pages/admin/profesores/alta_profesores');
    }

    // Método para procesar la acción de alta de un profesor
    // POST : Acción para crear un profesor con verificación de existencia
    public function altaProfesorAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitizar y almacenar los datos del formulario
            $data = [
                'dni_profesor' => trim($_POST['dni_profesor']),
                'nombre_profesor' => trim($_POST['nombre_profesor']),
                'apellido_profesor' => trim($_POST['apellido_profesor']),
                'email_profesor' => trim($_POST['email_profesor']),
                'error_modificar_profesor' => ''
            ];

            // Intenta crear el profesor
            if (!$this->profesorModel->crear_profesor($data)) {
                // muestra error si el profesor ya existe
                $data['error_crear_profesor'] = $this->profesorModel->getMensajeError();
                $this->view('pages/admin/profesores/alta_profesores', $data);
            } else {
                // Obtener listado actualizado de profes y mensaje de éxito
                $profesores = $this->profesorModel->obtener_profesores_activos();
                $mensaje = "El profesor fue agregado exitosamente.";

                // Redirigir a la vista de ABM de profesores con el listado y el mensaje
                $this->view('pages/admin/profesores/abm_profesores', [
                    'profesores' => $profesores,
                    'mensaje' => $mensaje
                ]);
            }
        } else {
            // En caso de que no sea POST, cargar la vista de alta de profesores
            $data = ['error_crear_profesor' => ''];
            $this->view('pages/admin/profesores/alta_profesores', $data);
        }
    }


    // POST: Acción para modificar un profesor
    public function modificarProfesorAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [
                'dni_profesor' => trim($_POST['dni_profesor']),
                'nombre_profesor' => trim($_POST['nombre_profesor']),
                'apellido_profesor' => trim($_POST['apellido_profesor']),
                'email_profesor' => trim($_POST['email_profesor']),
                'error_modificar_profesor' => ''
            ];

            // Intentar modificar el profesor usando el modelo
            if (!$this->profesorModel->editar_profesor($data)) {
                // Si falla, obtener el mensaje de error y mostrarlo en la vista de modificación
                $data['error_modificar_profesor'] = $this->profesorModel->getMensajeError();
                $this->view('pages/admin/profesores/modificar_profesores', $data);
            } else {
                // Si la modificación es exitosa, obtener todos los profesores
                $profesores = $this->profesorModel->obtener_profesores_activos();
                $mensaje = "Profesor " . htmlspecialchars($data['dni_profesor']) . " editado correctamente.";
                $this->view('pages/admin/profesores/abm_profesores', [
                    'profesores' => $profesores,
                    'mensaje' => $mensaje
                ]);
            }
        } else {
            // En caso de que no sea una solicitud POST, redirigir a la vista de modificación
            $this->view('pages/admin/profesores/modificar_profesores');
        }
    }

    //GET
    public function modificarProfesorVista($dni_profesor = null, $mensaje = '')
    {
        // Inicializamos el arreglo de datos para pasar a la vista
        $data = [
            'profesor' => null,
            'mensaje' => $mensaje
        ];

        // Si se proporciona el dni del profesor, intentamos obtenerlo
        if ($dni_profesor) {
            $profesor = $this->profesorModel->buscar_profesor_por_dni($dni_profesor);
            if ($profesor) {
                // Cargar el profesor en los datos a enviar a la vista
                $data['profesor'] = $profesor;
            } else {
                // Si el profesor no existe, cargar un mensaje de error
                $data['mensaje'] = "El profesor con DNI $dni_profesor no se encontró.";
            }
        }

        // Cargar la vista de modificación con los datos del profe y mensaje
        $this->view('pages/admin/profesores/modificar_profesores', $data);
    }

    // Método para ejecutar baja profesores

    public function bajarProfesor($dni_profesor = null)
    {
        $mensaje = ''; // Variable para almacenar el mensaje de error o éxito

        // Verificar que se recibió un DNI válido
        if ($dni_profesor) {
            // Intentar eliminar el profesir usando el modelo
            if (!$this->profesorModel->eliminar_profesor($dni_profesor)) {
                // Si no se pudo eliminar, obtener el mensaje de error del modelo
                $mensaje = $this->profesorModel->getMensajeError();
            } else {
                $mensaje = "Profesor con DNI $dni_profesor fue dado de baja.";
            }
        } else {
            $mensaje = "No se proporcionó un DNI de profesor válido.";
        }
        // Obtener el listado actualizado de profesores
        $profesor = $this->profesorModel->obtener_profesores_activos();

        // Redirigir a la vista de ABM de profesores activos
        $this->view('pages/admin/profesores/abm_profesores', [
            'profesores' => $profesor,
            'mensaje' => $mensaje
        ]);
    }

    public function subirProfesor($dni_profesor = null)
    {
        $mensaje = ''; // Variable para almacenar el mensaje de error o éxito

        // Verificar que se recibió un DNI valido
        if ($dni_profesor) {
            // Intentar resubir el profesor usando el modelo
            if (!$this->profesorModel->subir_profesor($dni_profesor)) {
                // Si no se pudo resubir, obtener el mensaje de error del modelo
                $mensaje = $this->profesorModel->getMensajeError();
            } else {
                $mensaje = "Profesor con DNI $dni_profesor ha sido dado de alta nuevamente.";
            }
        } else {
            $mensaje = "No se proporcionó un DNI de válido.";
        }

        // Obtener el listado actualizado
        $profesores = $this->profesorModel->obtener_profesores_activos();

        // Redirigir a la vista de ABM de profesores activos, pasando el mensaje y los profes
        $this->view('pages/admin/profesores/abm_profesores', [
            'profesores' => $profesores,
            'mensaje' => $mensaje
        ]);
    }

    public function desvincularMateriaProfesor()
    {
        $id_materia = $_POST['id_materia'];
        $dni_profesor = $_POST['dni_profesor'];

        if ($this->profesorModel->desvincularMateriaDeProfesor($id_materia, $dni_profesor)) {
            $mensaje = 'Materia desvinculada exitosamente.';
        } else {
            $mensaje = 'Error al desvincular la materia.';
        }

        // Cargar nuevamente la vista con el mensaje
        $this->detalleProfesor($dni_profesor);
    }
    //--------------------FIN ABM PROFESORES------------------------

    //----------------------ABM CARRERAS-----------------------------//
    //Metodo para desvicular materias.
    public function desvincularMateria()
    {
        $id_carrera = $_POST['id_carrera'];
        $id_materia = $_POST['id_materia'];

        if ($this->carreraModel->desvincularMateriaDeCarrera($id_carrera, $id_materia)) {
            $mensaje = 'Materia desvinculada exitosamente.';
        } else {
            $mensaje = 'Error al desvincular la materia.';
        }

        // Cargar nuevamente la vista con el mensaje
        $this->detalleCarrera($id_carrera);
    }

    // Método para mostrar la vista del ABM de carreras
    public function abmCarreras()
    {
        $carrera = $this->carreraModel->obtener_carreras_activas();
        $this->view('pages/admin/carreras/abm_carreras', ['carreras' => $carrera]);
    }

    // Método para mostrar la vista del ABM de todas las carreras
    public function abmCarrerasTodas()
    {
        $carrera = $this->carreraModel->obtener_carreras_todas();
        $this->view('pages/admin/carreras/abm_carreras_todas', ['carreras' => $carrera]);
    }

    // Método para mostrar la vista del ABM de todas las carreras
    public function abmCarrerasInactivas()
    {
        $carrera = $this->carreraModel->obtener_carreras_inactivas();
        $this->view('pages/admin/carreras/abm_carreras_inactivas', ['carreras' => $carrera]);
    }

    public function subirCarrera($id_carrera = null)
    {
        $mensaje = ''; // Variable para almacenar el mensaje de error o éxito

        // Verificar que se recibió un ID de carrera válido
        if ($id_carrera) {
            // Intentar resubir la carrera usando el modelo
            if (!$this->carreraModel->subir_carrera($id_carrera)) {
                // Si no se pudo resubir, obtener el mensaje de error del modelo
                $mensaje = $this->carreraModel->getMensajeError();
            } else {
                $mensaje = "Carrera con ID $id_carrera ha sido dada de alta nuevamente.";
            }
        } else {
            $mensaje = "No se proporcionó un ID de carrera válido.";
        }

        // Obtener el listado actualizado de comisiones
        $carreras = $this->carreraModel->obtener_carreras_activas();

        // Redirigir a la vista de ABM de carreras activas, pasando el mensaje y las comisiones
        $this->view('pages/admin/carreras/abm_carreras', [
            'carreras' => $carreras,
            'mensaje' => $mensaje
        ]);
    }


    /**
     * Muestra los detalles de una carrera, incluyendo sus materias asociadas y disponibles.
     *
     * Esta función carga los datos de una carrera específica, sus materias asociadas y las materias
     * que aún no están asociadas, y luego renderiza la vista correspondiente para mostrar esta información.
     *
     * @param int $id_carrera El ID de la carrera que se desea mostrar.
     */
    public function detalleCarrera($id_carrera)
    {
        // Buscamos la información de la carrera en el modelo
        $carrera = $this->carreraModel->buscar_carrera_por_id($id_carrera);

        // Obtenemos las materias asociadas a la carrera
        $materias = $this->carreraModel->obtenerMateriasPorCarrera($id_carrera);

        // Obtenemos las materias disponibles (no asociadas) a la carrera
        $materiasDisponibles = $this->carreraModel->obtenerMateriasDisponibles($id_carrera);

        // Preparamos los datos para pasarlos a la vista
        $data = [
            'carrera' => $carrera,
            'materias' => $materias,
            'materiasDisponibles' => $materiasDisponibles,
            'mensaje' => '' // Inicializamos el mensaje vacío
        ];

        // Renderizamos la vista con los datos
        $this->view('pages/admin/carreras/carrera_detalle', $data);
    }

    /**
     * Asocia una materia a una carrera.
     *
     * Esta función recibe los IDs de la carrera y la materia a asociar, llama al modelo para realizar la asociación
     * y luego redirige a la vista de detalles de la carrera para mostrar los cambios.
     */
    public function asociarMateria()
    {
        // Obtenemos los IDs de la carrera y la materia desde el formulario
        $id_carrera = $_POST['id_carrera'];
        $id_materia = $_POST['id_materia'];

        // Llamamos al modelo para asociar la materia a la carrera
        if ($this->carreraModel->asociarMateriaACarrera($id_carrera, $id_materia)) {
            $mensaje = 'Materia asociada exitosamente.';
        } else {
            $mensaje = 'Error al asociar la materia.';
        }

        // Redirigimos a la vista de detalles de la carrera, pasando el mensaje como dato
        $data = ['mensaje' => $mensaje];
        $this->detalleCarrera($id_carrera, $data); // Pasamos el mensaje como segundo parámetro
    }

    public function listarCarreras()
    {
        $carrera = $this->carreraModel->obtener_carreras();

        echo '<pre>';
        var_dump($carrera);
        echo '</pre>';

        $this->view('pages/admin/carreras/abm_carreras', ['carreras' => $carrera]);
    }

    // Get: Método para mostrar la vista de alta de carreras
    public function altaCarrerasVista()
    {
        $this->view('pages/admin/carreras/alta_carreras');
    }

    //Metodo para procesar el alta de una nueva carrera//
    public function altaCarreraAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitizar y almacenar los datos del formulario
            $data = [
                #'id_carrera' => trim($_POST['id_carrera']),
                'nombre_carrera' => trim($_POST['nombre_carrera']),
                'error_crear_carrera' => ''
            ];

            // Intentar crear la carrera
            if (!$this->carreraModel->crear_carrera($data)) {
                // Si hay algún error, mostrar el mensaje
                $data['error_crear_carrera'] = $this->carreraModel->getMensajeError();
            } else {
                // Obtener el listado actualizado de carreras activas
                $carreras = $this->carreraModel->obtener_carreras_activas();

                // Redirigir a la vista de ABM de carreras, pasando el mensaje y las carreras
                $this->view('pages/admin/carreras/abm_carreras', [
                    'carreras' => $carreras,
                    'mensaje' => 'La carrera se creó correctamente.'
                ]);

                return;
            }

            $this->view('pages/admin/carreras/alta_carreras', $data);
        } else {
            $data = ['error_crear_carrera' => ''];
            $this->view('pages/admin/carreras/alta_carreras', $data);
        }
    }

    // Método para mostrar la vista de baja de carreras
    public function bajarCarrera($id_carrera = null)
    {
        $mensaje = ''; // Variable para almacenar el mensaje de error o éxito

        // Verificar que se recibió un ID de carrera válido
        if ($id_carrera) {
            // Intentar dar de baja la carrera usando el modelo
            if (!$this->carreraModel->eliminar_carrera($id_carrera)) {
                // Si no se pudo dar de baja, obtener el mensaje de error del modelo
                $mensaje = $this->carreraModel->getMensajeError();
            } else {
                // Si tuvo éxito, generamos un mensaje de confirmación
                $mensaje = "Carrera con ID $id_carrera ha sido dada de baja.";
            }
        } else {
            // Si no se proporcionó un ID válido
            $mensaje = "No se proporcionó un ID de carrera válido.";
        }

        // Obtener el listado actualizado de carreras activas
        $carreras = $this->carreraModel->obtener_carreras_activas();

        // Redirigir a la vista de ABM de carreras, pasando el mensaje y las carreras
        $this->view('pages/admin/carreras/abm_carreras', [
            'carreras' => $carreras,
            'mensaje' => $mensaje
        ]);
    }


    // GET: Método para procesar la modificacion de una carrera.//
    public function modificarCarreraVista($id_carrera = null, $mensaje = '')
    {
        // Inicializamos los datos para la vista
        $data = [
            'carrera' => null,
            'mensaje' => $mensaje
        ];
        // Si se proporciona un ID, intentamos obtener los datos de la carrera
        if ($id_carrera) {
            $carrera = $this->carreraModel->buscar_carrera_por_id($id_carrera);
            if ($carrera) {
                $data['carrera'] = $carrera;
            } else {
                // Si la carrera no se encuentra, añadimos un mensaje de error
                $data['mensaje'] = "La carrera con ID $id_carrera no se encontró.";
            }
        }

        // Cargamos la vista de modificación con los datos de la carrera y el mensaje
        $this->view('pages/admin/carreras/modificar_carreras', $data);
    }


    // POST: Acción para modificar una carrera.//
    public function modificarCarreraAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitizamos y preparamos los datos del formulario
            $data = [
                'id_carrera' => trim($_POST['id_carrera']),
                'nombre_carrera' => trim($_POST['nombre_carrera']),
                'error_modificar_carrera' => ''
            ];

            // Intentamos editar la carrera usando el modelo
            if (!$this->carreraModel->editar_carrera($data)) {
                // Si falla, obtenemos el mensaje de error y volvemos a la vista de modificación
                $data['error_modificar_carrera'] = $this->carreraModel->getMensajeError();
                $this->view('pages/admin/carreras/modificar_carreras', $data);
            } else {
                // Si tiene éxito, obtenemos todas las carreras y redirigimos a la vista de ABM
                $carreras = $this->carreraModel->obtener_carreras_activas();
                $mensaje = "Carrera con ID " . htmlspecialchars($data['id_carrera']) . " editada correctamente.";
                $this->view('pages/admin/carreras/abm_carreras', [
                    'carreras' => $carreras,
                    'mensaje' => $mensaje
                ]);
            }
        } else {
            // Si no es una solicitud POST, redirigimos a la vista de modificación
            $this->view('pages/admin/carreras/modificar_carreras');
        }
    }

    //--------------------FIN ABM CARRERAS------------------------//

    //-------------------- ABM AUTENTICACION ----------------------------

    // Método para mostrar la vista del ABM de usuarios y listar los usuarios
    public function abmUsuarios()
    {
        // Obtener el término de búsqueda del parámetro GET (si existe)
        $query = $_GET['query'] ?? '';

        if (!empty($query)) {

            // Si hay una termino de busqueda en el form realizamos la busqueda por nombre
            $usuario = $this->authModel->buscar_por_nombre(['nombre_usuario' => $query]);

            // Si encuentra, lo convierte en un array; si no, devuelve un array vacío
            $usuarios = $usuario ? [$usuario] : [];
        } else {

            // Obtener todos los usuarios si no hay termino de busqueda búsqueda
            $usuarios = $this->authModel->obtener_usuarios();
        }

        // Preparar los datos para la vista
        $data = [
            'usuarios' => $usuarios,
            'query' => $query // Enviar el término de búsqueda a la vista para mantenerlo en el input
        ];

        $this->view('pages/admin/cuenta/abm_usuarios', $data);
    }

    // Método para mostrar la vista del ABM de usuarios, con listado de usuarios activos
    public function usuariosActivosVista()
    {
        // Obtener listado de usuarios
        $usuarios = $this->authModel->obtener_usuarios_activos();
        $this->view('pages/admin/cuenta/abm_usuarios_activos', ['usuarios' => $usuarios]);
    }

    // Método para mostrar la vista del ABM de usuarios, con listado de usuarios inactivos
    public function usuariosInactivosVista()
    {
        // Obtener listado de usuarios
        $usuarios = $this->authModel->obtener_usuarios_inactivos();
        $this->view('pages/admin/cuenta/abm_usuarios_inactivos', ['usuarios' => $usuarios]);
    }

    public function detalleUsuarioVista($nombre_usuario = null, $mensaje = '')
    {

        // Inicializamos el arreglo de datos para pasar a la vista
        $data = [
            'usuario' => null,
            'mensaje' => $mensaje
        ];

        // Si se proporciona un ID de comisión, intentamos obtener la comisión
        if ($nombre_usuario) {
            $usuario = $this->authModel->obtener_usuario_completo($nombre_usuario);
            if ($usuario) {
                // Cargar la comisión encontrada en los datos a enviar a la vista
                $data['usuario'] = $usuario;
            } else {
                // Si la comisión no existe, cargar un mensaje de error
                $data['mensaje'] = "El usuario $nombre_usuario no se encontró.";
            }
        }

        // Cargar la vista de modificación de comisiones con los datos de la comisión y mensaje
        $this->view('pages/admin/cuenta/detalle_usuario', $data);
    }

    // Método para mostrar la vista de alta de Usuario 
    public function altaUsuarioVista()
    {
        // Obtener las carreras desde el modelo
        $carreras = $this->carreraModel->obtener_carreras_activas();
        $this->view('pages/admin/cuenta/alta_usuario', ['carreras' => $carreras]);
    }

    // Método para realizar el alta de Usuario 
    public function altaUsuarioAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitizar y almacenar los datos del formulario
            $data = [
                'nombre_usuario' => trim($_POST['nombre-usuario']),
                'clave_usuario' => trim($_POST['clave-usuario']),
                'nombre_alumno' => trim($_POST['nombre-alumno']),
                'apellido_alumno' => trim($_POST['apellido-alumno']),
                'email_alumno' => trim($_POST['email-alumno']),
                'carrera_id' => trim($_POST['carrera-alumno']),
                'error_crear_usuario' => ''
            ];

            // Intentar crear el usuario
            if (!$this->authModel->crear_usuario($data)) {
                // Muestra el error si el usuario ya existe
                $data['error_crear_usuario'] = $this->authModel->getMensajeError();
            } else {

                // El usuario se creó correctamente, enviar un correo de confirmación
                $to = $data['email_alumno']; // Dirección del alumno
                $subject = "Bienvenidx a la plataforma"; // Asunto del correo
                $message = "
                                Hola {$data['nombre_alumno']} {$data['apellido_alumno']},
                                
                                Tu cuenta ha sido creada exitosamente. Aquí están tus credenciales de acceso:
                                
                                Usuario: {$data['nombre_usuario']}
                                Contraseña: {$data['clave_usuario']}
                                
                                Te recomendamos cambiar tu contraseña tras iniciar sesión.
                                
                                Saludos,
                                Equipo de Soporte
                            ";
                $headers = "From: no-reply@tu-sitio.com\r\n"; // Cambia a tu email de soporte
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                // Enviar correo
                if (!mail($to, $subject, $message, $headers)) {
                    // Registrar error de envío
                    error_log("Error al enviar el correo a: $to");
                }


                // Si se creo entonces vuelvo a obtener la lista de usuarios actualizada
                $usuarios = $this->authModel->obtener_usuarios();

                // Lo guardo en un objeto
                $data = [
                    'usuarios' => $usuarios
                ];

                // Redirigir a la lista de usuarios con lo nuevo
                $this->view('pages/admin/cuenta/abm_usuarios', $data);
                return;
            }

            $this->view('pages/admin/cuenta/alta_usuario', $data);
        } else {
            $data = ['error_crear_usuario' => ''];
            $this->view('pages/admin/cuenta/alta_usuario', $data);
        }
    }

    public function bajaDeUsuarioAction($nombre_usuario = null)
    {
        $mensaje = ''; // Variable para almacenar el mensaje de error o éxito

        // Verificar que se recibió un ID de comisión válido
        if ($nombre_usuario) {
            // Intentar eliminar la comisión usando el modelo
            if (!$this->authModel->eliminar_usuario($nombre_usuario)) {

                // Si no se pudo eliminar, obtener el mensaje de error del modelo
                $mensaje = $this->authModel->getMensajeError();
            } else {
                $mensaje = "El usuario $nombre_usuario ha sido dado de baja.";
            }
        } else {
            $mensaje = "No se proporcionó un ID de comisión válido.";
        }

        // Obtener el listado actualizado de comisiones
        $usuarios = $this->authModel->obtener_usuarios();

        // Redirigir a la vista de ABM de comisiones activas, pasando el mensaje y las comisiones
        $this->view('pages/admin/cuenta/abm_usuarios', [
            'usuarios' => $usuarios,
            'mensaje' => $mensaje
        ]);
    }

    public function reactivarUsuario($nombre_usuario = null)
    {
        $mensaje = ''; // Variable para almacenar el mensaje de error o éxito

        // Verificar que se recibió un ID de comisión válido
        if ($nombre_usuario) {
            // Intentar eliminar la comisión usando el modelo
            if (!$this->authModel->reactivar_usuario($nombre_usuario)) {

                // Si no se pudo eliminar, obtener el mensaje de error del modelo
                $mensaje = $this->authModel->getMensajeError();
            } else {
                $mensaje = "El usuario $nombre_usuario ha sido dado de alta nuevamente.";
            }
        } else {
            $mensaje = "No se proporcionó un nombre de usuario válido.";
        }

        // Obtener el listado actualizado de comisiones
        $usuarios = $this->authModel->obtener_usuarios();

        // Redirigir a la vista de ABM de comisiones activas, pasando el mensaje y las comisiones
        $this->view('pages/admin/cuenta/abm_usuarios', [
            'usuarios' => $usuarios,
            'mensaje' => $mensaje
        ]);
    }

    // Metodo para obtener la vista de Modificar Usuario
    public function modificarUsuarioVista($nombre_usuario) {}

    // Metodo para realizar la modificacion del Usuario
    public function modificarUsuarioAction() {}

    //-------------------- FIN ABM AUTENTICACION ------------------------

}
