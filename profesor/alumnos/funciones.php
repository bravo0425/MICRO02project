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
        $usernameA = trim(htmlspecialchars($_POST["username"]));
        $nombreA = trim(htmlspecialchars($_POST["nombre"]));
        $apellidoA = trim(htmlspecialchars($_POST["apellido"]));
        $contrasenyaA = trim(htmlspecialchars($_POST["contrasenya"]));
        $contrasenya2 = trim(htmlspecialchars($_POST["contrasenya2"]));
        $curso = trim(htmlspecialchars($_POST["cursos"]));
        if (empty($_POST['username']) || empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['contrasenya']) || empty($_POST['contrasenya2'])) {
            echo "
            <div class='error-pop' id='error-pop'>
                <div class='error-container'>
                    <p>All fields are required.</p>
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
        } if ($contrasenyaA != $contrasenya2) {
            echo "Las contraseñas no coinciden";
            return;
        } else {
            $insert = "INSERT INTO alumnos (username, pass, name, last_name, curso_id) VALUES ('$usernameA', '$contrasenyaA', '$nombreA', '$apellidoA', '$curso')";
            mysqli_query($conn, $insert);
            header('Location: alumnos.php');
            exit();
        }
    }

    function eliminarAlumno($conn) {
        $alumno_id = $_POST["alumno_id"];
        if(!empty($alumno_id)){
            $alumno_id = intval($_POST["alumno_id"]);
            $delete1 = "DELETE FROM alumnos WHERE id = $alumno_id";
            mysqli_query($conn, $delete1);
            echo "
            <div class='error-pop' id='error-pop'>
                <div class='error-container'>
                    <p>Student deleted successfully.</p>
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
        } else {
            header('Location: alumnos.php');
        }
        exit();
    }
?>