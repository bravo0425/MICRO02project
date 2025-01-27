<?php
function insertarProject($conn){
    // Verificar si los datos están presentes
    $titulo = $_POST["tituloProyecto"];
    $descripcion = $_POST["descripcionProyecto"];
    $idProfe = $_SESSION['idProfe'];  // ID del profesor
    $idCurso = $_SESSION['idCurso'];  // ID del curso

    // Validar si los campos no están vacíos
    if (empty($titulo) || empty($descripcion)) {
        echo "Todos los campos son obligatorios.";
        return;
    }

    // Escapar las entradas para evitar inyecciones SQL
    $titulo = mysqli_real_escape_string($conn, $titulo);
    $descripcion = mysqli_real_escape_string($conn, $descripcion);
    $idProfe = mysqli_real_escape_string($conn, $idProfe);
    $idCurso = mysqli_real_escape_string($conn, $idCurso);

    // Consulta para insertar el proyecto en la base de datos
    $insertar = "INSERT INTO proyectos (titulo, descripcion, curso_id, profe_id) VALUES ('$titulo', '$descripcion', '$idCurso', '$idProfe')";

    mysqli_query($conn, $insertar);
    
    $idProject = mysqli_insert_id($conn);
    $select = "SELECT id FROM alumnos WHERE curso_id = $idCurso";
    $r = mysqli_query($conn, $select);
    while ($row = mysqli_fetch_assoc($r)) {
        $idAlumno = $row['id'];
        $insert = "INSERT INTO alumnos_proyectos (id_alumno, id_proyecto) VALUES ('$idAlumno', '$idProject')";
        mysqli_query($conn, $insert);
    }
}

function eliminarProyecto($conn){
    $idProyecto = $_SESSION['idProyectoSeleccionado'];

    $eliminarProject = "DELETE FROM proyectos WHERE id = $idProyecto";

    if (mysqli_query($conn, $eliminarProject)) {
        echo "<script>alert('Proyecto eliminado correctamente');</script>";
        unset($_SESSION['idProyectoSeleccionado']);
    } else {
        echo "<script>alert('Error al eliminar el proyecto: " . mysqli_error($conn) . "');</script>";
    }
}

function mostrarImg($conn) {
    $idProfe = $_SESSION['idProfe'];
    $queryName = 'SELECT img, tipus FROM profesores WHERE id = ' . $idProfe;
    $r = mysqli_query($conn, $queryName);
    if ($r && mysqli_num_rows($r) > 0) {
        $fila = mysqli_fetch_assoc($r);
        if (!empty($fila['img'])) {
            echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['img']) . "' >";
        } else {
            echo "<img src='../../imagenes/usuario.png' alt='Imagen por defecto'>";
        }
    } else {
        echo "<img src='../../imagenes/usuario.png' alt='Imagen por defecto'>";
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
        echo '<tr><td colspan="2">There are no students assigned to this project.</td></tr>';
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
