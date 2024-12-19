<?php
    function crearAlumno($conn) {
        $usernameA = trim(htmlspecialchars($_POST["username"]));
        $nombreA = trim(htmlspecialchars($_POST["nombre"]));
        $apellidoA = trim(htmlspecialchars($_POST["apellido"]));
        $contrasenyaA = trim(htmlspecialchars($_POST["contrasenya"]));
        $contrasenya2 = trim(htmlspecialchars($_POST["contrasenya2"]));
        $curso = trim(htmlspecialchars($_POST["cursos"]));

        if ($contrasenyaA != $contrasenya2) {
            echo "Las contraseñas no coinciden";
            return;
        } else {
            $insert = "INSERT INTO alumnos (username, pass, name, last_name, curso_id) VALUES ('$usernameA', '$contrasenyaA', '$nombreA', '$apellidoA', '$curso')";
    
            mysqli_query($conn, $insert);
        }
    
    }

    function eliminarAlumno($conn) {
        $alumno_id = intval($_POST["alumno_id"]);

        $delete = "DELETE FROM alumnos WHERE id = $alumno_id";

        mysqli_query($conn, $delete);
    }

    

    function updateAlumno($conn) {
        $alumno_id = intval($_POST['alumno_id']);
        $usernameA = $_POST["username"];
        $nombreA = $_POST["nombre"];
        $apellidoA = $_POST["apellido"];
        $contrasenyaA = $_POST["contrasenya"];
    
        $update = "UPDATE alumnos SET username = '$usernameA', pass = '$contrasenyaA', name = '$nombreA', last_name = '$apellidoA' WHERE id = '$alumno_id'";

        mysqli_query($conn, $update);
    }
?>