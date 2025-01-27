<?php

function mostrarImg($conn) {
    $idAlumno = $_SESSION['idAlumno'];
    $queryName = 'SELECT img, tipus FROM alumnos WHERE id = ' . $idAlumno;
    $r = mysqli_query($conn, $queryName);
    // Asegúrate de que haya resultados
    if ($r && mysqli_num_rows($r) > 0) {
        $fila = mysqli_fetch_assoc($r);
        // Verifica si la imagen está vacía o nula
        if (!empty($fila['img'])) {
            echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['img']) . "' >";
        } else {
            echo "<img src='../../imagenes/usuario.png' alt='Imagen por defecto'>";
        }
    } else {
        echo "<img src='../../imagenes/usuario.png' alt='Imagen por defecto'>";
    }
}

function mostrarnotaProyecto($conn, $idProyecto, $idAlumno) {
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