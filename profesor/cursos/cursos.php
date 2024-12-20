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
    <title>Alumnos</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="cursos.css">
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

            <!-- arriba -->
            <div id="arriba">

                <div id="infoApp" class="card">
                    <h2>Cursos</h2>
                    <button>
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                            </svg>
                        </a>
                        <p>back to dashboard</p>
                    </button>
                </div>

                <div id="infoCurso">
                    <div class="tituloCurso">
                        <?php
                            $selectCurso = 'SELECT * FROM cursos WHERE id = ' . $idCurso;
                            $r = mysqli_query($conn, $selectCurso);

                            if(mysqli_num_rows($r) > 0){
                                while($fila = mysqli_fetch_assoc($r)) {
                                    echo "<h1>". $fila['nombre'] ."</h1>";
                                }
                            }
                        ?>
                    </div>
                    <div id="estadisticasCurso">
                        <div class="cardInfo">
                            <h3>Proyectos</h3>
                            <div class="numProjects">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                                </svg>
                                <p>3</p>
                            </div>
                        </div>

                        <div class="cardInfo">
                            <h3>Students</h3>
                            <div class="numProjects">
                                <img src="../../imagenes/students.png">
                                <p>25</p>
                            </div>
                        </div>
                        <div class="cardInfo">
                            <h3>Average Score</h3>
                            <div class="numProjects">
                                <div class="redondaStado"></div>
                                <p>7.5</p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- abajo -->
            <div id="abajo">

                <div id="abajoLeft">

                    <div id="divProjects" class="card">
                        <div id="titulo">
                            <h1>Projects</h1>
                            <div class="listadoProjects">
                                <?php
                                    $selectProject = 'SELECT * FROM proyectos WHERE curso_id = ' . $idCurso;
                                    $r = mysqli_query($conn, $selectProject);

                                    if(mysqli_num_rows($r) > 0){
                                        while($fila = mysqli_fetch_assoc($r)) {
                                            echo "<button onclick='irProject(". $fila['id'] .")'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                                        <path stroke-linecap='round' stroke-linejoin='round' d='M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z' />
                                                    </svg>
                                                    <p>". $fila['titulo'] ."</p>
                                                </button>";
                                        }
                                    }

                                    mysqli_close($conn);
                                ?>
                            </div>
                        </div>
                        <div id="botonesProjects">
                            <button class="openProject">Open</button>
                            <div class="displayRow">
                                <button class="addProject">+Add</button>
                                <button class="deleteProject">Delete</button>
                            </div>
                            
                        </div>
                    </div>

                </div><!--Abajo Left-->

                <div id="estadisticaAlumnos" class="card">
                    <h1>Students Scores</h1>
                    <div id="grafica">

                    </div>
                </div>


            </div><!--Abajo-->

        </div><!--Contenido-->
    </div><!--Container-->
        
    <script src="cursos.js"></script>
</body>
</html>