<?php

    session_start();
    include "../../conexion.php";
    include "functions.php";

    if(isset($_SESSION['nombreUser'])){
        $usuarioLog = $_SESSION['nombreUser'];
        $nom = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
    }else{
        header('Location: ../../login/login.php');
        exit();
    }

    if (!empty($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: ../../login/login.php');
        exit();
    }


    if (!empty($_POST['idProyecto'])) {
        $idProject = intval($_POST['idProyecto']);
    
        // Consulta para obtener los detalles del proyecto
        $queryProjects = "SELECT * FROM proyectos WHERE id = $idProject";
        $result = mysqli_query($conn, $queryProjects);
    
        if (mysqli_num_rows($result) > 0) {
            $project = mysqli_fetch_assoc($result);
            $titulo = $project['titulo'];
            $descripcion = $project['descripcion'];
        } else {
            $titulo = "Proyecto no encontrado";
            $descripcion = "No hay detalles disponibles para este proyecto.";
        }
    
        // Consulta para obtener las actividades relacionadas con el proyecto
        $queryActividades = "SELECT * FROM actividades WHERE project_id = $idProject";
        $resultActividades = mysqli_query($conn, $queryActividades);
    
        $actividades = [];
        if (mysqli_num_rows($resultActividades) > 0) {
            while ($actividad = mysqli_fetch_assoc($resultActividades)) {
                $actividades[] = $actividad;
            }
        }
    } else {
        $titulo = "Error";
        $descripcion = "No se recibió el ID del proyecto.";
        $actividades = [];
    }


    if(!empty($_POST['añadir'])) {
        crearActividad($conn);
    }

    mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link rel="stylesheet" href="project.css">
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
                    <img src="../../imagenes/usuario.png" width="23px">
                    <h3><?php echo $nom ?></h3>
                </div>
                <div class="navbar">
                    <button onclick="goDasboard()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/dashboard.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Dashboard</h2>
                            </div>
                        </div>
                        
                    </button>
                    <button onclick="goCursos()" class="menu active">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/cursos.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Cursos</h2>
                            </div>
                        </div>
                    </button>
                    <button onclick="goStudents()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/students.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Students</h2>
                            </div>
                        </div>
                    </button>
                    <button onclick="goChat()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/chat.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Chat</h2>
                            </div>
                        </div>
                    </button>
                    <button onclick="goSettings()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/settings.png" width="27px">
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
                    <h2>Projects</h2>
                    <form method="POST" action="../cursos/cursos.php">
                        <button type="submit">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                            </a>
                            <p>back to courses</p>
                        </button>
                    </form>
                </div>

                <div id="description" class="card">
                    <h1><?php echo htmlspecialchars($titulo); ?></h1>
                    <div id="text">
                        <p><?php echo htmlspecialchars($descripcion); ?></p>
                    </div>
                </div>
                
            </div>


            <div id="abajo" class="card">
                <div id="tabla">
                    <table>
                        <thead>
                            <tr>
                                <th>Activities</th>
                                <th>Due_Date</th>
                                <th>Status</th>
                                <th >Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($actividades)) {
                                foreach ($actividades as $actividad) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($actividad['titulo']) . "</td>";
                                    echo "<td>" . htmlspecialchars($actividad['due_date']) . "</td>";
                                    echo "<td>" . $actividad['active'] ."</td>";
                                    echo "<td><form method='POST' action='../activities/activity.php'>
                                        <button type='sumbit' name='seeActivity' value='" . $actividad['id'] ."'>
                                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' width='20' height='20' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                                <path stroke-linecap='round' stroke-linejoin='round' d='M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z' />
                                                <path stroke-linecap='round' stroke-linejoin='round' d='M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' />
                                            </svg>
                                        </button>
                                        <button type='sumbit' name='editActivity' value='" . $actividad['id'] ."'>
                                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' width='20' height='20' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                                <path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
                                            </svg>
                                        </button>
                                        <button type='sumbit' name='deleteActivity' value='" . $actividad['id'] ."'>
                                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' width='20' height='20' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                                <path stroke-linecap='round' stroke-linejoin='round' d='m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0' />
                                            </svg>
                                        </button>
                                        </form>
                                    </td>";

                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No se encontraron actividades para este proyecto.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div id="insertarActividad" >
                    <form action="" method="POST" id="formInsert">
                        <h2>Crear una nueva Actividad</h2>
                        <div class="column">
                            <label for="tituloActNew">titulo</label>
                            <input type="text" name="tituloActNew" id="">
                        </div>
                        <div class="column">
                            <label for="descriptionActNew">descripcion</label>
                            <textarea type="text" name="descriptionActNew" id=""></textarea>
                        </div>
                        <div class="column">
                            <label for="dueDateActNew">due_date</label>
                            <input type="date" name="dueDateActNew" id="">
                        </div>
                        <div class="column">
                            <label for="estadoActNew">Estado</label>
                            <select name="estadoActNew" id="">
                                <option value="1">Activa</option>
                                <option value="0">Inactiva</option>
                            </select>
                        </div>
                        
                        <div id="buttonsInsert">
                            <input type="submit" id="add" name="añadir" value="añadir">
                            <input type="submit" id="cancel" name="cancelar" value="cancelar">
                        </div>
                    </form>
                </div>

                <div id="buttonsTabla">
                    <button class="addCard" onclick="addActivity()">+ Add new Activity</button>
                    <button class="editCard">Modify Activity</button>
                    <button class="deleteCard">Delete Activity</button>
                </div>

            </div>

        </div>
    </div>
        
    <script src="project.js"></script>
</body>
</html>