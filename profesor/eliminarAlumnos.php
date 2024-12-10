<?php
include "../conexion.php";

// Función para eliminar un alumno por ID
if (!empty($_POST['eliminarAlumnos']) && (isset($_POST["alumno_id"]))) {
    $alumno_id = intval($_POST["alumno_id"]); // Validar ID recibido
    $delete_query = "DELETE FROM alumnos WHERE id = $alumno_id";

    $r = mysqli_query($conn, $delete_query);
    
    if ($r) {
        echo "<script>alert('Alumno eliminado correctamente.');</script>";
    } else {
        echo "<script>alert('Error al eliminar alumno.');</script>";
    }
}
?>