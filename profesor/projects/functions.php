<?php
    function mostrarImg($conn){
        $idProfe = $_SESSION['idProfe'];

        $queryName = 'SELECT img, tipus FROM profesores WHERE id = ' . $idProfe;
        
        $r = mysqli_query($conn, $queryName);

        if ($r && mysqli_num_rows($r) > 0) {
            $fila = mysqli_fetch_assoc($r);
            
            echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['img']) . "' >";
        }
    }

    function crearActividad($conn) {
        if (empty($_POST['tituloActNew']) || empty($_POST['descriptionActNew']) || empty($_POST['dueDateActNew']) || empty($_POST['estadoActNew'])) {
            mostrarErrorPopup("All fields are required");
            return;
        }
        $titulo = $_POST['tituloActNew'];
        $descripcion = $_POST['descriptionActNew'];
        $dueDate = $_POST['dueDateActNew'];
        $idProject = $_SESSION['idProyecto'];
        $estado = $_POST['estadoActNew'];

        $titulo = mysqli_real_escape_string($conn, $titulo);
        $descripcion = mysqli_real_escape_string($conn, $descripcion);
        $dueDate = mysqli_real_escape_string($conn, $dueDate);
        $idProject = mysqli_real_escape_string($conn, $idProject);
        $estado = mysqli_real_escape_string($conn, $estado);

        $sql = "INSERT INTO actividades (titulo, descripcion, project_id, due_date, active) VALUES ('$titulo', '$descripcion', '$idProject', '$dueDate', '$estado')";
        
        if (mysqli_query($conn, $sql)) {
            $idultimaActividad = mysqli_insert_id($conn);
            $selectActivities = "SELECT id_alumno FROM alumnos_proyectos WHERE id_proyecto = $idProject";
            $r = mysqli_query($conn, $selectActivities);
            while ($row = mysqli_fetch_assoc($r)) {
                $idAlumno = $row['id_alumno'];
                $insertarAlumnos = "INSERT INTO alumnos_actividades (id_alumno, id_actividad) VALUES ('$idAlumno', '$idultimaActividad')";
                mysqli_query($conn, $insertarAlumnos);
            }
            mostrarSuccesPopup("Activity created successfully");
        } else {
            mostrarErrorPopup("Error creating activity");
        }

    }

    function editarProyecto($conn){
        $titulo = $_POST['editTitle'];
        $descripcion = $_POST['editDesc'];
        $idProject = $_SESSION['idProyecto'];

        $sql = "UPDATE proyectos SET titulo = '$titulo', descripcion = '$descripcion' WHERE id = '$idProject'";
        if(mysqli_query($conn, $sql)) {
            mostrarSuccesPopup("Project updated successfully");
        } else {
            mostrarErrorPopup("Error updating project");
        }

    }

    function eliminarActividad($conn, $idActividad){
        $eliminarActividad = "DELETE FROM actividades WHERE id = $idActividad";

        if (mysqli_query($conn, $eliminarActividad)) {
            mostrarSuccesPopup("Activity deleted successfully");
        } else {
            mostrarErrorPopup("Error deleting activity");
        }

    }

    function editarActividad($conn, $idActividad) {
        $titulo = trim($_POST['editActivityTitle']);
        $descripcion = trim($_POST['editActivityDesc']);
        $due_date = $_POST['editActivityDueDate'];
        $estado = intval($_POST['editActivityStatus']);

        if (empty($titulo) || empty($descripcion) || empty($due_date)) {
            echo "<p class='error'>Por favor, complete todos los campos obligatorios.</p>";
            return;
        }

        $titulo = mysqli_real_escape_string($conn, $titulo);
        $descripcion = mysqli_real_escape_string($conn, $descripcion);
        $due_date = mysqli_real_escape_string($conn, $due_date);

        $sql = "UPDATE actividades SET titulo = '$titulo', descripcion = '$descripcion', due_date = '$due_date', active = $estado WHERE id = $idActividad";
        if (mysqli_query($conn, $sql)) {
            mostrarSuccesPopup("Activity updated successfully");
            return;
        }else {
            mostrarErrorPopup("Error updating activity");
        }
        exit();
    }

// Función para mostrar popups de error
function mostrarErrorPopup($mensaje) {
    echo "
    <div class='error-pop'>
        <div class='error-container'>
            <div class='redondaError'>
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                    <path stroke-linecap='round' stroke-linejoin='round' d='M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z' />
                </svg>
            </div>
            <div class='textPOP'>
                <h3>Oooops !!</h3>   
                <p>$mensaje</p>
            </div>
            <button class='popup-close'>Ok</button>
        </div>
    </div>
    <script>
        document.getElementById('error-pop').classList.add('show');
        const popupClose = document.querySelector('.popup-close');
        popupClose.addEventListener('click', function() {
            document.querySelector('.error-pop').classList.remove('show');
            window.location.href = '" . $_SERVER['PHP_SELF'] . "';
        });
    </script>";
}

function mostrarSuccesPopup($mensaje) {
    echo "
    <div class='succes-pop'>
        <div class='succes-container'>
            <div class='redonda'>
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                    <path stroke-linecap='round' stroke-linejoin='round' d='m4.5 12.75 6 6 9-13.5' />
                </svg>
            </div>
            <div class='textPOP'>
                <h3>Succsesful !!</h3>   
                <p>$mensaje</p>
            </div>
            <button class='close-Succes'>Ok</button>
        </div>
    </div>
    <script>
        document.getElementById('succes-pop').classList.add('show');
        const popupClose = document.querySelector('.close-Succes');
        popupClose.addEventListener('click', function() {
            document.querySelector('.succes-pop').classList.remove('show');
            window.location.href = '" . $_SERVER['PHP_SELF'] . "';
        });
    </script>";
}

?>