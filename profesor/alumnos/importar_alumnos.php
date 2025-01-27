<?php
    include "../../conexion.php";
    
    if (!empty($_POST['importar'])) {
        if (isset($_FILES['csv_file']) && !empty($_FILES['csv_file']['tmp_name'])) {
            $file = $_FILES['csv_file']['tmp_name'];
        
            // Abre el archivo en modo lectura
            if (($open = fopen($file, "r")) !== false) {

        
                // Procesa cada fila del CSV
                while (($data = fgetcsv($open, 1000, ",")) !== false) {
                    $username = mysqli_real_escape_string($conn, $data[0]);
                    $pass = mysqli_real_escape_string($conn, $data[1]);
                    $nombre = mysqli_real_escape_string($conn, $data[2]);
                    $last_name = mysqli_real_escape_string($conn, $data[3]);
                    $curso_id = mysqli_real_escape_string($conn, $data[4]);
        
                    // Inserta los datos en la tabla 'alumnos'
                    $query = "INSERT INTO alumnos (username, pass, name, last_name, curso_id) VALUES ('$username', '$pass', '$nombre', '$last_name', '$curso_id')";
                    if (!mysqli_query($conn, $query)) {
                        echo "Error al insertar fila: " . mysqli_error($conn);
                    }
                }
        
                fclose($open);
                mysqli_close($conn);
                header ('Location: alumnos.php');
            } else {
                mysqli_close($conn);
                 header ('Location: alumnos.php');
            }
        } else {
            header ('Location: alumnos.php');
        }
        mysqli_close($conn);
        header ('Location: alumnos.php');

    } else if (!empty($_POST['close_popup'])) {
        header ('Location: alumnos.php');
    } 
?>