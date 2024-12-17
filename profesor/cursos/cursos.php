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
    <link rel="stylesheet" href="cursos.css">
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
                    <button onclick="goDasboard()" class="menu">
                        <img src="../../imagenes/dashboard.png" width="27px">
                        <h2>Dashboard</h2>
                    </button>
                    <button onclick="goCursos()" class="menu active">
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

            <div id="arriba">

                <div id="mobileApp" class="card">
                    <div class="titulosMobile">
                        <h2>Cursos</h2>
                    </div>
                </div>

                <div id="lastActivities" class="card">
                    <h1>DAW</h1>
                    <div id="cards-activities">
                        <div class="lastActivity">
                        </div>
                        <div class="lastActivity">
                        </div>
                    </div>
                </div>
                
            </div>


            <div id="abajo">

                <div id="abajoLeft">

                    <div id="divProjects" class="card">
                        <div id="titulo">
                            <h1>Projects</h1>
                            <div class="listadoProjects">
                                <button onclick="irProject()">
                                    <img src="../../imagenes/cursos.png" alt="">
                                    <p>Micro01</p>
                                </button>
                                <button onclick="irProject()">
                                    <img src="../../imagenes/cursos.png" alt="">
                                    <p>Micro02</p>
                                </button>
                                <button onclick="irProject()">
                                    <img src="../../imagenes/cursos.png" alt="">
                                    <p>Micro03</p>
                                </button>
                                <button onclick="irProject()">
                                    <img src="../../imagenes/cursos.png" alt="">
                                    <p>Micro04</p>
                                </button>
                                <button onclick="irProject()">
                                    <img src="../../imagenes/cursos.png" alt="">
                                    <p>Micro05</p>
                                </button>
                            </div>
                        </div>
                        <div id="botonesProjects">
                            <button class="addProject">+Add</button>
                            <button class="deleteProject">Delete</button>
                        </div>
                    </div>

                </div>

                <div id="abajoRight">
                    <div id="estadisticaAlumnos" class="card">
                        <h1>Students Scores</h1>
                        <div id="grafica">

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
        
    <script src="curso.js"></script>
</body>
</html>