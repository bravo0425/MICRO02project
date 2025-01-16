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

    
?>