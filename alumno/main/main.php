<?php
    include "../../conexion.php";

    session_start();

    if(isset($_SESSION['nombreUser'])){
        $usuarioLog = $_SESSION['nombreUser'];
        $nom = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $idAlumno = $_SESSION['idAlumno'];
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link rel="stylesheet" href="main.css">
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
                        <img src="../../imagenes/usuario.png" width="23px">
                        <h3><?php echo $nom . ' ' . $apellido ?></h3>
                    </div>
                </div>
                <div class="navbar">
                    <button onclick="goDasboard()" class="menu active">
                        <img src="../../imagenes/dashboard.png" width="27px">
                        <h2>Dashboard</h2>
                    </button>
                    <button onclick="goTasks()" class="menu">
                        <img src="../../imagenes/cursos.png" width="27px">
                        <h2>Tasks</h2>
                    </button>
                    <button onclick="goProjects()" class="menu">
                        <img src="../../imagenes/students.png" width="27px">
                        <h2>Projects</h2>
                    </button>
                    <button onclick="goChat()" class="menu">
                        <img src="../../imagenes/chat.png" width="27px">
                        <h2>Chat</h2>
                    </button>
                    <button onclick="goSettings()" class="menu">
                        <img src="../../imagenes/settings.png" width="27px">
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
                <button type="submit" name="logout" value="logout" class="log-out">
                    <img src="../../imagenes/cerrar-sesion.png" width="23px" style="color: #FFFFFF;">
                    <h2>Log out</h2>
                </button>
            </form>
        </div>

        <!-- contenido -->
        <div class="contenido"> 
            <div id="arriba">
                <div id="mobileApp" class="card">
                    <div class="titulosMobile">
                        <h2>User-friendly</h2>
                        <h2>mobile app</h2>
                    </div>
                    <div class="redesSociales">
                        <div class="centLeft">
                            <a href="" class="svgG">G</a>
                            <a href="" class="svgApple"><img src="../../imagenes/747.png" alt=""></a>
                        </div>
                        <a href="" class="svgArrow">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div id="lastActivities">
                    <h1>Last Activities</h1>
                    <?php
                    $select = "SELECT id_actividad FROM alumnos_actividades WHERE id_alumno = $idAlumno";
                    $resultado = mysqli_query($conn, $select);
                    
                    $actividades = [];
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            $idActividad = $fila['id_actividad'];
                            $array_id_actividades[] = $idActividad;
                        }
                    }    
                    $selectActividad = "SELECT id, titulo, due_date FROM actividades WHERE id IN (".implode(',', $array_id_actividades).") ORDER BY ABS(DATEDIFF(due_date, CURDATE())) ASC LIMIT 0";
                    $resultadoActividad = mysqli_query($conn, $selectActividad);
                    ?>
                    <div id="cards-activities">
                    <?php
                    
                    if (mysqli_num_rows($resultadoActividad) > 0) {
                        $contador_act = 1;
                        while ($fila = mysqli_fetch_assoc($resultadoActividad)) {
                            ?>
                            <?php
                            
                            if($contador_act <= 3){
                                ?>
                                <div class="lastActivity">
                                    <h2><?php echo $fila['titulo']; ?></h2>
                                    <p><?php echo $fila['due_date']; ?></p>
                                </div>
                                <?php
                                $contador_act++;
                            } 
                        }
                    } else {
                        ?>
                        <div class="noActivities">
                            <h2>No activities</h2>
                        </div>
                        <?php
                    }
                    ?> 
                    </div>
                </div>
            </div>
            <div id="abajo">
                <button type="button" id="tasks" onclick="location.href='../tasks/tasks.php'" >Tasks</button>
                <button type="button" id="projects" onclick="location.href='../projects/projects.php'">Projects</button>
            </div>
        </div>
    </div>
        
    <script src="main.js"></script>
</body>
</html>