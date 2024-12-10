<?php
    include "../conexion.php";

    if ((!empty($_POST['modificarA']) && isset($_POST['alumno_id']))) {
        $alumno_id = intval($_POST['alumno_id']);
        $usernameA = $_POST["username"];
        $nombreA = $_POST["nombre"];
        $apellidoA = $_POST["apellido"];
        $contrasenyaA = $_POST["contrasenya"];

        $update = "UPDATE alumnos SET username = '$usernameA', pass = '$contrasenyaA', name = '$nombreA', last_name = '$apellidoA' WHERE id = '$alumno_id'";

        $r = mysqli_query($conn, $update);
        if ($r) {
            header('location: index.php');
        }if (!$r) {
            die("Error al ejecutar la consulta: " . mysqli_error($conn));
        }
    } if (($_SERVER["REQUEST_METHOD"] === "POST") && (!empty($_POST['BcrearAlumno']))) {
        $usernameA = $_POST["username"];
        $nombreA = $_POST["nombre"];
        $apellidoA = $_POST["apellido"];
        $contrasenyaA = $_POST["contrasenya"];

        $insert = "INSERT INTO alumnos (username, pass, name, last_name) VALUES ('$usernameA', '$contrasenyaA', '$nombreA', '$apellidoA')";

        $resultado = mysqli_query($conn, $insert);
        if ($resultado) {
            header('location: index.php'); 
        }if (!$resultado) {
            die("Error al ejecutar la consulta: " . mysqli_error($conn));
        }
    }
?> 