<?php
function entregarActividad($conn) {
    $idActividad = $_SESSION['idActividadTemp'];
    $idAlumno = $_SESSION['idAlumno'];
    echo $idActividad;
    echo $idAlumno;
    if (!empty($_FILES['file'])) {
        $update = "UPDATE alumnos_actividades SET entregado = 1 WHERE id_actividad = '$idActividad' AND id_alumno = '$idAlumno'";
        if (mysqli_query($conn, $update)){
            echo "Actividad entregada con éxito";
        } else {
            echo "Error al entregar la actividad";
        }
    } 
}
?>