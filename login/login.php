<?php

include "../conexion.php";

session_start();

if (isset($_POST["entrar"])) {
     
    if(!empty($_POST["username"])){
        $nom = $_POST["username"];
    }else{
        $errorUser = "Error: rellena el campo de usuario";
    }

    if(!empty($_POST["password"])){
        $password = $_POST["password"];
    }else{
        $errorPass = "Error: rellena el campo de password";
    }

    if(!empty($nom) && !empty($password)){
        $consulta = "SELECT * FROM alumnos WHERE username = '$nom' AND pass = '$password'";
        $r = mysqli_query($conn, $consulta);

        if(mysqli_num_rows($r) > 0){

            $fila = mysqli_fetch_assoc($r);

            $_SESSION['nombreUser'] = $nom;
            $_SESSION['nombre'] = $fila['name'];
            $_SESSION['apellido'] = $fila['last_name'];

            header('Location: ../alumno/alumno.php');
            exit();
        }else{
            $consultaP = "SELECT * FROM profesores WHERE username = '$nom' AND pass = '$password'";
            $resultado = mysqli_query($conn, $consultaP);

            if (mysqli_num_rows($resultado) > 0) {
                $filaP = mysqli_fetch_assoc($resultado);
                $_SESSION['nombreUser'] = $nom;
                $_SESSION['nombre'] = $filaP['name'];
                $_SESSION['apellido'] = $filaP['last_name'];

                header('location: ../profesor/index.php');
                exit();
            }
        }
    }
} 


mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>TASKIFY®</h1>
        <div class="form">
            <h2>Log In</h2>
            <form action="login.php" method="POST">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>

                <button type="submit" id="bottonEntrar" name="entrar" value="entrar">Join Now</button>
            </form>
        </div>
    </div>
</body>
</html>