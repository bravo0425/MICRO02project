<?php
include "../../conexion.php";
include "functions.php";

session_start();

if (isset($_SESSION['nombreUser'])) {
    $usuarioLog = $_SESSION['nombreUser'];
    $nom = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $idAlumno = $_SESSION['idAlumno'];
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
                    <button onclick="goTasks()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/cursos.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Tasks</h2>
                            </div>
                        </div>
                    </button>
                    <button onclick="goProjects()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/students.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Projects</h2>
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
                <div id="fastlinks" class="card">
                    <h1>Fast links</h1>
                    <form action="" method="POST">
                        <button type="submit" class="FastBtn" name="show" value="show">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                            </svg>
                            <p>Show Active Task</p>
                        </button>
                        <button type="submit" class="FastBtn" name="scores" value="show">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            <p>Scores Projects</p>
                    </button>
                    </form>
                </div>
            </div>
            <div id="right">

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
                        $selectActividad = "SELECT actividades.* FROM actividades WHERE id IN (" . implode(',', $array_id_actividades) . ") ORDER BY ABS(DATEDIFF(due_date, CURDATE())) ASC";
                        $resultadoActividad = mysqli_query($conn, $selectActividad);
                    ?>
                        <div id="cards-activities">
                            <?php if (mysqli_num_rows($resultadoActividad) > 0) {
                                  $contador_act = 1;
                                  while ($fila = mysqli_fetch_assoc($resultadoActividad)) {
                                     if ($contador_act <= 3) {
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
                                    $contador_act++;
                                    }
                                }
                                ?>
                        </div>
                    <?php
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

                <div id="estadisticaAlumnos" class="card">
                    <h1>Students Scores</h1>
                </div>

            </div>
        </div>


    </div>
    </div>

    <script src="main.js"></script>
</body>

</html>