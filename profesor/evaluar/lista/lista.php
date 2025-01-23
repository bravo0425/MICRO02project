<?php

    session_start();
    include "../../../conexion.php";
    include "functions.php";

    if(isset($_SESSION['nombreUser'])){
        $usuarioLog = $_SESSION['nombreUser'];
        $nom = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
    }else{
        header('Location: ../../../login/login.php');
        exit();
    }

    if (!empty($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: ../../../login/login.php');
        exit();
    }

    if (isset($_SESSION['idActividad'])) {
        // Asegurarse de que el ID es un número entero para prevenir inyecciones SQL
        $idActivity = intval($_SESSION['idActividad']);
        
        // Consulta para obtener los detalles de la actividad
        $queryAct = "SELECT * FROM actividades WHERE id = $idActivity";
        $result = mysqli_query($conn, $queryAct);
        
        // Verificar si la consulta devuelve algún resultado
        if (mysqli_num_rows($result) > 0) {
            // Si la actividad es encontrada, obtener los detalles
            $act = mysqli_fetch_assoc($result);
            $titulo = htmlspecialchars($act['titulo']);
            $descripcion = htmlspecialchars($act['descripcion']);
            $dueDate = htmlspecialchars($act['due_date']);
            $estado = (intval($act['active']) == 1) ? "Active" : "Inactive";

        } else {
            // Si no se encuentra la actividad, establecer un mensaje por defecto
            $titulo = "Actividad no encontrada";
            $descripcion = "No hay detalles disponibles para esta actividad.";
        }

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviarIdAlumno'])){
        $_SESSION['idAlumno'] = $_POST['enviarIdAlumno'];
        header('Location: ../notas/notas.php');
        exit;
    }

    // Obtener todos los alumnos que tienen ítems relacionados con la actividad
    $alumnosQuery = "SELECT DISTINCT alumnos_items.id_alumno FROM alumnos_items JOIN items ON alumnos_items.id_item = items.id WHERE items.activity_id = $idActivity";
    $rAlumnos = mysqli_query($conn, $alumnosQuery);

    if ($rAlumnos && mysqli_num_rows($rAlumnos) > 0) {
        while ($alumno = mysqli_fetch_assoc($rAlumnos)) {
            $idAlumno = $alumno['id_alumno'];

            // Obtener todos los ítems relacionados con la actividad para el alumno actual
            $allItems = "SELECT alumnos_items.id_item, alumnos_items.notaItem FROM alumnos_items JOIN items ON alumnos_items.id_item = items.id WHERE items.activity_id = $idActivity AND alumnos_items.id_alumno = $idAlumno";
            $rAllItems = mysqli_query($conn, $allItems);

            $todosEvaluados = true;

            if ($rAllItems && mysqli_num_rows($rAllItems) > 0) {
                while ($row = mysqli_fetch_assoc($rAllItems)) {
                    // Si algún ítem no tiene nota, marcamos $todosEvaluados como falso
                    if ($row['notaItem'] === null || $row['notaItem'] === '') {
                        $todosEvaluados = false;
                        break;
                    }
                }
                // Si todos los ítems tienen nota, marcar la actividad como evaluada
                if ($todosEvaluados) {
                    $updateActivity = "UPDATE alumnos_actividades SET evaluado = 1 WHERE id_alumno = $idAlumno AND id_actividad = $idActivity";
                    mysqli_query($conn, $updateActivity);
                }
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Evaluar Activity</title>
    <link rel="stylesheet" href="lista.css">
</head>
<body>

<!--Container general-->
    <div class="container">     
        <!-- menu izquierda--> 
        <div class="contenedor-nav">
            <div class="nav">
                <div class="titulo">
                    <h1>Taskify®</h1>
                </div>
                <div class="usuario">
                    <?php mostrarImg($conn); ?>
                    <h3><?php echo $nom ?></h3>
                </div>
                <div class="navbar">
                    <button onclick="goDasboard()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../../imagenes/dashboard.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Dashboard</h2>
                            </div>
                        </div>
                    </button>

                    <button onclick="goCursos()" class="menu active">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../../imagenes/cursos.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Cursos</h2>
                            </div>
                        </div>
                    </button>

                    <button onclick="goStudents()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../../imagenes/students.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Students</h2>
                            </div>
                        </div>
                    </button>

                    <button onclick="goChat()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../../imagenes/chat.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Chat</h2>
                            </div>
                        </div>
                    </button>

                    <button onclick="goSettings()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../../imagenes/settings.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Settings</h2>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
            <div class="update">
                <h4>Try to update</h4>
                <p>Version 1.0v</p>
                <div class="botones-update">
                    <button type="button" id="update">Update</button>
                    <button type="button" id="more">More</button>
                </div>
            </div>
            <form action="" method="POST">
                <button type="submit" name="logout" value="tonto" class="log-out">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="iconLogout">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                    </svg>

                    <h2>Log out</h2>
                </button>
            </form>
        </div>

        <!-- contenido -->
        <div class="contenido">

            <div id="arriba">

                <div id="infoApp" class="card">
                    <h2>Evaluate Activity</h2>
                    <form method="POST" action="../../activities/activity.php">
                        <button type="submit">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                            </a>
                            <p>back to activities</p>
                        </button>
                    </form>
                </div>

                <div id="description" class="card">
                    <div class="description-action">
                        <h4>Activity</h4>
                        <button class="editProject" onclick="abrirEditorProject()">
                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' width='20' height='20' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                <path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
                            </svg>
                        </button>
                    </div>
                    <div class="descriptionInfo">
                        <h1><?php echo $titulo; ?></h1>
                        <p><?php echo $descripcion; ?></p>
                        <p>Last date: <span><?php echo $dueDate; ?></span> </p>
                    </div>
                </div>
                
            </div>


            <div id="abajo"  class="card">
                <h2>Listado de alumnos</h2>
                <div id="tablaNotas">
                    <table>
                        <thead>
                            <tr>
                                <th id='borderLeft'>Nom</th>
                                <th>File</th>
                                <th>Activity status</th>
                                <th id='borderRight'>Evaluar</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $queryStudents = " SELECT alumnos.name AS alumno_name, alumnos.last_name, alumnos_actividades.id_alumno, alumnos_actividades.id_actividad, alumnos_actividades.evaluado, alumnos_actividades.entregado FROM alumnos_actividades JOIN alumnos ON alumnos_actividades.id_alumno = alumnos.id WHERE alumnos_actividades.id_actividad = $idActivity ";

                                $resultStudents = mysqli_query($conn, $queryStudents);

                                while ($fila = mysqli_fetch_assoc($resultStudents)) {
                            ?>
                                <form action="" method="POST">
                                    <tr>
                                        <td><?php echo $fila['alumno_name'] . ' ' . $fila['last_name']; ?></td>
                                        <td><button class="descargarBtn">Descargar</button></td>

                                    <?php
                                        $entregado = $fila['entregado'];
                                        if ($entregado == 1) {
                                            echo "<td>Entregado</td>";
                                        } else {
                                            echo "<td>No entregado</td>";
                                        }

                                        // Botón para evaluar o mostrar como ya evaluado
                                        $evaluado = $fila['evaluado'];
                                        if ($evaluado == 1) {
                                            echo "<td><button type='submit' name='enviarIdAlumno' value='" . $fila['id_alumno'] . "' class='okEva'>Evaluado</button></td>";
                                        } else {
                                            echo "<td><button type='submit' name='enviarIdAlumno' value='" . $fila['id_alumno'] . "' class='noEva'>Evaluar</button></td>";
                                        }
                                    ?>
                                    
                                    </tr>
                                </form>
                            <?php } ?>
                        </tbody>                          
                    </table>
                </div>

            </div>

        </div>
    </div>
        
    <script src="lista.js"></script>
</body>
</html>