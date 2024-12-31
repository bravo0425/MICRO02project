<?php
    include "../../conexion.php";

    session_start();

    if(isset($_SESSION['nombreUser'])){
        $usuarioLog = $_SESSION['nombreUser'];
        $idProfe = $_SESSION['idProfe'];
        $nom = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $idCurso = $_SESSION['idCurso'];
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
    <title>Settings</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="settings.css">
</head>
<body>

<!--Container general-->
    <div class="container">     

        <!-- menu--> 
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
                    <button onclick="goCursos()" class="menu">
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
                    <button onclick="goSettings()" class="menu active">
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

            <!-- arriba -->
            <div id="arriba">

                <div id="infoApp" class="card">
                    <h2>Settings</h2>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>

                    <form method="POST" action="../main/index.php">
                        <button type="submit">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                            </a>
                            <p>back to dashboard</p>
                        </button>
                    </form>
                </div>

                <div id="infoCurso" class="card">
                    <div id="estadisticasCurso">
                        
                    </div>
                </div>
                
            </div>

            <!-- abajo -->
            <div id="abajo" class="card">
                
            </div>

        </div><!--Contenido-->
    </div><!--Container-->
        
    <script src="settings.js"></script>
</body>
</html>