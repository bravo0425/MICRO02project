<?php
    include "../../conexion.php";
    include "functions.php";

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
    
    if (!empty($_POST['show_popup'])) {
        $idActividadTemp = $_POST['show_popup'];
        $_SESSION['idActividadTemp'] = $idActividadTemp;
    }

    if(!empty($_POST['importar'])) {
        entregarActividad($conn);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="tasks.css">
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
                    <button onclick="goTasks()" class="menu active">
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
        <div class="contenido">
            <div id="arriba">
                <div id="infoApp" class="card">
                    <h2>Tasks</h2>
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
            </div>
            <div id="abajo" class="card">
                <?php if (!empty($_POST['show_popup'])) {
                    ?>
                <div id="popup">
                    <div class="popup-content card">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <button type="submit" id="close_popup" name="close_popup" class="close-btn" value="close_popup">X</button>
                            <div class="buttonsPopup">
                                <label for="file">Add you file</label>
                                <input type="file" name="file" id="file">
                                <button type="submit" name="importar" value="importar">Importar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                }else {
                    ?>
                <form action="" method="POST" id="listaActividades">
                    <div id="mostrarActivities">
                        <table border="0" id="tablaActividades">
                            <thead>
                                <tr>
                                    <th>Activity</th>
                                    <th>Created At</th>
                                    <th colspan="2">Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select = "SELECT * FROM alumnos_actividades WHERE id_alumno = $idAlumno";
                                $result = mysqli_query($conn, $select);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($fila = mysqli_fetch_assoc($result)) {
                                        $idActividad = $fila['id_actividad'];
                                        $entregado = $fila['entregado'];
                                        $selectActividad = "SELECT * FROM actividades WHERE id = $idActividad AND active = 1";
                                        $resultado = mysqli_query($conn, $selectActividad);
                                        if (mysqli_num_rows($resultado) > 0) {
                                            while ($row = mysqli_fetch_assoc($resultado)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['titulo'] . "</td>";
                                                echo "<td>" . $row['created_at'] . "</td>";
                                                echo "<td>" . $row['due_date'] . "</td>";
                                                if ($entregado == 1) {
                                                    echo "<td class='entregado'><p >Entregado</td>";
                                                } else {
                                                    echo "<td><button type='submit' name='show_popup' id='show_popup' value='" . $idActividad . "'>Entregar</button></td>";
                                                }
                                                echo "</tr>";
                                            }
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
<script src="tasks.js"></script>
</body>
</html>