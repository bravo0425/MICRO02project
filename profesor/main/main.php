<?php
    include "../../conexion.php";
    include "functionsMain.php";

    session_start();

    if(isset($_SESSION['nombreUser'])){
        $usuarioLog = $_SESSION['nombreUser'];
        $nom = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
    }else{
        header('Location: ../../login/login.php');
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link rel="stylesheet" href="main.css">
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
                    <div class="menu">
                        <img src="../../imagenes/dashboard.png" width="27px">
                        <h2>Dashboard</h2>
                    </div>
                    <div class="menu">
                        <img src="../../imagenes/cursos.png" width="27px">
                        <h2>Cursos</h2>
                    </div>
                    <div class="menu active">
                        <img src="../../imagenes/students.png" width="27px">
                        <h2>Students</h2>
                    </div>
                    <div class="menu">
                        <img src="../../imagenes/chat.png" width="27px">
                        <h2>Chat</h2>
                    </div>
                    <div class="menu">
                        <img src="../../imagenes/settings.png" width="27px">
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
            <button class="log-out">
                <img src="../../imagenes/cerrar-sesion.png" width="23px" style="color: #FFFFFF;">
                <h2>Log out</h2>
            </button>
        </div>

        <div class="contenido">
            <div id="left">
                <div id="mobileApp">
                        
                </div>
                <div id="LastProject">

                </div>
            </div>
            <div id="right">
                <div id="lastActivities">
                    
                </div>
                <div id="estadisticaAlumnos">
                    
                </div>
                <div id="calendario">
                    
                </div>
            </div>



        </div>
    </div>
        
</body>
</html>