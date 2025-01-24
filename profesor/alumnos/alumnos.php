<?php
include "../../conexion.php";
include "funciones.php";

session_start();

if (isset($_SESSION['nombreUser'])) {
    $usuarioLog = $_SESSION['nombreUser'];
    $nom = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
} else {
    header('Location: ../../login/login.php');
    exit();
}

if (!empty($_POST['insertarAlumno'])) {
    crearAlumno($conn);
}

if (!empty($_POST['eliminarAlumnos']) && !empty($_POST['radioSeleccionada'])) {
    eliminarAlumno($conn);
}

if (!empty($_POST['BModificarAlumno'])) {
    updateAlumno($conn);
}

if (!empty($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ../../login/login.php');
    exit();
}


$query = "SELECT * FROM alumnos";
$resultado = mysqli_query($conn, $query);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link rel="stylesheet" href="alumnos.css">
</head>

<body>
    <div class="container">
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
                    <button onclick="goStudents()" class="menu active">
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

        <div class="contenido">
            <div class="div-arriba-derecha">
                <div id="infoApp" class="card">
                    <h2>Students 
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </h2>
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
                <form action="" class="importar-estudiantes" method="post">
                    <button type="button" name="show_popup" id="show_popup">+ Import Students CSV</button>
                </form>
                <div id="popup">
                    <div class="popup-content">
                        <form method="POST" action="importar_alumnos.php" enctype="multipart/form-data">
                            <button type="submit" id="close_popup" name="close_popup" class="close-btn" value="close_popup">X</button>
                            <div class="buttonsPopup">
                                <label for="csv_file">Add you csv</label>
                                <input type="file" name="csv_file" id="csv_file" accept=".csv">
                                <button type="submit" name="importar" value="importar">Importar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tabla">
                <?php
                if (!empty($_POST['modificarA']) && !empty($_POST['radioSeleccionada'])) {
                    if (!empty($_POST['alumno_id'])) {
                        $radioSeleccionada = $_POST['alumno_id'];

                        $nombre = '';
                        $cognom = '';
                        $username = '';
                        $password = '';

                        if ($radioSeleccionada) {
                            $modificarSelect = "SELECT name, last_name, username, pass FROM alumnos WHERE id = " . $radioSeleccionada;
                            $result = mysqli_query($conn, $modificarSelect);

                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    while ($fila = mysqli_fetch_assoc($result)) {
                                        $nombre = $fila['name'];
                                        $cognom = $fila['last_name'];
                                        $username = $fila['username'];
                                        $password = $fila['pass'];
                                    }
                                } else {
                                    echo "No se encontraron datos para el ID seleccionado.";
                                }
                            } else {
                                echo "Error en la consulta: " . mysqli_error($conn);
                            }
                        } else {
                            echo "No se ha seleccionado un radio button.";
                        }
                    } else {
                        echo "<script>alert('Selecciona un alumno para poder modificarlo.');</script>";
                    }

                ?>
                    <form action="" method="post" class="formAlumnos">
                        <h2>Modify student</h2>
                        <div class="column">
                            <input type="hidden" name="alumno_id" value="<?php echo $radioSeleccionada; ?>">
                            <label for="nombreM">Name</label>
                            <input type="text" name="nombreM" id="nombreM" value="<?php echo $nombre; ?>"><br>
                        </div>
                        <div class="column">
                            <label for="apellidoM">Last Name</label>
                            <input type="text" name="apellidoM" id="apellidoM" value="<?php echo $cognom; ?>"><br>
                        </div>
                        <div class="column">
                            <label for="usernameM">Username</label>
                            <input type="text" name="usernameM" id="usernameM" value="<?php echo $username; ?>"><br>
                        </div>
                        <div class="column">
                            <label for="contrasenyaM">Password</label>
                            <input type="password" name="contrasenyaM" id="contrasenyaM" value="<?php echo $password; ?>"><br>
                        </div>
                        <div class="column">
                            <label for="contrasenya2M">Repeat password</label>
                            <input type="password" name="contrasenya2M" id="contrasenya2M" value="<?php echo $password; ?>"><br>
                        </div>
                        <div class="column-se">
                            <label for="Curso">Curso</label>
                            <select name="cursosM" id="cursosM">
                                <?php
                                $select = "SELECT * FROM cursos";
                                $resCurso = mysqli_query($conn, $select);
                                while ($fila = mysqli_fetch_assoc($resCurso)) {
                                    echo "<option required value='" . $fila['id'] . "'>" . $fila['nombre'] . "</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="botones-crearA">
                            <button type="submit" id="BModificarAlumno" name="BModificarAlumno" value="BModificarAlumno">Insert</button>
                            <button type="submit" id='back' name='back' class="back" value='back'>Back</button>
                            <?php
                            if (!empty($_POST['back'])) {
                                header('Location: alumnos.php');
                                exit;
                            }
                            ?>
                        </div>
                    </form>
                <?php
                } else if(!empty($_POST['crearAlumnos'])){
                ?>
                <form action="" method="post" class="formAlumnos">
                    <h2>Insert new student</h2>
                    <div class="column">
                        <label for="nombre">Name</label>
                        <input type="text" name="nombre" id="nombre"><br>
                    </div>
                    <div class="column">
                        <label for="apellido">Last Name</label>
                        <input type="text" name="apellido" id="apellido"><br>
                    </div>
                    <div class="column">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username"><br>
                    </div>
                    <div class="column">
                        <label for="contrasenya">Password</label>
                        <input type="password" name="contrasenya" id="contrasenya"><br>
                    </div>
                    <div class="column">
                        <label for="contrasenya2">Password</label>
                        <input type="password" name="contrasenya2" id="contrasenya2"><br>
                    </div>
                    <div class="column-se">
                        <label for="Curso">Id Curso</label>
                        <select name="cursos" id="cursos">
                            <?php
                            $select = "SELECT * FROM cursos";
                            $resCurso = mysqli_query($conn, $select);
                            while ($fila = mysqli_fetch_assoc($resCurso)) {
                                echo "<option required value='" . $fila['id'] . "'>" . $fila['nombre'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="botones-crearA">
                        <button type="submit" id="insert" name="insertarAlumno" value="insertarAlumno">Insert</button>
                        <button type="submit" name="cancel" value="cancel" class="back">Back</button>
                    </div>
                </form>
                <?php } else{ ?>
                    <form method="POST" action="" id="listaAlumnos">
                        <input type="hidden" id="hiddenField" name="selectedRadio" value="">
                        <div class="tablaMostrarStudents">
                            <table border="0" id="tableee">
                                <thead>
                                    <tr>
                                        <th id="borderLeft"></th>
                                        <th>Name</th>
                                        <th>Last Name</th>
                                        <th>Username</th>
                                        <th>Creation Date</th>
                                        <th id="borderRight">Course ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($resultado) > 0) {
                                        while ($fila = mysqli_fetch_assoc($resultado)) {
                                            echo "<tr>";
                                            echo "<td><input type='radio' name='alumno_id' class='radio' value='" . $fila["id"] . "'></td>";
                                            echo "<td>" . $fila["name"] . "</td>";
                                            echo "<td>" . $fila["last_name"] . "</td>";
                                            echo "<td>" . $fila["username"] . "</td>";
                                            echo "<td>" . $fila["created_at"] . "</td>";
                                            echo "<td>" . $fila["curso_id"] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No hay alumnos registrados.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="botones-alumnos">
                            <button type="submit" value="crearAlumnos" name="crearAlumnos" id="crearAlumnos">+ Add new Student</button>
                            <button type="submit" value="modificar" name="modificarA" id="modificarA">Modify Student</button>
                            <button type="submit" value="eliminarAlumnos" name="eliminarAlumnos" id="eliminarAlumnos">Delete Student</button>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script src="alumnos.js?version=<?php echo time(); ?>"></script>
</body>

</html>