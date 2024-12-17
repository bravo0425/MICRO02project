<?php

    session_start();
    include "../../../conexion.php";


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


    if (isset($_GET['id'])) {
        $idProject = $_GET['id'];
    
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
    
        mysqli_close($conn);
    } else {
        $titulo = "Error";
        $descripcion = "No se recibió el ID del proyecto.";
        $actividades = [];
    }



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
                    <h1>TASKIFY®</h1>
                    <div class="usuario">
                        <img src="../../../imagenes/usuario.png" width="23px">
                        <h3><?php echo $nom . ' ' . $apellido ?></h3>
                    </div>
                </div>
                <div class="navbar">
                    <button onclick="goDasboard()" class="menu">
                        <img src="../../../imagenes/dashboard.png" width="27px">
                        <h2>Dashboard</h2>
                    </button>
                    <button onclick="goCursos()" class="menu active">
                        <img src="../../../imagenes/cursos.png" width="27px">
                        <h2>Cursos</h2>
                    </button>
                    <button onclick="goStudents()" class="menu">
                        <img src="../../../imagenes/students.png" width="27px">
                        <h2>Students</h2>
                    </button>
                    <button onclick="goChat()" class="menu">
                        <img src="../../../imagenes/chat.png" width="27px">
                        <h2>Chat</h2>
                    </button>
                    <button onclick="goSettings()" class="menu">
                        <img src="../../../imagenes/settings.png" width="27px">
                        <h2>Settings</h2>
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
                    <img src="../../../imagenes/cerrar-sesion.png" width="23px" style="color: #FFFFFF;">
                    <h2>Log out</h2>
                </button>
            </form>
        </div>

        <!-- contenido -->
        <div class="contenido">

            <div id="arriba">

                <div id="mobileApp" class="card">
                    <div class="titulosMobile">
                        <h2>Projects</h2>
                    </div>
                    <button onclick="goCursos()">Volver a cursos</button>
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
                                <th>Nombre de la Actividad</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($actividades)) {
                                foreach ($actividades as $actividad) {
                                    echo "<tr>";
                                    echo "<td><button onclick='goActivity()'>" . htmlspecialchars($actividad['titulo']) . "</button></td>";
                                    echo "<td>" . htmlspecialchars($actividad['descripcion']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>No se encontraron actividades para este proyecto.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="buttonsTabla">

                </div>

            </div>

        </div>
    </div>
        
    <script src="project.js"></script>
</body>
</html>