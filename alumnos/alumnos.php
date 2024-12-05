<?php
    include "../conexion.php";

    session_start();

    if(isset($_SESSION['nombreUser'])){
        $usuarioLog = $_SESSION['nombreUser'];
        $nom = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
    }else{
        header('Location: ../login/login.php');
        exit();
    }


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor</title>
    <link rel="stylesheet" href="alumnos.css">
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
        </div>
    </div>

    
</body>
</html>
