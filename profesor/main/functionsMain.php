<?php
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
        //Obtener todas las actividades relacionadas con el proyecto
        $actividadesQuery = "SELECT actividades.id AS id_actividad FROM actividades JOIN alumnos_actividades ON actividades.id = alumnos_actividades.id_actividad WHERE actividades.project_id = $idProyecto AND alumnos_actividades.id_alumno = $idAlumno";
        $rActividades = mysqli_query($conn, $actividadesQuery);
        
        if ($rActividades && mysqli_num_rows($rActividades) > 0) {
            $notaProyecto = 0;
            $totalActividades = 0;
    
            while ($actividad = mysqli_fetch_assoc($rActividades)) {
                $idActividad = $actividad['id_actividad'];
    
                //Calcular la media ponderada de los ítems para la actividad
                $itemsQuery = "SELECT alumnos_items.notaItem, items.valor FROM alumnos_items JOIN items ON alumnos_items.id_item = items.id WHERE items.activity_id = $idActividad AND alumnos_items.id_alumno = $idAlumno";
                $rItems = mysqli_query($conn, $itemsQuery);
    
                if ($rItems && mysqli_num_rows($rItems) > 0) {
                    $sumaNotas = 0;
                    $sumaPesos = 0;
    
                    while ($item = mysqli_fetch_assoc($rItems)) {
                        $notaItem = $item['notaItem'];
                        $peso = $item['valor'];
    
                        $sumaNotas += $notaItem * $peso;
                        $sumaPesos += $peso;
                    }
                    // Media ponderada de los ítems para la actividad
                    if ($sumaPesos > 0) {
                        $notaActividad = $sumaNotas / $sumaPesos;
                        $notaProyecto += $notaActividad;
                        $totalActividades++;
                    }
                }
            }
            // Media de las actividades para el proyecto
            if ($totalActividades > 0) {
                return $notaProyecto / $totalActividades;
            }
        }
        // Si no hay actividades o ítems evaluados, retornar 0
        return 0;
    }


    function encontrarNotaCurso($conn, $idAlumno, $idCurso) {
        // Obtener todos los proyectos relacionados con el curso
        $proyectosQuery = "SELECT proyectos.id AS id_proyecto FROM proyectos JOIN alumnos_proyectos ON proyectos.id = alumnos_proyectos.id_proyecto WHERE proyectos.curso_id = $idCurso AND alumnos_proyectos.id_alumno = $idAlumno";
        $rProyectos = mysqli_query($conn, $proyectosQuery);
    
        if ($rProyectos && mysqli_num_rows($rProyectos) > 0) {
            $notaCurso = 0;
            $totalProyectos = 0;
    
            while ($rowPro = mysqli_fetch_assoc($rProyectos)) {
                $idProyecto = $rowPro['id_proyecto'];
                // Calcular la nota del proyecto
                $notaProyecto = encontrarNotaProyecto($conn, $idAlumno, $idProyecto);
    
                $notaCurso += $notaProyecto;
                $totalProyectos++;
            }
            // Media de los proyectos para el curso
            if ($totalProyectos > 0) {
                return $notaCurso / $totalProyectos;
            }
        }
        // Si no hay proyectos evaluados, retornar 0
        return 0;
    }



    function mostrarTablaAlumnos($conn, $idCurso) {
        // Obtener los alumnos relacionados con el proyecto
        $selectCurso = "SELECT * FROM alumnos WHERE curso_id  = $idCurso";
        $resultsql = mysqli_query($conn, $selectCurso);
    
        if ($resultsql && mysqli_num_rows($resultsql) > 0) {
            while ($row = mysqli_fetch_assoc($resultsql)) {
                $idAlumno = $row['id'];
                $nameAlumno = $row['name'];
    
                // Calcular la nota del proyecto para el alumno
                $notaProyecto = encontrarNotaProyecto($conn, $idAlumno, $idCurso);
    
                echo '<tr>';
                echo '<td>' . $nameAlumno . '</td>';
                echo '<td>' . number_format($notaProyecto, 1) . '</td>'; // Mostrar la nota con 2 decimales
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="2">No hay alumnos asignados a este proyecto.</td></tr>';
        }
    }
    
    
?>