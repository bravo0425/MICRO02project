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
        if (mysqli_query($conn, $insertar)) {
            echo "<script>alert('Proyecto insertado correctamente');</script>";
        } else {
            echo "<script>alert('Error al insertar el proyecto: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Faltan datos del formulario');</script>";
    }
}

function eliminarProyecto($conn){
    $idProyecto = $_SESSION['idProyectoSeleccionado'];

    $eliminarProject = "DELETE FROM proyectos WHERE id = $idProyecto";

    if (mysqli_query($conn, $eliminarProject)) {
        echo "<script>alert('Proyecto eliminado correctamente');</script>";
        unset($_SESSION['idProyectoSeleccionado']); // Limpia la selección del proyecto
    } else {
        echo "<script>alert('Error al eliminar el proyecto: " . mysqli_error($conn) . "');</script>";
    }
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

?>

