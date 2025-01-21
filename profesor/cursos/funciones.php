<?php
function insertarProject($conn) {
    // Verificar si los datos están presentes
    if (isset($_POST["tituloProyecto"]) && isset($_POST["descripcionProyecto"])) {
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
        $insertar = "INSERT INTO proyectos (titulo, descripcion, curso_id, profe_id) 
                     VALUES ('$titulo', '$descripcion', '$idCurso', '$idProfe')";

        // Ejecutar la consulta
        mysqli_query($conn, $insertar);
            $idProject = mysqli_insert_id($conn);
            $select = "SELECT id FROM alumnos WHERE curso_id = $idCurso";
            $r = mysqli_query($conn, $select);
            while ($row = mysqli_fetch_assoc($r)) {
                $idAlumno = $row['id'];
                $insert = "INSERT INTO alumnos_proyectos (id_alumno, id_proyecto) VALUES ('$idAlumno', '$idProject')";
                mysqli_query($conn, $insert);
            }       
    } else {
        echo "<script>alert('Faltan datos del formulario');</script>";
    }
}

function eliminarProyecto($conn){
    $idProyecto = $_SESSION['idProyectoSeleccionado'];

    $eliminarProject = "DELETE FROM proyectos WHERE id = $idProyecto";

    if (mysqli_query($conn, $eliminarProject)) {
        $eliminarProyecto = "DELETE FROM alumnos_proyectos WHERE id_proyecto = $idProyecto";
        mysqli_query($conn, $eliminarProyecto);
        echo "<script>alert('Proyecto eliminado correctamente');</script>";
        unset($_SESSION['idProyectoSeleccionado']); // Limpia la selección del proyecto
    } else {
        echo "<script>alert('Error al eliminar el proyecto: " . mysqli_error($conn) . "');</script>";
    }
}


?>

