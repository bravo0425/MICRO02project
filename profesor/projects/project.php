<?php
include "../../conexion.php";
include "functions.php";
session_start();


if (isset($_SESSION['nombreUser'])) {
    $usuarioLog = $_SESSION['nombreUser'];
    $nom = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
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


if (isset($_POST['idProyecto']) && !empty($_POST['idProyecto'])) {
    $_SESSION['idProyecto'] = intval($_POST['idProyecto']);
}

if (isset($_SESSION['idProyecto'])) {
    $idProject = $_SESSION['idProyecto'];

    // Consulta para obtener los detalles del proyecto
    $queryProjects = "SELECT * FROM proyectos WHERE id = $idProject";
    $result = mysqli_query($conn, $queryProjects);

    if (mysqli_num_rows($result) > 0) {
        $project = mysqli_fetch_assoc($result);
        $titulo = $project['titulo'];
        $descripcion = $project['descripcion'];
    } else {
        $titulo = "Proyecto no encontrado";
        $descripcion = "No hay detalles disponibles para este proyecto.";
    }

    // Consulta para obtener las actividades relacionadas con el proyecto
    $queryActividades = "SELECT * FROM actividades WHERE project_id = $idProject";
    $resultActividades = mysqli_query($conn, $queryActividades);

    $actividades = [];
    if (mysqli_num_rows($resultActividades) > 0) {
        while ($actividad = mysqli_fetch_assoc($resultActividades)) {
            $actividades[] = $actividad;
        }
    }
} else {
    // Si no hay ID de proyecto en la sesión, mostrar un mensaje de error
    $titulo = "Error";
    $descripcion = "No se seleccionó un proyecto.";
    $actividades = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['editar'])) {
    editarProyecto($conn);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['anadir'])) {
    crearActividad($conn);
}

if (isset($_POST['cancelarAdd'])) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (!empty($_POST['seeActivity'])) {
    $activityId = intval($_POST['seeActivity']);
    $_SESSION['idActividad'] = $activityId;
    header('Location: ../activities/activity.php');
    exit();
}

if (!empty($_POST['deleteActivity'])) {
    eliminarActividad($conn, $_POST['deleteActivity']);
}

