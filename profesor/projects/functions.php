<?php

function crearActividad($conn) {
    $idProject = $_GET['id'];
    $tituloAct = trim(htmlspecialchars($_POST["tituloActNew"]));
    $descAct = trim(htmlspecialchars($_POST["descriptionActNew"]));
    $dueDateAct = trim(htmlspecialchars($_POST["dueDateActNew"]));
    $estadoAct = trim(htmlspecialchars($_POST["estadoActNew"]));

    if ($estadoAct !== "1" && $estadoAct !== "0") {
        $estadoAct = "0"; // Valor predeterminado si no es válido
    }

    if (empty($tituloAct) || empty($descAct) || empty($dueDateAct)) {
        die("Todos los campos son obligatorios.");
    }

    $insert = "INSERT INTO actividades (project_id, titulo, descripcion, due_date, active) 
               VALUES ('$idProject', '$tituloAct', '$descAct', '$dueDateAct', '$estadoAct')";

    if (!mysqli_query($conn, $insert)) {
        die("Error al insertar la actividad: " . mysqli_error($conn));
    }
}


?>