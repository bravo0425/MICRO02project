<?php
function insertarProject($conn){
    // Verificar si los datos están presentes
    $titulo = $_POST["tituloProyecto"];
    $descripcion = $_POST["descripcionProyecto"];
    $idProfe = $_SESSION['idProfe'];  // ID del profesor
    $idCurso = $_SESSION['idCurso'];  // ID del curso

    // Validar si los campos no están vacíos
    if (empty($titulo) || empty($descripcion)) {
        mostrarErrorPopup("All fields are required");
        return;
    }

    // Escapar las entradas para evitar inyecciones SQL
    $titulo = mysqli_real_escape_string($conn, $titulo);
    $descripcion = mysqli_real_escape_string($conn, $descripcion);
    $idProfe = mysqli_real_escape_string($conn, $idProfe);
    $idCurso = mysqli_real_escape_string($conn, $idCurso);

    // Consulta para insertar el proyecto en la base de datos
    $insertar = "INSERT INTO proyectos (titulo, descripcion, curso_id, profe_id) VALUES ('$titulo', '$descripcion', '$idCurso', '$idProfe')";

    if (mysqli_query($conn, $insertar)) {
        $idProject = mysqli_insert_id($conn);
        $select = "SELECT id FROM alumnos WHERE curso_id = $idCurso";
        $r = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_assoc($r)) {
            $idAlumno = $row['id'];
            $insert = "INSERT INTO alumnos_proyectos (id_alumno, id_proyecto) VALUES ('$idAlumno', '$idProject')";
            mysqli_query($conn, $insert);
        }
        mostrarSuccesPopup("Project created successfully");
    } else {
        
    }
}

function eliminarProyecto($conn){
    $idProyecto = $_SESSION['idProyectoSeleccionado'];

    if(empty($idProyecto)) {
        header ('Location: cursos.php');
    }

    $eliminarProject = "DELETE FROM proyectos WHERE id = $idProyecto";

    if (mysqli_query($conn, $eliminarProject)) {
        unset($_SESSION['idProyectoSeleccionado']);
    } else {
        mostrarErrorPopup("Error deleting project");
    }
    mostrarSuccesPopup("Project deleted succesfuly");
}

function mostrarImg($conn){
    $idProfe = $_SESSION['idProfe'];

    $queryName = 'SELECT img, tipus FROM profesores WHERE id = ' . $idProfe;

    $r = mysqli_query($conn, $queryName);

    // Asegúrate de que haya resultados
    if ($r && mysqli_num_rows($r) > 0) {
        $fila = mysqli_fetch_assoc($r);

        // Mostrar la imagen a través de un archivo PHP
        echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['img']) . "' >";
    }
}

function encontrarNotaProyecto($conn, $idAlumno, $idProyecto) {
    // 1. Obtener todas las actividades relacionadas con el proyecto
    $actividadesQuery = "SELECT actividades.id AS id_actividad FROM actividades JOIN alumnos_actividades ON actividades.id = alumnos_actividades.id_actividad  WHERE actividades.project_id = $idProyecto AND alumnos_actividades.id_alumno = $idAlumno";
    $rActividades = mysqli_query($conn, $actividadesQuery);
    
    if ($rActividades && mysqli_num_rows($rActividades) > 0) {
        $notaProyecto = 0;
        $totalActividades = 0;

        while ($actividad = mysqli_fetch_assoc($rActividades)) {
            $idActividad = $actividad['id_actividad'];
            //Calcular la media de los ítems para la actividad
            $itemsQuery = "SELECT alumnos_items.notaItem, items.valor  FROM alumnos_items JOIN items ON alumnos_items.id_item = items.id WHERE items.activity_id = $idActividad AND alumnos_items.id_alumno = $idAlumno";
            $rItems = mysqli_query($conn, $itemsQuery);

            if ($rItems && mysqli_num_rows($rItems) > 0) {
                $sumaNotas = 0;
                $sumaValor = 0;

                while ($item = mysqli_fetch_assoc($rItems)) {
                    $notaItem = $item['notaItem'];
                    $valor = $item['valor'];

                    $sumaNotas += $notaItem * $valor;
                    $sumaValor += $valor;
                }

                // Media ponderada de los ítems para la actividad
                if ($sumaValor > 0) {
                    $notaActividad = $sumaNotas / $sumaValor;
                    $notaProyecto += $notaActividad;
                    $totalActividades++;
                }
            }
        }

        // Media de las actividades para el proyecto
        if ($totalActividades > 0) {
            return $notaProyecto / $totalActividades ;
        }
    }
    // Si no hay actividades o ítems evaluados, retornar 0
    return 0;
}

