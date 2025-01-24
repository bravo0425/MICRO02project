<?php
    include "../../conexion.php";
    include "functionsMain.php";

    session_start();

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
                    <h1>Taskify®</h1>
                </div>
                <div class="usuario">
                    <img src="../../imagenes/usuario.png" width="23px">
                    <h3><?php echo $nom ?></h3>
                </div>
                <div class="navbar">
                    <button onclick="goDasboard()" class="menu active">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/dashboard.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Dashboard</h2>
                            </div>
                        </div>
                        
                    </button>
                    <button onclick="goCursos()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/cursos.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Subjects</h2>
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

            <div id="left">
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
                <div id="lastProject" class="card">
                    <div class="contProject">
                        <div id="tituloProject">
                            <div class="firsttitle">
                                <h1>Last project</h1>
                                <button onclick="goCursos()">All ></button>
                            </div>
                            <div class="secondtitle">
                                <?php
                                $selectLastProject = "SELECT titulo, created_at FROM proyectos ORDER BY created_at DESC LIMIT 1";
                                $result = mysqli_query($conn, $selectLastProject);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <h2><?php echo $row['titulo']; ?></h2>
                                <p><?php echo $row['created_at']; ?></p>
                            </div>
                        </div>
                        <img src="../../imagenes/project.jpg" alt="" style="width: 300px;">
                        <div class="inputFind">
                            <input type="text" placeholder="Find whatever">
                        </div>
                    </div>
                </div>
                
            </div>


            <div id="right">

                <div id="lastActivities">
                    <h1>Last Activities</h1>
                    <?php
                    $select = "SELECT actividades.id, actividades.titulo, actividades.due_date FROM actividades  JOIN proyectos ON actividades.project_id = proyectos.id  ORDER BY ABS(DATEDIFF(actividades.due_date, CURDATE())) ASC";
                    $resultado = mysqli_query($conn, $select);
                    ?>
                    <div id="cards-activities">
                        <?php 
                        if (mysqli_num_rows($resultado) > 0) {
                            $contador = 1;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                if ($contador <= 3) {
                                    ?>
                                    <div class="lastActivity">
                                        <h2><?php echo $fila['titulo']; ?></h2>
                                        <p><?php echo $fila['due_date']; ?></p>
                                    </div>
                                    <?php
                                    $contador++;
                                }
                            }
                        } else {
                            ?>
                            <div class="noActivities">
                                <h2>No activities</h2>
                            </div>
                  <?php } ?>
                    </div>
                </div>

                <div id="estadisticaAlumnos" class="card">
                    <h1>Students Scores</h1>
                    <div id="grafica">

                    </div>
                </div>

                <div id="hardmode" class="card">
                    <button class="yellowbtn">Stats</button>
                    <button class="lilabtn">Ranking</button>
                </div>
                
            </div>

        </div>
    </div>
        
    <script src="main.js"></script>
</body>
</html>