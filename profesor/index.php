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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor</title>
    <link rel="stylesheet" href="profesor.css">
</head>
<body>
    <div class="container">
        <nav>
            <div class="nav-izquierda">
                <h2>Taskify</h2>
                <h3><?php echo $nom . ' ' . $apellido ?></h3>
            </div>
            <div class="nav-derecha">
                <img src="../imagenes/logout.png" alt="" width="30px">
            </div>
        </nav>
        <div class="contenedor">
            <h3>Cursos:</h3>
            <form method="POST" class="materias">
                <a href="diseno.php"><button type="button" name="diseño">Diseño</button></a>
                <button type="button">Programación</button>
                <button type="button">Proyecto</button>
                <button type="button">Proyecto</button>
            </form>
            <br><hr><br>
            <form method="POST" class="alumnos">
                <button type="button" name="bAlumnos" onclick="listaAlumnos()">Alumnos</button>
            </form>
        </div>
        <div class="contenedor-alumnos" style="display: none;">
            <form method="POST" action="" id="listaAlumnos">
                <table border="1">
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
                <div class="botones">
                    <button type="submit" value="eliminarAlumnos" name="eliminarAlumnos">Eliminar Alumno</button>
                    <button type="submit" value="crearAlumnos"  onclick="mostrarFormularioA()" name="crearAlumnos">Crear Alumno</button>
                    <button type="submit" value="modificarA" name="modificarA" onclick="modificarAlumno()">Modificar Alumno</button>
                </div>
            </form>
        </div>
        <div class="crearAlumnos" style="display: none;">
            <form action="" method="POST">
                <h2>Añadir nuevo alumno</h2>
                <label for="username">Nombre Usuario Alumno:</label>
                <input type="text" name="username" id="username">
                <label for="nombre">Nombre Alumno:</label>
                <input type="text" name="nombre" id="nombre">
                <label for="apellido">Apellido Alumno:</label>
                <input type="text" name="apellido" id="apellido">
                <label for="nombre">Contraseña Alumno:</label>
                <input type="text" name="contrasenya" id="contrasenya">
                <button type="submit" name="BCrearAlumno" value="BCrearAlumno">Enviar</button>
                <button type="submit" id="BModificarAlumno" name="BModificarAlumno" value="BModificarAlumno" style="display: none;">Enviar</button>
            </form>
        </div>
    </div>

    <script>
        function listaAlumnos() {
            document.querySelector(".contenedor").style = "display: none;";
            document.querySelector(".contenedor-alumnos").style = "display: grid;";
        }

        function mostrarFormularioA() {
            document.querySelector(".contenedor-alumnos").style = "display: none;";
            document.querySelector(".crearAlumnos").style = "display: flex;";
        }

        function modificarAlumno() {
            document.querySelector(".crearAlumnos").style = "display: flex;";

            document.querySelector(".crearAlumnos h2").innerHTML = "Modificar Alumno";

            document.querySelector(".crearAlumnos #BCrearAlumno").style = "display: none;";

            document.querySelector(".crearAlumnos #BModificarAlumno").style = "display: grid;";
        }
    </script>
</body>
</html>
