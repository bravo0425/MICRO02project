<?php
    function updateAlumno($conn) {
        $alumno_id = intval($_POST['alumno_id']);
        $usernameA = $_POST["username"];
        $nombreA = $_POST["nombre"];
        $apellidoA = $_POST["apellido"];
        $contrasenyaA = $_POST["contrasenya"];
    
        $update = "UPDATE alumnos SET username = '$usernameA', pass = '$contrasenyaA', name = '$nombreA', last_name = '$apellidoA' WHERE id = '$alumno_id'";

        mysqli_query($conn, $update);
    }

    function crearAlumno($conn) {
        $usernameA = $_POST["username"];
        $nombreA = $_POST["nombre"];
        $apellidoA = $_POST["apellido"];
        $contrasenyaA = $_POST["contrasenya"];
    
        $insert = "INSERT INTO alumnos (username, pass, name, last_name) VALUES ('$usernameA', '$contrasenyaA', '$nombreA', '$apellidoA')";

        mysqli_query($conn, $insert);
    }

    function eliminarAlumno($conn) {
        $alumno_id = intval($_POST["alumno_id"]);

        $delete = "DELETE FROM alumnos WHERE id = $alumno_id";

        mysqli_query($conn, $delete);
    }
?>