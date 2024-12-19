<?php
    include "../../conexion.php";
    include "funciones.php";

    session_start();

    if(isset($_SESSION['nombreUser'])){
        $usuarioLog = $_SESSION['nombreUser'];
        $nom = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
    }else{
        header('Location: ../../login/login.php');
        exit();
    }

    if(!empty($_POST['insertarAlumno'])) {
        crearAlumno($conn);
    }
    if(!empty($_POST['eliminarAlumnos'])) {
        eliminarAlumno($conn);
    }
    if(!empty($_POST['BModificarAlumno'])) {
        updateAlumno($conn);
    }

    if (!empty($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: ../../login/login.php');
        exit();
    }

    /*
    */
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
                    <button onclick="goCursos()" class="menu">
                        <img src="../../imagenes/cursos.png" width="27px">
                        <h2>Cursos</h2>
                    </button>
                    <button onclick="goStudents()" class="menu active">
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

        <div class="contenido">
            <div class="div-arriba-derecha">
                <div class="students">
                    <h2>Students</h2>
                    <img src="../../imagenes/students-negro.png" width="27px">
                </div>
                <div class="importar-estudiantes">
                    <input type="file"  value="+ Import Students CSV">
                </div>
                
                
            </div>
            <div class="tabla">
                <form method="POST" action="" id="listaAlumnos">
                    <div class="tablaMostrarStudents">
                        <table border="0" id="tableee">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Nombre de Usuario</th>
                                    <th>Fecha de Creación</th>
                                    <th>Id Curso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($resultado) > 0) {
                                    while ($fila = mysqli_fetch_assoc($resultado)) {
                                        echo "<tr>";
                                        echo "<td><input type='radio' name='alumno_id' value='" . $fila["id"] . "'></td>";
                                        echo "<td>" . $fila["id"] . "</td>";
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
                        <button type="button" value="crearAlumnos"  onclick="mostrarFormularioA()" name="crearAlumnos" id="crearAlumnos">+ Add new Student</button>
                        <button type="submit" value="modificarA" name="modificarA" onclick="modificarAlumno()" id="modificarA">Modify Student</button>
                        <button type="submit" value="eliminarAlumnos" name="eliminarAlumnos" id="eliminarAlumnos">Delete Student</button>
                    </div>
                </form>
                <form action="" method="post" id="crearAlumno" hidden>
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
                    <div class="column">
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
                        <button type="button" onclick="mostrarTabla()" id="back">Back</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="alumnos.js?version=<?php echo time(); ?>"></script>
</body>
</html>