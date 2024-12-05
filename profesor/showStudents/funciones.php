<?php

function insertarAlumnos($conn) {
        $usernameA = $_POST["username"];
        $nombreA = $_POST["nombre"];
        $apellidoA = $_POST["apellido"];
        $contrasenyaA = $_POST["contrasenya"];

        if(!empty($_POST["usernameA"]) && !empty($_POST["nombreA"]) && !empty($_POST["apellidoA"]) && !empty($_POST["contrasenyaA"])){
            $insert = "INSERT INTO alumnos (username, pass, name, last_name) VALUES ('$usernameA', '$contrasenyaA', '$nombreA', '$apellidoA')";
                echo "el insert: " .$insert. "<br>";
        }
        
        mysqli_query($conn, $insert);

}


function mostrarAlumnos($conn){
    $query = "SELECT * FROM alumnos";
    $resultado = mysqli_query($conn, $query);

    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td><input type='radio' name='alumno_id' value='" . $fila["id"] . "' required></td>";
            echo "<td>" . $fila["id"] . "</td>";
            echo "<td>" . $fila["name"] . "</td>";
            echo "<td>" . $fila["last_name"] . "</td>";
            echo "<td>" . $fila["username"] . "</td>";
            echo "<td>" . $fila["created_at"] . "</td>";
            echo "<td>" . $fila["update_at"] . "</td>";
            echo "</tr>";
        }
    } else {
            echo "<tr><td colspan='7'>No hay alumnos registrados.</td></tr>";
    }
}

    

?>