<?php
    function mostrarImg($conn){
        $idProfe = $_SESSION['idProfe'];

        $queryName = 'SELECT img, tipus FROM profesores WHERE id = ' . $idProfe;
        
        $r = mysqli_query($conn, $queryName);

        if ($r && mysqli_num_rows($r) > 0) {
            $fila = mysqli_fetch_assoc($r);
            
            echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['img']) . "' >";
        }
    }

    function crearActividad($conn) {
        // Obtener los datos del formulario
        $titulo = $_POST['tituloActNew'];
        $descripcion = $_POST['descriptionActNew'];
        $dueDate = $_POST['dueDateActNew'];
        $idProject = $_SESSION['idProyecto'];
        $estado = $_POST['estadoActNew'];
    
        // Crear la consulta SQL
        $sql = "INSERT INTO actividades (titulo, descripcion, project_id, due_date, active) 
                VALUES ('$titulo', '$descripcion', '$idProject', '$dueDate', '$estado')";
        
        mysqli_query($conn, $sql);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    function editarProyecto($conn){
        // Obtener los datos del formulario
        $titulo = $_POST['editTitle'];
        $descripcion = $_POST['editDesc'];
        $idProject = $_SESSION['idProyecto'];

    
        // Crear la consulta SQL
        $sql = "UPDATE proyectos SET titulo = '$titulo', descripcion = '$descripcion' WHERE id = '$idProject'";
        
        mysqli_query($conn, $sql);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

?>