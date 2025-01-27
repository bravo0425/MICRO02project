<?php

function mostrarImg($conn) {
    $idAlumno = $_SESSION['idAlumno'];
    $queryName = 'SELECT img, tipus FROM alumnos WHERE id = ' . $idAlumno;
    $r = mysqli_query($conn, $queryName);
    // Asegúrate de que haya resultados
    if ($r && mysqli_num_rows($r) > 0) {
        $fila = mysqli_fetch_assoc($r);
        // Verifica si la imagen está vacía o nula
        if (!empty($fila['img'])) {
            echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['img']) . "' >";
        } else {
            echo "<img src='../../imagenes/usuario.png' alt='Imagen por defecto'>";
        }
    } else {
        echo "<img src='../../imagenes/usuario.png' alt='Imagen por defecto'>";
    }
}

function entregarActividad($conn) {
    $idActividad = $_SESSION['idActividadTemp'];
    $idAlumno = $_SESSION['idAlumno'];
    if (!empty($_FILES['file'])) {
        $update = "UPDATE alumnos_actividades SET entregado = 1 WHERE id_actividad = '$idActividad' AND id_alumno = '$idAlumno'";
        if (mysqli_query($conn, $update)){
            mostrarSuccesPopup("Activity send successfully");
        } else {
            mostrarSuccesPopup("Error sending activity");
        }
    } 
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
        });
    </script>";
}