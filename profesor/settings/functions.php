<?php
function mostrarUsername($conn) {
    $idProfe = $_SESSION['idProfe'];
    $queryName = 'SELECT username FROM profesores WHERE id = ' . $idProfe;
    $r = mysqli_query($conn, $queryName);
    while ($fila = mysqli_fetch_assoc($r)) {
        echo "<p>" . htmlspecialchars($fila['username']) . "</p>";
    }
}

function mostrarMail($conn) {
    $idProfe = $_SESSION['idProfe'];
    $queryName = 'SELECT email FROM profesores WHERE id = ' . $idProfe;
    $r = mysqli_query($conn, $queryName);
    while ($fila = mysqli_fetch_assoc($r)) {
        echo "<p>" . htmlspecialchars($fila['email']) . "</p>";
    }
}

function updateImg($conn) {
    if (empty($_FILES['updateImg']['name'])) {
        mostrarErrorPopup("Choose an image");
        return;
    }
    
    $idProfe = $_SESSION['idProfe'];
    $file = $_FILES['updateImg'];
    $tipus = $_FILES['updateImg']['type'];

    $imgData = file_get_contents($file['tmp_name']);
    $imgData = mysqli_real_escape_string($conn, $imgData);

    $sql = "UPDATE profesores SET img = '$imgData', tipus = '$tipus' WHERE id = $idProfe";

    if(mysqli_query($conn, $sql)) {
        mostrarSuccesPopup("Image updated");
    } else {
        mostrarErrorPopup("Error updating image");
    }
}

function mostrarImg($conn){
    $idProfe = $_SESSION['idProfe'];

    $queryName = 'SELECT img, tipus FROM profesores WHERE id = ' . $idProfe;
    
    $r = mysqli_query($conn, $queryName);

    // Asegúrate de que haya resultados
    if ($r && mysqli_num_rows($r) > 0) {
        $fila = mysqli_fetch_assoc($r);
        
        // Mostrar la imagen a través de un archivo PHP
        echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['img']) . "' >";
    }
}


function cambiarPass($conn) {
    $idProfe = $_SESSION['idProfe'];

    // Consulta para obtener la contraseña del profesor
    $queryName = 'SELECT * FROM profesores WHERE id = ' . $idProfe;
    $r = mysqli_query($conn, $queryName);

    if ($fila = mysqli_fetch_assoc($r)) {
        $correctOldPass = trim($fila['pass']);
    } else {
        echo "<p>Error: No se encontró el usuario.</p>";
        return;
    }

    $oldpass = trim($_POST['oldpass']);
    $newpass = $_POST['newpass'];
    $newpass2 = $_POST['newpass2'];

    // Compara la contraseña ingresada con la de la base de datos
    if ($oldpass !== $correctOldPass) {
        mostrarErrorPopup("The old password does not match");
    } elseif ($newpass !== $newpass2) {
        // Verifica si las nuevas contraseñas coinciden
        mostrarErrorPopup("The passwords do not match");
    } else {
        // Actualiza la contraseña en la base de datos
        $updateQuery = "UPDATE profesores SET pass = '$newpass' WHERE id = $idProfe";
        if (mysqli_query($conn, $updateQuery)) {
            mostrarSuccesPopup("Password updated successfully");
        } else {
            mostrarErrorPopup("Error updating password");
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
