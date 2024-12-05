<?php

    include "../../conexion.php";
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

    if(!empty($_POST["backToCursos"])){
        header("location: ../main/index.php");
    }

    $query = "SELECT * FROM alumnos";
    $resultado = mysqli_query($conn, $query);

    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <nav>
            <div class="nav-izquierda">
                <h2>Taskify</h2>
                <h3><?php echo $nom . ' ' . $apellido ?></h3>
            </div>
            <div class="nav-derecha">
                <img src="../../imagenes/logout.png" alt="" width="30px">
            </div>
        </nav>
        <div class="mostrar-alumnos">
            <table>
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
                    <?php mostrarAlumnos($conn); ?>
                </tbody>
            </table>
            <br>

            <form method="POST">
                <input type="submit" id="btnCursos" name="backToCursos" value="Volver a Cursos">
                <input type="submit" name="createAlumnos" value="Crear Alumno">
                <input type="submit" name="editAlumnos" value="Editar Alumno">
                <input type="submit" name="delateAlumnos" value="Eliminar Alumno">
            </form>

        </div>
    </div>

    <script>
        function listaAlumnos() {
            document.querySelector(".contenedor").style = "display: none;";
            document.querySelector(".mostrar-alumnos").style = "display: grid;";
        }

        function mostrarFormularioA() {
            document.querySelector(".mostrar-alumnos").style = "display: none;";
            document.querySelector(".crearAlumnos").style = "display: flex;";
        }
    </script>
</body>
</html>