<?php
// 1. Conexión básica a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "micro02");

// Verificar si la conexión funciona
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// 2. Verificar que se usó el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $usuario = $_POST['username'];
    $passw = $_POST['password'];

        // Consulta para buscar el usuario en la base de datos
    $consulta = "SELECT * FROM alumnos WHERE nombreUser = '$usuario' and pass = '$passw'";
    $resultado = mysqli_query($conexion, $consulta);

        // Comprobar si se encontró el usuario
    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado); // Obtener los datos del usuario
        header ('location: ../profesor/index.php');
        
    } else {
        echo "El usuario no existe o la contraseña són incorrectos";
    }
} else {
    echo "Por favor, usa el formulario para iniciar sesión.";
}

// Cerrar la conexión
mysqli_close($conexion);
?>
