<?php

$conexion = mysqli_connect("localhost", "root", "", "micro02");

$sql = "SELECT nombre, apellido FROM alumnos";
$res = mysqli_query($conexion, $sql);
while ($fila = mysqli_fetch_assoc($res)) {
    $nombre = $fila['nombre'];
    $apellido = $fila['apellido'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_D.css">
    <title>Document</title>
</head>
<body>
    <div class="contenedor">
        <nav>
            <div class="nav-izquierda">
                <h2>Taskify</h2>
                <h3><?php echo $nombre . ' ' . $apellido ?></h3>
            </div>
            <div class="nav-derecha">
                <a href="../login/login.html"><img src="../imagenes/logout.png" alt="" width="30px"></a>
            </div>
        </nav>
    </div>
</body>
</html>