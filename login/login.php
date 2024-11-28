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
        $errorPass = "Error: rellena el campo de usuario";
    }

    if(!empty($nom) && !empty($password)){
        $consulta = "SELECT * FROM alumnos WHERE nombreUser = '$nom' AND pass = '$password'";
        $r = mysqli_query($conn, $consulta);

        if(mysqli_num_rows($r) > 0){

            $fila = mysqli_fetch_assoc($r);

            var_dump($fila);

            $_SESSION['nombreUser'] = $nom;
            $_SESSION['nombre'] = $fila['nombre'];
            $_SESSION['apellido'] = $fila['apellido'];

            header('Location: ../profesor/index.php');
            exit();
        }else{
            $errorGlobal = "Error: tu usuario no es valido";
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
        <h1>Taskify</h1>
        <div class="form">
            <h2>Iniciar Sesión</h2>
            <form action="login.php" method="POST">
                <!--Input de User--->
                <input type="text" id="username" name="username" placeholder="Usuario" required>
                <?php echo "<p style='color:red;'>$errorUser</p>";
                    
                ?>
                <!--Input de password--->
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
                <?php 
                        echo "<p style='color: red;'>$errorPass</p>";
                    
                ?>

                <input type="submit" id="bottonEntrar" name="entrar" value="entrar"></input>
            </form>
        </div>
    </div>
</body>
</html>
