<?php

    function mostrarImg($conn){
        $idProfe = $_SESSION['idProfe'];

        $queryName = 'SELECT img, tipus FROM profesores WHERE id = ' . $idProfe;

        $r = mysqli_query($conn, $queryName);

        // Asegúrate de que haya resultados
        if ($r && mysqli_num_rows($r) > 0) {
            $fila = mysqli_fetch_assoc($r);

            // Mostrar la imagen a través de un archivo PHP
            echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['img']) . "' >";
        }
    }
    
    function updateAlumno($conn) {
        $alumno_id = intval($_POST['alumno_id']);
        $usernameA = $_POST["usernameM"];
        $nombreA = $_POST["nombreM"];
        $apellidoA = $_POST["apellidoM"];
        $contrasenyaA = $_POST["contrasenyaM"];
    
        $update = "UPDATE alumnos SET username = '$usernameA', pass = '$contrasenyaA', name = '$nombreA', last_name = '$apellidoA' WHERE id = '$alumno_id'";
        mysqli_query($conn, $update);
    }

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

        $delete1 = "DELETE FROM alumnos WHERE id = $alumno_id";
        $delete2 = "DELETE FROM scroes WHERE student_id = $alumno_id";

        mysqli_query($conn, $delete2);
        mysqli_query($conn, $delete1);
        
    }
?>