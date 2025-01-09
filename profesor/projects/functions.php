<?php

function updateAct($conn) {
    $actividad_id = intval($_POST['actividad_id']);
    $nombreACT = $_POST['tituloAct'];
    $descripcionAct = $_POST['descripcionAct'];

    $update = "UPDATE actividades SET titulo = '$nombreACT', descripcion = '$descripcionAct' WHERE id = '$actividad_id'";
    mysqli_query($conn, $update);
}

function eliminarAct($conn) {
    $actividad_id = intval($_POST['deleteActivity']);

    $delete1 = "DELETE FROM actividades WHERE id = $actividad_id";

    mysqli_query($conn, $delete1);
}

?>