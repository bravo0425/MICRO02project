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

    $queryItems = "SELECT * FROM items WHERE activity_id = $idActivity";
    $resultItems = mysqli_query($conn, $queryItems);

    $itemsAct = [];
    if (mysqli_num_rows($resultItems) > 0) {
        while ($item = mysqli_fetch_assoc($resultItems)) {
            $itemsAct[] = $item;
        }
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


$modoEdicion = isset($_POST['modo']) && $_POST['modo'] === 'editar'; // Determina si estás en modo edición
$nuevoItem = isset($_POST['añadirItem']); // Determina si se está añadiendo un ítem nuevo


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
                            <p>back to projects</p>
                        </button>
                    </form>
                </div>

                <div id="description" class="card">
                    <div class="description-action">
                        <h4>Activity</h4>
                        <button class="editProject" onclick="abrirEditorProject()">
                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' width='20' height='20' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                <path stroke-linecap='round' stroke-linejoin='round' d='m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10' />
                            </svg>
                        </button>
                    </div>
                    <div class="descriptionInfo">
                        <h1><?php echo $titulo; ?></h1>
                        <p><?php echo $descripcion; ?></p>
                        <p>Last date: <span><?php echo $dueDate; ?></span> </p>
                    </div>
                </div>

                <form action="" method="POST" id="estadoActividad" class="card">
                    <p>Estado</p>
                    <input type="submit" class="statusAct" name="estadoAct" value="<?php echo $estado; ?>" id="">
                </form>
            </div>


            <div id="abajo">

                <div id="items" class="card">
                    <div class="buttonsItems">
                        <h2>Items</h2>
                        <?php if ($itemCount < 5): ?> 
                        <button type="button" name="show_popup" class="addbtn" id="addbtn">+ Add Items</button>
                        
                        <?php endif; ?>
                        
                        <div id="popUp">
                            <div class="popup-content">
                                <form action="" method="POST" id="añadirItemF" enctype="multipart/form-data">
                                    <div class="mostrarItems">
                                        <button type="submit" id="close_popup" name="close_popup" class="close-btn" value="close_popup">X</button>
                                    </div>  
                                    <?php if ($itemCount < 5): ?> 
                                        <div class="contenidoForm">
                                            <div class="formAdd">
                                                <h2>Insert new Item</h2>
                                                <div class="itemColumn">
                                                    <label for="imgIcon">Img Icon:</label>
                                                    <label for="imgIcon" class="selectIcon">select img Icon</label>
                                                    <input type="file" name="imgIcon" id="imgIcon" accept="image/*">
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
                                    <?php endif; ?>
                                </form>

                            </div>
                        </div>

                        <button class="deletebtn"></button>
                    </div>
                    <div id="itemsGroup">
                        <form action="" method="post" class="fromItemsEdit">
                            <div class="ItemsEdit">
                                <?php mostrarItems($conn, $idActivity); ?>
                            </div>
                            
                            <button type="submit" name="confirmarCambios" value="confirmUpdate" class="confirm">Confirmar</button>
                        </form>
                        <div class="itemsBD">
                            <?php 
                                mostrarItemsBD($conn, $idActivity);
                            ?>
                        </div>        
                    </div>

                </div>

                <form method="POST" action="../evaluar/lista/lista.php">
                    <button type="submit" id="evaluarAlumnos">
                        <p>Evalua a tus alumnos -></p>
                    </button>
                </form>

                <!--<div id="tablaNotas" class="card">
                    <h2>Notas alumnos</h2>
                    <div class="tbln">
                        <table>
                            <?php
                            if (!empty($itemsAct)) {
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th id='borderLeft'>Nom</th>"; // Encabezado para nombres de alumnos
                                foreach ($itemsAct as $item) {
                                    echo "<th>" . htmlspecialchars($item['titulo']) . "</th>"; // Mostrar nombres reales de los items
                                }
                                echo "<th id='borderRight'>Nota final</th>"; // Encabezado para nota final
                                echo "</tr>";
                                echo "</thead>";

                                // Consulta para obtener datos de alumnos e items
                                $queryAlumnos = " SELECT alumnos.id AS alumno_id, alumnos.name AS alumno_name, alumnos_items.notaItem, alumnos_items.id_item, items.valor AS item_valor FROM alumnos_items INNER JOIN alumnos ON alumnos_items.id_alumno = alumnos.id INNER JOIN items ON alumnos_items.id_item = items.id WHERE items.activity_id = $idActivity ";

                                $resultItems = mysqli_query($conn, $queryAlumnos);

                                // Crear un array para almacenar los datos por alumno
                                $alumnosData = [];
                                while ($fila = mysqli_fetch_assoc($resultItems)) {
                                    $alumnoId = $fila['alumno_id'];
                                    if (!isset($alumnosData[$alumnoId])) {
                                        $alumnosData[$alumnoId] = [
                                            'name' => $fila['alumno_name'],
                                            'items' => array_fill(0, count($itemsAct), ['nota' => '-', 'valor' => 0]) // Inicializar notas con guiones
                                        ];
                                    }
                                    // Mapear nota del item y su valor a la columna correcta
                                    foreach ($itemsAct as $index => $item) {
                                        if ($item['id'] == $fila['id_item']) {
                                            $alumnosData[$alumnoId]['items'][$index] = [
                                                'nota' => $fila['notaItem'],
                                                'valor' => $fila['item_valor']
                                            ];
                                        }
                                    }
                                }

                                // Mostrar el cuerpo de la tabla
                                echo "<tbody>";
                                foreach ($alumnosData as $alumno) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($alumno['name']) . "</td>";

                                    $notaFinal = 0;
                                    $totalValor = 0;

                                    foreach ($alumno['items'] as $item) {
                                        echo "<td>" . htmlspecialchars($item['nota']) . "</td>";
                                        if ($item['nota'] !== '-') {
                                            $notaFinal += floatval($item['nota']) * ($item['valor'] / 100); // Calcular el aporte de cada item
                                            $totalValor += $item['valor']; // Sumar el valor total ponderado
                                        }
                                    }

                                    // Normalizar la nota final al 100% si los valores no suman 100
                                    $notaFinal = ($totalValor > 0) ? $notaFinal * (100 / $totalValor) : 0;

                                    // Mostrar la nota final con 2 decimales
                                    echo "<td>" . number_format($notaFinal, 2) . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            } else {
                                echo "<p>No hay items en la actividad</p>";
                            }
                            ?>
                        </table>

                    </div>
                </div>-->

            </div>

        </div>
    </div>

    <script src="activity.js"></script>
</body>

</html>
