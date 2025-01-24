<?php
    include "../../conexion.php";

    session_start();

    if(isset($_SESSION['nombreUser'])){
        $usuarioLog = $_SESSION['nombreUser'];
        $nom = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $idAlumno = $_SESSION['idAlumno'];
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
    <title>Projects</title>
    <link rel="stylesheet" href="projects.css">
</head>
<body>
    <div class="container">     
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
                    <button onclick="goTasks()" class="menu">
                        <img src="../../imagenes/cursos.png" width="27px">
                        <h2>Tasks</h2>
                    </button>
                    <button onclick="goProjects()" class="menu active">
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
        <div class="contenido">
            <div id="arriba">
                <div id="infoApp" class="card">
                    <h2>Projects</h1>
                    <form method="POST" action="../main/main.php">
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
                <div id="infoCurso">
                    <div class="tituloCurso">
                        <?php
                            $selectCurso = "SELECT * FROM cursos WHERE id = $idCurso";
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
                            <h3>Projects</h3>
                            <div class="numProjects">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                                </svg>
                                <?php
                                $queryContarProyectos = "SELECT COUNT(*) AS total_proyectos FROM proyectos WHERE curso_id = $idCurso";
                                $resultadoContarProyectos = mysqli_query($conn, $queryContarProyectos);
                            
                                // Obtén el número total de proyectos
                                $totalProyectos = 0;
                                if ($fila = mysqli_fetch_assoc($resultadoContarProyectos)) {
                                    $totalProyectos = $fila['total_proyectos'];
                                }
                                ?>
                                <p><?php echo $totalProyectos; ?></p>
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
            <div id="abajo">
                <form method="POST" class="proyectos card">
                <?php 
                    if(!empty($_POST['proyectoDiv'])) {
                        $proyectoID = $_POST['proyectoDiv'];
                        ?>
                        <div id="listaActividades">
                            <div id="mostrarActivities">
                                <table border="0" id="tablaActividades">
                                    <thead>
                                        <tr>
                                            <th>Activity</th>
                                            <th>Created At</th>
                                            <th>Due Date</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $selectActividad = "SELECT * FROM actividades WHERE project_id = $proyectoID";
                                            $resultActividad = mysqli_query($conn, $selectActividad);
                                            if (mysqli_num_rows($resultActividad) > 0) {
                                                while ($row = mysqli_fetch_assoc($resultActividad)) {
                                                    $idActividad = $row['id'];
                                                    $titulo = $row['titulo'];
                                                    $createdAt = $row['created_at'];
                                                    $dueDate = $row['due_date'];
                                                    $select = "SELECT * FROM alumnos_actividades WHERE id_actividad = $idActividad";
                                                    $result = mysqli_query($conn, $select);
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($fila = mysqli_fetch_assoc($result)) {
                                                            $nota = $fila['notas'];
                                                            echo "<tr>";
                                                            echo "<td>" . $titulo . "</td>";
                                                            echo "<td>" . $createdAt . "</td>";
                                                            echo "<td>" . $dueDate . "</td>";
                                                            if ($nota) {
                                                                echo "<td><p>" . $nota . "</p></td>";
                                                            } else {
                                                                echo "<td><p class='evaluado'>No evaluado</p></td>";
                                                            }
                                                            echo "</tr>";
                                                        }
                                                    }
                                                }
                                            } else {
                                                echo "<tr><td>Actividad no encontrada</td></tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } else {
                        $selectProyectos = "SELECT * FROM proyectos WHERE curso_id = $idCurso";
                        $resultadoProyectos = mysqli_query($conn, $selectProyectos);
                        if (mysqli_num_rows($resultadoProyectos) > 0){
                            while($fila = mysqli_fetch_assoc($resultadoProyectos)){
                                ?>
                                <button type="submit" name="proyectoDiv" value="<?php echo $fila['id']; ?>" class="cardProyecto">
                                    <p><span><?php echo $fila['titulo']; ?> <br></span><?php echo $fila['descripcion']; ?></p>
                                </button>                                
                                <?php
                            }
                        }
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
<script src="projects.js"></script>
</body>
</html>