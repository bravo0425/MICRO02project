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

    function mostrarTablaAlumnos($conn){
        //coger query de tabla alumnos_actividades. asi sabremos el id de la actividad si coincide y el alumno. com el id del alumno sacamos toda su informacion. Falta añadir una columna dodne se suba el fitchero de la actividad con el alumno pero eso se hara en otra columna. alumno_evaluar_actividad.
    }
?>