<?php
    include "../../conexion.php";


    session_start();

    if(isset($_SESSION['nombreUser'])){
        $usuarioLog = $_SESSION['nombreUser'];
        $nom = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
    }else{
        header('Location: ../login/login.php');
        exit();
    }

    if(!empty($_POST["showAlumnos"])){
        header("location: ../showStudents/index.php");
    }

    if(!empty($_POST['closeSesion'])) {
        // Cerrar sesión
        session_unset(); // Elimina todas las variables de sesión
        session_destroy(); // Destruye la sesión
    
        // Redirigir a la página de inicio o login
        header("Location: ../../login/login.php");
        exit();
    }


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor</title>
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
                <form action="" method="POST">
                    <button type="submit" name="closeSesion" style="background: none; border: none;">
                        <img src="../../imagenes/logout.png" alt="" width="30px">
                    </button>
                </form>
            </div>
        </nav>

        <div class="contenedor">
            <h3>Cursos:</h3>
            <div class="cursos">
                <form method="POST">
                    <input type="submit" name="daw" value="DAW">
                    <input type="submit" name="dam" value="DAM">
                    <input type="submit" name="smix" value="SMIX">            
                </form>
            </div>

            <br><hr><br>

            <div class="alumnos">
                <form action="" method="POST">
                    <input type="submit" id="btnAlumnos" name="showAlumnos" value="Alumnos">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
