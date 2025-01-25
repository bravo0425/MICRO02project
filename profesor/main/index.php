<?php
include "../../conexion.php";
include "functionsMain.php";

session_start();

if (isset($_SESSION['nombreUser'])) {
    $usuarioLog = $_SESSION['nombreUser'];
    $nom = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $idCurso = $_SESSION['idCurso'];
} else {
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
    <script src="https://code.highcharts.com/highcharts.js"></script>
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
                            <form method="post" action="../cursos/cursos.php" class="firsttitle">
                                <h1>Last project</h1>
                                <button type="submit">All ></button>
                            </form>
                            <div class="secondtitle">
                                <?php
                                $selectLastProject = "SELECT * FROM proyectos ORDER BY created_at DESC LIMIT 1";
                                $result = mysqli_query($conn, $selectLastProject);
                                $row = mysqli_fetch_assoc($result);
                                $idCurso = $row['curso_id'];
                                ?>
                                <h2><?php echo $row['titulo']; ?></h2>
                                <p><?php if($idCurso == 502){
                                    echo 'SMIX';
                                }else if($idCurso == 501){
                                    echo 'DAW';
                                }else if($idCurso == 503){
                                    echo 'ASIX';
                                }else{
                                    echo 'None';
                                }
                                ?></p>
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
                    $select = "SELECT actividades.* FROM actividades  JOIN proyectos ON actividades.project_id = proyectos.id  ORDER BY ABS(DATEDIFF(actividades.due_date, CURDATE())) ASC";
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
                                        <div class="leftContent">
                                            <h2><?php echo $fila['titulo']; ?></h2>
                                            <p>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                                </svg>
                                                <?php echo $fila['due_date']; ?>
                                            </p>
                                        </div>
                                        <div class="rigthContent">
                                            <?php
                                            if ($fila['active'] == 1) {
                                                echo "<div class='statusActive'></div>";
                                            } else {
                                                echo "<div class='statusInactive'></div>";
                                            }
                                            ?>
                                        </div>
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
                        <table>
                            <thead>
                                <tr>
                                    <th>name</th>
                                    <th>Course Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                mostrarTablaAlumnos($conn, $idCurso);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="hardmode" class="card">
                    <button class="yellowbtn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                        <p>Estadisticas</p>
                    </button>
                    <button class="lilabtn">Ranking</button>
                </div>

            </div>

        </div>
    </div>

    <script src="main.js"></script>
</body>

</html>