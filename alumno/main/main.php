<?php
    include "../../conexion.php";

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
                    <button onclick="goCursos()" class="menu">
                        <img src="../../imagenes/cursos.png" width="27px">
                        <h2>Cursos</h2>
                    </button>
                    <button onclick="goStudents()" class="menu">
                        <img src="../../imagenes/students.png" width="27px">
                        <h2>Students</h2>
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
                <button type="submit" name="logout" value="tonto" class="log-out">
                    <img src="../../imagenes/cerrar-sesion.png" width="23px" style="color: #FFFFFF;">
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
                        <a href="">Google</a>
                        <a href="">Apple</a>
                        <a href="">flexa</a>
                    </div>
                </div>
                <div id="lastProject" class="card">
                    <div id="titulo">
                        <h1>Last project</h1>
                        <h2>MICRO02-DAW</h2>
                    </div>
                    <img src="../../imagenes/project.jpg" alt="">
                    <div>
                        <input type="text" placeholder="Find whatever">
                    </div>
                </div>
            </div>
            <div id="right">
                <div id="lastActivities" class="card">
                    <h1>Last Activities</h1>
                    <div class="lastActivity">
                        <h2>Create DB</h2>
                        <p>8-12-2024</p>
                        <p>10:00</p>
                    </div>
                    <div class="lastActivity" class="card">
                        <h2>Create DB</h2>
                        <p>8-12-2024</p>
                        <p>10:00</p>
                    </div>
                </div>
                <div id="estadisticaAlumnos" class="card">
                    <h1>Students Scores</h1>
                </div>
                <div id="calendario" class="card">
                    <h1>Calendar</h1>
                </div>
            </div>



        </div>
    </div>
        
    <script src="main.js"></script>
</body>
</html>