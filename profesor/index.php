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
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="nav-izquierda">
            <h2>Taskify</h2>
            <h3><?php echo $nombre . ' ' . $apellido ?></h3>
        </div>
        <div class="derecha">
            <img src="../imagenes/logout.png" alt="" width="30px">
        </div>
    </nav>
</body>
</html>