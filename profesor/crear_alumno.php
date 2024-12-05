<?php

include "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST")  {
        $usernameA = $_POST["username"];
        $nombreA = $_POST["nombre"];
        $apellidoA = $_POST["apellido"];
        $contrasenyaA = $_POST["contrasenya"];

        $insert = "INSERT INTO alumnos (username, pass, name, last_name) VALUES ('$usernameA', '$contrasenyaA', '$nombreA', '$apellidoA')";
        echo "el insert: " .$insert. "<br>";

        if (mysqli_query($conn, $insert)) {
            echo "insert hecho correctamente";
        } else {
            echo "error insertando el alumno";
        }

    }

?>