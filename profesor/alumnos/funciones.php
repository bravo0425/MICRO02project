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
    
    function updateAlumno($conn) {
        $alumno_id = intval($_POST['alumno_id']);
        if(!empty($alumno_id)){
            $usernameA = $_POST["usernameM"];
            $nombreA = $_POST["nombreM"];
            $apellidoA = $_POST["apellidoM"];
            $contrasenyaA = $_POST["contrasenyaM"];
        
            $update = "UPDATE alumnos SET username = '$usernameA', pass = '$contrasenyaA', name = '$nombreA', last_name = '$apellidoA' WHERE id = '$alumno_id'";
            mysqli_query($conn, $update);

            echo "
            <div class='error-pop' id='error-pop'>
                <div class='error-container'>
                    <p>Student updated successfully</p>
                    <button class='popup-close'>Confirmar</button>
                </div>
            </div>
            ";
            echo "<script>
                document.getElementById('error-pop').classList.add('show');
                const popupClose = document.querySelector('.popup-close');
                popupClose.addEventListener('click', function() {
                    document.querySelector('.error-pop').classList.remove('show');
                });
            </script>";
            return;
        }else{
            header('Location: alumnos.php');
        }
        exit();
    }

    function crearAlumno($conn) {
        // Sanitizar entradas
        $usernameA = mysqli_real_escape_string($conn, trim($_POST["username"]));
        $nombreA = mysqli_real_escape_string($conn, trim($_POST["nombre"]));
        $apellidoA = mysqli_real_escape_string($conn, trim($_POST["apellido"]));
        $contrasenyaA = mysqli_real_escape_string($conn, trim($_POST["contrasenya"]));
        $contrasenya2 = mysqli_real_escape_string($conn, trim($_POST["contrasenya2"]));
        $curso = mysqli_real_escape_string($conn, trim($_POST["cursos"]));
    
        // Verificar campos vacíos
        if (empty($usernameA) || empty($nombreA) || empty($apellidoA) || empty($contrasenyaA) || empty($contrasenya2)) {
            mostrarErrorPopup("All fields are required.");
            return;
        }
        // Verificar que las contraseñas coincidan
        if ($contrasenyaA !== $contrasenya2) {
            mostrarErrorPopup("The passwords do not match.");
            return;
        }
        // Crear consulta para insertar datos
        $insert = "INSERT INTO alumnos (username, pass, name, last_name, curso_id) 
                   VALUES ('$usernameA', '$contrasenyaA', '$nombreA', '$apellidoA', '$curso')";
    
        // Ejecutar consulta y verificar éxito
        if (mysqli_query($conn, $insert)) {

            header('Location: alumnos.php');
            exit();
        } else {
            mostrarErrorPopup("Error insert student: " . mysqli_error($conn));
        }
    }
    
    
    

    function eliminarAlumno($conn) {
        $alumno_id = $_POST["alumno_id"];
        if(!empty($alumno_id)){
            $alumno_id = intval($_POST["alumno_id"]);
            $delete1 = "DELETE FROM alumnos WHERE id = $alumno_id";
            if(mysqli_query($conn, $delete1)){
                mostrarSuccesPopup("Student deleted successfully.");
                return;
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
?>