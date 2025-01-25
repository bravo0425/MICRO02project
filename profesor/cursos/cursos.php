<?php
include "../../conexion.php";
include "funciones.php";

session_start();

if (isset($_SESSION['nombreUser'])) {
    $usuarioLog = $_SESSION['nombreUser'];
    $idProfe = $_SESSION['idProfe'];
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idProyecto'])) {
    $_SESSION['idProyectoSeleccionado'] = $_POST['idProyecto'];
}

$mostrarFormulario = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addProject'])) {
    $mostrarFormulario = true;
}

// Manejar el caso cuando el usuario cancela agregar un proyecto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelAddProject'])) {
    $mostrarFormulario = false;
}

if (!empty($_POST["safeAddProject"])) {
    insertarProject($conn);
}

if (!empty($_POST['deleteProject'])) {
    eliminarProyecto($conn);
}

$queryContarProyectos = "SELECT COUNT(*) AS total_proyectos FROM proyectos WHERE curso_id = $idCurso";
$resultadoContarProyectos = mysqli_query($conn, $queryContarProyectos);

// Obtén el número total de proyectos
$totalProyectos = 0;
if ($fila = mysqli_fetch_assoc($resultadoContarProyectos)) {
    $totalProyectos = $fila['total_proyectos'];
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
                    <?php mostrarImg($conn); ?>
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

            <!-- arriba -->
            <div id="arriba">

                <div id="infoApp" class="card">
                    <h2>Subjects</h2>
                    <form method="POST" action="../main/index.php">
                        <button type="submit">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                            </a>
                            <p>Back to dashboard</p>
                        </button>
                    </form>
                </div>

                <div id="infoCurso">
                    <div class="tituloCurso">
                        <?php
                        $selectCurso = 'SELECT * FROM cursos WHERE id = ' . $idCurso;
                        $r = mysqli_query($conn, $selectCurso);

                        if (mysqli_num_rows($r) > 0) {
                            while ($fila = mysqli_fetch_assoc($r)) {
                                echo "<h1>" . $fila['nombre'] . "</h1>";
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
                                <p><?php echo $totalProyectos; ?></p>
                            </div>
                        </div>

                        <div class="cardInfo">
                            <h3>Students</h3>
                            <div class="numProjects">
                                <img src="../../imagenes/students.png">
                                <?php
                                $selectCurso = 'SELECT * FROM proyectos WHERE curso_id = ' . $idCurso;
                                $r = mysqli_query($conn, $selectCurso);
                                $count = mysqli_num_rows($r);  
                                echo "<p>" . $count . "</p>";
                                ?>
            
                            </div>
                        </div>
                        <div class="cardInfo">
                            <h3>Average Score</h3>
                            <div class="numProjects">
                                <div class="redondaStado"></div>
                                <?php
                                    if (!empty($_SESSION['idProyectoSeleccionado'])) {
                                        $idProyectoSeleccionado = $_SESSION['idProyectoSeleccionado'];
                                        mostrarMediaProyectos($conn, $idProyectoSeleccionado);
                                    } else {
                                        echo '<p>-</p>';
                                    }
                                    ?>
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

                                if (mysqli_num_rows($r) > 0) {
                                    while ($fila = mysqli_fetch_assoc($r)) {
                                        $style = '';
                                        if (isset($_SESSION['idProyectoSeleccionado']) && $_SESSION['idProyectoSeleccionado'] == $fila['id']) {
                                            $style = "style='background-color: #fafafa40; border: 0px; color: #ffffff; font-weight: 300;'";
                                        }

                                        echo "<form method='POST' action=''>
                                                    <input type='hidden' name='idProyecto' value='" . $fila['id'] . "'>
                                                    <button type='submit' class='project-button' $style>
                                                        <p>" . htmlspecialchars($fila['titulo']) . "</p>
                                                    </button>
                                                </form>";
                                    }
                                } else {
                                    echo "<p>No hay proyectos disponibles.</p>";
                                }
                                ?>
                            </div>
                        </div>
                        <div id="botonesProjects">
                            <?php
                            if (isset($_SESSION['idProyectoSeleccionado'])) {
                                $idProyecto = $_SESSION['idProyectoSeleccionado'];
                                echo "<form method='POST' action='../projects/project.php'>
                                            <input type='hidden' name='idProyecto' value='" . $idProyecto . "'>
                                            <button class='openProject'>Open</button>
                                        </form>";
                            }
                            ?>
                            <div class="displayRow">
                                <form method="POST" action="">
                                    <button type="submit" class="addProject" name="addProject" value="true">+Add</button>
                                    <button type="submit" class="deleteProject" name="deleteProject" value="delete">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!--Abajo Left-->

                <div id="estadisticaAlumnos" class="card">
                    <?php if (!$mostrarFormulario): ?>
                        <h1>Students Scores</h1>
                        <div id="grafica">
                            <table>
                                <thead>
                                    <tr>
                                        <th id="borderLeft">Name</th>
                                        <th id="borderRight">Project Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($_SESSION['idProyectoSeleccionado'])) {
                                        echo '<td colspan="2">Selecciona un proyecto</td>';
                                    } else {
                                        $idProyectoSeleccionado = $_SESSION['idProyectoSeleccionado'];
                                        mostrarTablaAlumnos($conn, $idProyectoSeleccionado);
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    <?php else: ?>
                        <h1>Add a New Project</h1>
                        <div id="formularioProyecto">
                            <form method="POST" action="">
                                <div class="inputsForm">
                                    <label for="tituloProyecto">Título del Proyecto:</label>
                                    <input type="text" id="tituloProyecto" name="tituloProyecto">
                                </div>

                                <div class="inputsForm">
                                    <label for="descripcionProyecto">Descripción:</label>
                                    <textarea id="descripcionProyecto" name="descripcionProyecto"></textarea>
                                </div>

                                <div class="botonesFormulario">
                                    <form method="POST" action="">
                                        <button type="submit" name="safeAddProject" value="true" class="guardarProyecto">Crear Proyecto</button>
                                        <button type="submit" name="cancelAddProject" value="true" class="cancelarProyecto">Cancelar</button>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div><!--Abajo-->

        </div><!--Contenido-->
    </div><!--Container-->

    <?php mysqli_close($conn); ?>

    <script src="cursos.js"></script>
</body>

</html>