if (!empty($_POST['editarActividad']) && !empty($_POST['editActivityId'])) {
    echo 'asasas';
    editarActividad($conn, intval($_POST['editActivityId']));
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="project.css">
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
                                <h2>Courses</h2>
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

            <div id="arriba">

                <div id="infoApp" class="card">
                    <h2>Projects</h2>
                    <form method="POST" action="../cursos/cursos.php">
                        <button type="submit">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                            </a>
                            <p>Back to courses</p>
                        </button>
                    </form>
                </div>

                <div id="description" class="card">
                    <div class="description-action">
                        <h4>Project</h4>
                        <button class="editProject" onclick="abrirEditorProject()">
                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' width='20' height='20' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                <path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
                            </svg>
                        </button>
                    </div>
                    <h1><?php echo htmlspecialchars($titulo); ?></h1>
                    <div id="text">
                        <p><?php echo htmlspecialchars($descripcion); ?></p>
                    </div>
                </div>

            </div>


            <div id="abajo" class="card">
                <div id="verTabla">
                    <?php
                    if (!empty($_POST['editActivity'])) {
                        $activityId = intval($_POST['editActivity']);
                        $query = "SELECT * FROM actividades WHERE id = $activityId";
                        $result = mysqli_query($conn, $query);

                        if ($activity = mysqli_fetch_assoc($result)) {
                            $_SESSION['edit_activity'] = $activity;
                    ?>
                            <div id='editarActivity'>
                                <h2 class='tituloForms'>Edit Activity</h2>
                                <form action='' method='POST' id='formEditarActivity' class='forms'>
                                    <input type="hidden" name="editActivityId" value="<?php echo $_SESSION['edit_activity']['id']; ?>">
                                    <div class='column'>
                                        <label for='editActivityTitle'>Title</label>
                                        <input type="text" name="editActivityTitle" id="editActivityTitle" value="<?php echo htmlspecialchars($_SESSION['edit_activity']['titulo']); ?>">
                                    </div>
                                    <div class='column'>
                                        <label for='editActivityDesc'>Description</label>
                                        <textarea name='editActivityDesc' id='editActivityDesc'> <?php echo htmlspecialchars($_SESSION['edit_activity']['descripcion']) ?> </textarea>
                                    </div>
                                    <div class='column'>
                                        <label for='editActivityDueDate'>Due_date</label>
                                        <input type='date' name='editActivityDueDate' id='editActivityDueDate' value='<?php echo htmlspecialchars($_SESSION['edit_activity']['due_date']) ?>'>
                                    </div>
                                    <div class='column'>
                                        <label for='editActivityStatus'>Status</label>
                                        <select name='editActivityStatus' id='editActivityStatus'>
                                            <option value='1' <?php echo (isset($_SESSION['edit_activity']) && $_SESSION['edit_activity']['active'] == 1 ? ' selected' : '') ?>>Activa</option>
                                            <option value='0' <?php echo (isset($_SESSION['edit_activity']) && $_SESSION['edit_activity']['active'] == 0 ? ' selected' : '') ?>>Inactiva</option>
                                        </select>
                                    </div>
                                    <div class='buttonsEditar'>
                                        <input type='submit' class='agre' name='editarActividad' value='Accept'>
                                        <input type='submit' class='dele' name='cancelar' value='Cancel'>
                                    </div>
                                </form>
                            </div>
                        <?php }
                    } else {
                        ?>
                        <div id="tabla">
                            <table>
                                <thead>
                                    <tr>
                                        <th id="borderLeft">Activities</th>
                                        <th>Due_Date</th>
                                        <th>Status</th>
                                        <th id="borderRight">Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($actividades)) {
                                        foreach ($actividades as $actividad) {
                                            $_SESSION['idActividad'] = $actividad['id'];
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($actividad['titulo']) . "</td>";
                                            echo "<td>" . htmlspecialchars($actividad['due_date']) . "</td>";
                                            echo "<td>" . $actividad['active'] = (intval($actividad['active']) == 1) ? 'Active' : 'Inactive' . "</td>";
                                            echo "<td>
                                                <form method='POST' action=''>
                                                    <button type='sumbit' name='seeActivity' value='" . $actividad['id'] . "'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' width='20' height='20' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                                            <path stroke-linecap='round' stroke-linejoin='round' d='M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z' />
                                                            <path stroke-linecap='round' stroke-linejoin='round' d='M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' />
                                                        </svg>
                                                    </button>
                                                    <button type='submit' name='editActivity' class='edit-activity-btn' value='" . $actividad['id'] . "'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' width='20' height='20' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                                            <path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
                                                        </svg>
                                                    </button>
                                                    <button type='sumbit' name='deleteActivity' value='" . $actividad['id'] . "'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' width='20' height='20' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                                            <path stroke-linecap='round' stroke-linejoin='round' d='m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0' />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>";

                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No activities were found for this project.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="buttonsTabla">
                            <button class="addCard" onclick="addActivity()">+ Add new Activity</button>
                        </div>
                    <?php } ?>
                </div>

                <div id="insertarActividad">
                    <h2 class="tituloForms">Create new Activity</h2>
                    <form action="" method="POST" id="formInsert" class="forms">
                        <div class="column">
                            <label for="tituloActNew">Title</label>
                            <input type="text" name="tituloActNew" id="">
                        </div>
                        <div class="column">
                            <label for="descriptionActNew">Description</label>
                            <textarea type="text" name="descriptionActNew" id=""></textarea>
                        </div>
                        <div class="column">
                            <label for="dueDateActNew">Due_date</label>
                            <input type="date" name="dueDateActNew" id="">
                        </div>
                        <div class="column">
                            <label for="estadoActNew">Status</label>
                            <select name="estadoActNew" id="">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="buttonsInsert">
                            <input type="submit" class="agre" name="anadir" value="Accept">
                            <input type="submit" class="dele" name="cancelarAdd" value="Cancel">
                        </div>
                    </form>
                </div>


                <div id="editarProyecto">
                    <h2 class="tituloForms">Edit Project</h2>
                    <form action="" method="POST" id="formEditarProyect" class="forms">
                        <div class="column">
                            <label for="editTitle">Title</label>
                            <input type="text" name="editTitle" id="editTitle" value="<?php echo htmlspecialchars($titulo); ?>">
                        </div>
                        <div class="column">
                            <label for="editDesc">Description</label>
                            <textarea type="text" name="editDesc" id="editDesc"><?php echo htmlspecialchars($descripcion); ?></textarea>
                        </div>
                        <div class="buttonsEditar">
                            <input type="submit" class="agre" name="editar" value="Accept">
                            <input type="submit" class="dele" name="cancelar" value="Cancel">
                        </div>
                    </form>
                </div>


            </div>

        </div>
    </div>

    <?php mysqli_close($conn); ?>
    <script src="project.js"></script>
</body>

</html>