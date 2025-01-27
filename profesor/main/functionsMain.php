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
        $actividadesQuery = "SELECT actividades.id AS id_actividad FROM actividades JOIN alumnos_actividades ON actividades.id = alumnos_actividades.id_actividad WHERE actividades.project_id = $idProyecto AND alumnos_actividades.id_alumno = $idAlumno";
        $rActividades = mysqli_query($conn, $actividadesQuery);
        
        if ($rActividades && mysqli_num_rows($rActividades) > 0) {
            $notaProyecto = 0;
            $totalActividades = 0;
    
            while ($actividad = mysqli_fetch_assoc($rActividades)) {
                $idActividad = $actividad['id_actividad'];
                $itemsQuery = "SELECT alumnos_items.notaItem, items.valor FROM alumnos_items JOIN items ON alumnos_items.id_item = items.id WHERE items.activity_id = $idActividad AND alumnos_items.id_alumno = $idAlumno";
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
                    if ($sumaValor > 0) {
                        $notaActividad = $sumaNotas / $sumaValor;
                        $notaProyecto += $notaActividad;
                        $totalActividades++;
                    }
                }
            }
            if ($totalActividades > 0) {
                return $notaProyecto / $totalActividades;
            }
        }
        return '-'; // No evaluado
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
    
    function mostrarTablaAlumnos($conn, $idCurso){
        $selectCurso = "SELECT * FROM alumnos WHERE curso_id  = $idCurso";
        $resultsql = mysqli_query($conn, $selectCurso);
    
        if ($resultsql && mysqli_num_rows($resultsql) > 0) {
            while ($row = mysqli_fetch_assoc($resultsql)) {
                $idAlumno = $row['id'];
                $nameAlumno = $row['name'];
                // Calcular la nota del proyecto para el alumno
                $notaCurso = encontrarNotaCurso($conn, $idAlumno, $idCurso);
                
                echo '<div class="divAlumno">';
                echo '<div class="notaColumna"><p>' . number_format($notaCurso, 1) . '</p></div>';
                $notaWith = number_format($notaCurso, 0);
                $widthClass = 'w' . ($notaWith * 10);
                echo '<div class="' . $widthClass . '"></div>';

                echo '<div class="nombreColumna"><p>'. $nameAlumno .  '</p></div>';
                echo '</div>';
            }
        } else {
            echo '<div><p>No hay alumnos asignados a este proyecto.</p></div>';
        }
    }

    function mostrarCurso($conn, $idCurso){
        $queryCurso = "SELECT * FROM cursos WHERE id = $idCurso";
        $resultadoCurso = mysqli_query($conn, $queryCurso);
    
        if ($resultadoCurso && mysqli_num_rows($resultadoCurso) > 0) {
            $rowC = mysqli_fetch_assoc($resultadoCurso);
            echo "<h1>Course: " . htmlspecialchars($rowC['nombre']) . "</h1>";
        } else {
            echo " ";
        }
    }
    
    
?>