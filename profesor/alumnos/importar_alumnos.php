<?php
    include "../../conexion.php";
    
    if (!empty($_POST['importar'])) {
        if (!empty($_FILES['csv_file'])) {
            $file = $_FILES['csv_file']['tmp_name'];
        
            // Abre el archivo en modo lectura
            if (($open = fopen($file, "r")) !== false) {

        
                // Procesa cada fila del CSV
                while (($data = fgetcsv($open, 1000, ",")) !== false) {
                    $username = mysqli_real_escape_string($conn, $data[0]);
                    $pass = mysqli_real_escape_string($conn, $data[1]);
                    $nombre = mysqli_real_escape_string($conn, $data[2]);
                    $last_name = mysqli_real_escape_string($conn, $data[3]);
                    $project_id = mysqli_real_escape_string($conn, $data[4]);
                    $curso_id = mysqli_real_escape_string($conn, $data[5]);
        
                    // Inserta los datos en la tabla 'alumnos'
                    $query = "INSERT INTO alumnos (username, pass, name, last_name, project_id, curso_id) VALUES ('$username', '$pass', '$nombre', '$last_name', '$project_id', '$curso_id')";
                    if (!mysqli_query($conn, $query)) {
                        echo "Error al insertar fila: " . mysqli_error($conn);
                    }
                }
        
                fclose($open);
                echo "Importación completada exitosamente.";
                mysqli_close($conn);
                header ('Location: alumnos.php');
            } else {
                echo "Error al abrir el archivo.";
                mysqli_close($conn);
                 header ('Location: alumnos.php');
            }
        } else {
            echo "No se ha enviado ningún archivo.";
            mysqli_close($conn);
            header ('Location: alumnos.php');
        }
        
        // Cierra la conexión
        mysqli_close($conn);
        header ('Location: alumnos.php');

    } else if (!empty($_POST['close_popup'])) {
        header ('Location: alumnos.php');
    } 
?>