$allProjectsScores = [];

function mostrarTablaAlumnos($conn, $idProyecto) {
    // Obtener los alumnos relacionados con el proyecto
    $selectAlumnosProjects = "SELECT alumnos.id AS id_alumno, alumnos.name, alumnos.last_name FROM alumnos_proyectos JOIN alumnos ON alumnos_proyectos.id_alumno = alumnos.id WHERE alumnos_proyectos.id_proyecto = $idProyecto";
    $resultsql = mysqli_query($conn, $selectAlumnosProjects);

    if ($resultsql && mysqli_num_rows($resultsql) > 0) {

        while ($row = mysqli_fetch_assoc($resultsql)) {
            $idAlumno = $row['id_alumno'];
            $nameAlumno = $row['name'];
            $apellido = $row['last_name'];

            // Calcular la nota del proyecto para el alumno
            $notaProyecto = encontrarNotaProyecto($conn, $idAlumno, $idProyecto);

            echo '<tr>';
            echo '<td>' . $nameAlumno . ' ' . $apellido . '</td>';
            echo '<td>' . number_format($notaProyecto, 1) . '</td>'; // Mostrar la nota con 2 decimales
            echo '</tr>';
        }

    } else {
        echo '<tr><td colspan="2">No hay alumnos asignados a este proyecto.</td></tr>';
    }
}

function mostrarMediaProyectos($conn, $idProyecto){
    $selectAlumnosProjects = "SELECT alumnos.id AS id_alumno, alumnos.name FROM alumnos_proyectos JOIN alumnos ON alumnos_proyectos.id_alumno = alumnos.id WHERE alumnos_proyectos.id_proyecto = $idProyecto";
    $resultsql = mysqli_query($conn, $selectAlumnosProjects);
    $totalNotas = 0;
    $totalAlumnos = 0;
    $media = 0;

    if ($resultsql && mysqli_num_rows($resultsql) > 0) {

        while ($row = mysqli_fetch_assoc($resultsql)) {
            $idAlumno = $row['id_alumno'];

            $notaAlumno = encontrarNotaProyecto($conn, $idAlumno, $idProyecto);
            $totalNotas += $notaAlumno;
            $totalAlumnos ++;
        }
        if($totalAlumnos > 0){
            $media = $totalNotas / $totalAlumnos;
            echo '<p> '.number_format($media, 1).'</p>';
        }
        

    } else {
        echo '<p>-</p>';
    }
}


// Función para mostrar popups de error
function mostrarErrorPopup($mensaje) {
    echo "
    <div class='error-pop'>
        <div class='error-container'>
            <div class='redondaError'>
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                    <path stroke-linecap='round' stroke-linejoin='round' d='M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z' />
                </svg>
            </div>
            <div class='textPOP'>
                <h3>Oooops !!</h3>   
                <p>$mensaje</p>
            </div>
            <button class='popup-close'>Ok</button>
        </div>
    </div>
    <script>
        document.getElementById('error-pop').classList.add('show');
        const popupClose = document.querySelector('.popup-close');
        popupClose.addEventListener('click', function() {
            document.querySelector('.error-pop').classList.remove('show');
        });
    </script>";
}

function mostrarSuccesPopup($mensaje) {
    echo "
    <div class='succes-pop'>
        <div class='succes-container'>
            <div class='redonda'>
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                    <path stroke-linecap='round' stroke-linejoin='round' d='m4.5 12.75 6 6 9-13.5' />
                </svg>
            </div>
            <div class='textPOP'>
                <h3>Succsesful !!</h3>   
                <p>$mensaje</p>
            </div>
            <button class='close-Succes'>Ok</button>
        </div>
    </div>
    <script>
        document.getElementById('succes-pop').classList.add('show');
        const popupClose = document.querySelector('.close-Succes');
        popupClose.addEventListener('click', function() {
            document.querySelector('.succes-pop').classList.remove('show');
        });
    </script>";
}