<?php
    include "../conexion.php";
    include "funciones.php";

    session_start();

    if(isset($_SESSION['nombreUser'])){
        $usuarioLog = $_SESSION['nombreUser'];
        $nom = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
    }else{
        header('Location: ../login/login.php');
        exit();
    }

    if(!empty($_POST['BCrearAlumno'])) {
        crearAlumno($conn);
    }
    if(!empty($_POST['eliminarAlumnos'])) {
        eliminarAlumno($conn);
    }
    if(!empty($_POST['BModificarAlumno'])) {
        updateAlumno($conn);
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
                    <h1>TASKIFY®</h1>
                    <div class="usuario">
                        <img src="../imagenes/usuario.png" width="23px">
                        <h3><?php echo $nom . ' ' . $apellido ?></h3>
                    </div>
                </div>
                <div class="navbar">
                    <div class="menu">
                        <img src="../imagenes/dashboard.png" width="27px">
                        <h2>Dashboard</h2>
                    </div>
                    <div class="menu">
                        <img src="../imagenes/cursos.png" width="27px">
                        <h2>Cursos</h2>
                    </div>
                    <div class="menu active">
                        <img src="../imagenes/students.png" width="27px">
                        <h2>Students</h2>
                    </div>
                    <div class="menu">
                        <img src="../imagenes/chat.png" width="27px">
                        <h2>Chat</h2>
                    </div>
                    <div class="menu">
                        <img src="../imagenes/settings.png" width="27px">
                        <h2>Settings</h2>
                    </div>
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
            <div class="log-out">
                <img src="../imagenes/cerrar-sesion.png" width="23px" style="color: #FFFFFF;">
                <h2>Log out</h2>
            </div>
        </div>

        <div class="contenido">
            <div class="div-arriba-derecha">
                <div class="students">
                    <h2>Students</h2>
                    <img src="../imagenes/students-negro.png" width="27px">
                </div>
                <div class="importar-estudiantes">
                    <h2>+ Import Students CSV</h2>
                </div>
            </div>
            <div class="tabla">
                <form method="POST" action="" id="listaAlumnos">
                    <table border="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Nombre de Usuario</th>
                                <th>Fecha de Creación</th>
                                <th>Fecha de Modificación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($resultado) > 0) {
                                while ($fila = mysqli_fetch_assoc($resultado)) {
                                    echo "<tr>";
                                    echo "<td><input type='radio' name='alumno_id' value='" . $fila["id"] . "' required></td>";
                                    echo "<td>" . $fila["id"] . "</td>";
                                    echo "<td>" . $fila["name"] . "</td>";
                                    echo "<td>" . $fila["last_name"] . "</td>";
                                    echo "<td>" . $fila["username"] . "</td>";
                                    echo "<td>" . $fila["created_at"] . "</td>";
                                    echo "<td>" . $fila["update_at"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No hay alumnos registrados.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table><br>
                    <div class="botones-alumnos">
                        <button type="submit" value="crearAlumnos"  onclick="mostrarFormularioA()" name="crearAlumnos" id="crearAlumnos">+ Add new Student</button>
                        <button type="submit" value="modificarA" name="modificarA" onclick="modificarAlumno()" id="modificarA">Modify Student</button>
                        <button type="submit" value="eliminarAlumnos" name="eliminarAlumnos" id="eliminarAlumnos">Delete Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>