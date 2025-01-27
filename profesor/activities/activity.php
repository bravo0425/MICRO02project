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

if (isset($_POST['seeActivity']) && !empty($_POST['seeActivity'])) {
    $idActivity = $_SESSION['idActividad'];
}

if (isset($_SESSION['idActividad'])) {
    $idActivity = intval($_SESSION['idActividad']);

    $queryAct = "SELECT * FROM actividades WHERE id = $idActivity";
    $result = mysqli_query($conn, $queryAct);

    if (mysqli_num_rows($result) > 0) {
        $act = mysqli_fetch_assoc($result);
        $titulo = htmlspecialchars($act['titulo']);
        $descripcion = htmlspecialchars($act['descripcion']);
        $dueDate = htmlspecialchars($act['due_date']);
        $estado = (intval($act['active']) == 1) ? "Active" : "Inactive";
    } else {
        $titulo = "Actividad no encontrada";
        $descripcion = "No hay detalles disponibles para esta actividad.";
    }
}


if (isset($_POST['estadoAct']) && !empty($_POST['estadoAct'])) {
    $newEstado = (intval($act['active']) == 1) ? 0 : 1;

    $updateQuery = "UPDATE actividades SET active = $newEstado WHERE id = $idActivity";
    mysqli_query($conn, $updateQuery);

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}



$checkItemsQuery = "SELECT COUNT(*) AS item_count FROM items WHERE activity_id = $idActivity";
$result = mysqli_query($conn, $checkItemsQuery);
$row = mysqli_fetch_assoc($result);
$itemCount = $row['item_count'];


$modoEdicion = isset($_POST['modo']) && $_POST['modo'] === 'editar';

if (isset($_POST['deleteItem'])) {
    eliminarItem($conn, $_POST['deleteItem']);
}

if (isset($_POST['añadirItem'])) {
    añadirItem($conn, $idActivity);
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activities</title>
    <link rel="stylesheet" href="activity.css">
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
                    <h2>Activities</h2>
                    <form method="POST" action="../projects/project.php">
                        <button type="submit">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                            </a>
                            <p>Back to projects</p>
                        </button>
                    </form>
                </div>

                <div id="description" class="card">
                    <div class="description-action">
                        <h4>Activity</h4>

                    </div>
                    <div class="descriptionInfo">
                        <h1><?php echo $titulo; ?></h1>
                        <p><?php echo $descripcion; ?></p>
                        <p>Last date: <span><?php echo $dueDate; ?></span> </p>
                    </div>
                </div>

                <form action="" method="POST" id="estadoActividad" class="card">
                    <p>Status</p>
                    <?php
                    $selectEstado = "SELECT * FROM actividades WHERE id = $idActivity";
                    $resultSelectEstado = mysqli_query($conn, $selectEstado);
                    $row = mysqli_fetch_assoc($resultSelectEstado);
                    if($row['active'] == 1){
                        echo '<input type="submit" class="statusActive" name="estadoAct" value="'.$estado.'" id="">';
                    }else{
                        echo "<input type='submit' class='statusInactive' name='estadoAct' value='$estado' id=''>";
                    }
                    ?>
                </form>
            </div>


            <div id="abajo">
                <?php
                if (!empty($_POST['confirmarCambios'])) {
                    updateItems($conn, $idActivity);
                }
                if ($modoEdicion) {
                ?>
                    <div id="itemsEdit" class="card">
                        <div class="titleItems">
                            <h2>Items</h2>
                        </div>
                        <div id="divItems">
                            <form action="" method="post" class="fromItemsEdit" enctype="multipart/form-data">
                                <?php mostrarItemsEditar($conn, $idActivity); ?>
                                <div class="optionsItemsEdit">
                                    <button type="submit" name="confirmarCambios" value="confirmUpdate" class="confirmButton">Confirmar</button>
                                    <button type="submit" name="cancelChanges" value="cancelChanges" class="cancelButton">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } else { ?>
                    <div id="items" class="card">
                        <div class="buttonsItems">
                            <h2>Items</h2>
                            <div class="butonsItems">
                                <?php if ($itemCount < 5): ?>
                                    <button type="button" name="show_popup" class="addbtn" id="addbtn">+ Add Items</button>
                                <?php endif; ?>
                                <?php if ($itemCount != 0): ?>
                                    <form action="" method="post" class="formEditItems">
                                        <button type="submit" name="modo" value="editar" class="editItems">Edit</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <div id="popUp">
                                <div class="popup-content">
                                    <form action="" method="POST" id="añadirItemF" enctype="multipart/form-data">
                                        <div class="mostrarItems">
                                            <button type="submit" id="close_popup" name="close_popup" class="close-btn" value="close_popup">X</button>
                                        </div>
                                        <div class="contenidoForm">
                                            <div class="formAdd">
                                                <h2>Insert new Item</h2>
                                                <div class="itemColumn">
                                                    <label for="imgIcon">Img Icon:</label>
                                                    <label for="imgIcon" class="selectIcon">select img Icon</label>
                                                    <input type="file" name="imgIcon" id="imgIcon" accept="image/*" class="none">
                                                </div>

                                                <div class="itemColumn">
                                                    <label for="tituloNewItem">Title:</label>
                                                    <input type="text" name="tituloNewItem" id="tituloNewItem">
                                                </div>

                                                <div class="itemColumn">
                                                    <label for="valorNewItem">Value:</label>
                                                    <select name="valorNewItem" id="valorNewItem">
                                                        <option value="10">10%</option>
                                                        <option value="20">20%</option>
                                                        <option value="30">30%</option>
                                                        <option value="40">40%</option>
                                                        <option value="50">50%</option>
                                                        <option value="60">60%</option>
                                                        <option value="70">70%</option>
                                                        <option value="80">80%</option>
                                                        <option value="90">90%</option>
                                                        <option value="100">100%</option>
                                                    </select>
                                                </div>
                                                <button type="submit" id="añadirItem" name="añadirItem" value="añadirItem">Insert New Item</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <button class="vacio"></button>
                        </div>
                        <div id="itemsGroup">
                            <?php mostrarItems($conn, $idActivity); ?>
                        </div>
                    </div>

                    <form method="POST" action="../evaluar/lista/lista.php">
                        <button type="submit" id="evaluarAlumnos">
                            <p>Evaluate your students</p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </form>

                    <div id="tablaNotas" class="card">
                        <h2>Students Scores</h2>
                        <div class="tbln">
                            <table>
                                <?php
                                    echo generarTablaAlumnosNotas($conn, $idActivity);
                                ?>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>

    <script src="activity.js"></script>
</body>

</html>