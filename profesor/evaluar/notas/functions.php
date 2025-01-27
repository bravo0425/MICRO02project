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

    function mostrarNotaItemAlumno($conn, $idStudent, $idItem) {
        // Construir la consulta
        $queryNota = "SELECT notaItem FROM alumnos_items WHERE id_alumno = $idStudent AND id_item = $idItem";
        $rn = mysqli_query($conn, $queryNota);
    
        if($rn) {
            if(mysqli_num_rows($rn) > 0) {
                while ($fila = mysqli_fetch_assoc($rn)) {
                    $notaItem = $fila['notaItem'];
                    echo $notaItem;
                }
            } else {
                echo "";
            }
        } else {
            echo "Error en la consulta: " . mysqli_error($conn);
        }
    }

    function añadirNota($conn, $idStudent, $items) {
        foreach ($items as $itemId => $nota) {
            $itemId = intval($itemId); // Convertir a entero
            $nota = floatval($nota);   // Convertir a decimal
    
            // Verificar si ya existe un registro
            $queryCheck = "SELECT * FROM alumnos_items WHERE id_alumno = $idStudent AND id_item = $itemId";
            $resultCheck = mysqli_query($conn, $queryCheck);
    
            if (mysqli_num_rows($resultCheck) > 0) {
                // Actualizar si ya existe
                $queryUpdate = "UPDATE alumnos_items SET notaItem = $nota WHERE id_alumno = $idStudent AND id_item = $itemId";
                mysqli_query($conn, $queryUpdate);
            } else {
                // Insertar si no existe
                $queryInsert = "INSERT INTO alumnos_items (id_alumno, id_item, notaItem) VALUES ($idStudent, $itemId, $nota)";
                mysqli_query($conn, $queryInsert);
            }
        }
    
        echo "Las notas se han actualizado correctamente.";
    }
    
    function marcarActividadEvaluada($conn, $idStudent, $idActivity, $idItem) {
        // Validar y escapar entradas
        $idStudent = mysqli_real_escape_string($conn, $idStudent);
        $idActivity = mysqli_real_escape_string($conn, $idActivity);
        $idItem = mysqli_real_escape_string($conn, $idItem);
    
        // Consultar el valor del ítem
        $vlorItems = "SELECT valor FROM alumnos_items WHERE id_item = $idItem AND id_alumno = $idStudent";
        $ritem = mysqli_query($conn, $vlorItems);
    
        $row = mysqli_fetch_assoc($ritem);
    
        // Verificar que el valor no sea nulo o vacío
        if ($row && $row['valor'] !== null && $row['valor'] !== '') {
            // Actualizar actividad como evaluada
            $actividad = "UPDATE alumnos_activity SET evaluado = 1 WHERE id_item = $idActivity AND id_alumno = $idStudent";
            $result = mysqli_query($conn, $actividad);
    
            return true; // Éxito
        }
    
        return false; // No se cumple la condición
    }
    
    
?>