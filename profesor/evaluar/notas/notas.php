<?php

    session_start();
    include "../../../conexion.php";
    include "functions.php";

    if(isset($_SESSION['nombreUser'])){
        $usuarioLog = $_SESSION['nombreUser'];
        $nom = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
    }else{
        header('Location: ../../../login/login.php');
        exit();
    }

    if (!empty($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: ../../../login/login.php');
        exit();
    }

    if (isset($_SESSION['idActividad'])) {
        $idActivity = intval($_SESSION['idActividad']);
        
        $queryAct = "SELECT * FROM actividades WHERE id = $idActivity";
        $result = mysqli_query($conn, $queryAct);
        
        while($act = mysqli_fetch_assoc($result)){
            $titulo = htmlspecialchars($act['titulo']);
            $descripcion = htmlspecialchars($act['descripcion']);
            $dueDate = htmlspecialchars($act['due_date']);
            $estado = (intval($act['active']) == 1) ? "Active" : "Inactive";
        }
    }

    if(isset($_SESSION['idAlumno'])){
        $idAlumno = $_SESSION['idAlumno'];
       
        $searchAlumno = "SELECT * FROM alumnos WHERE id = $idAlumno";
        $r = mysqli_query($conn, $searchAlumno);

        while($alumno = mysqli_fetch_assoc($r)){
            $idStudent = $alumno['id'];
            $nomStudent = $alumno['name'];
            $cogStudent = $alumno['last_name'];
        }
    }

    $searchItems = "SELECT * FROM items WHERE activity_id = $idActivity";
    $rItems = mysqli_query($conn, $searchItems);

    $items = [];
    if (mysqli_num_rows($rItems) > 0) {
        while ($item = mysqli_fetch_assoc($rItems)) {
            $items[] = $item;
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activities</title>
    <link rel="stylesheet" href="notas.css">
</head>
<body>

<!--Container general-->
    <div class="container">     
        <!-- menu izquierda--> 
        <div class="contenedor-nav">
            <div class="nav">
                <div class="titulo">
                    <h1>Taskify®</h1>
                </div>
                <div class="usuario">
                    <?php mostrarImg($conn); ?>                    
                    <h3><?php echo $nom ?></h3>
                </div>
                <div class="navbar">
                    <button onclick="goDasboard()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../../imagenes/dashboard.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Dashboard</h2>
                            </div>
                        </div>
                        
                    </button>
                    <button onclick="goCursos()" class="menu active">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../../imagenes/cursos.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Cursos</h2>
                            </div>
                        </div>
                    </button>
                    <button onclick="goStudents()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../../imagenes/students.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Students</h2>
                            </div>
                        </div>
                    </button>
                    <button onclick="goChat()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../../imagenes/chat.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Chat</h2>
                            </div>
                        </div>
                    </button>
                    <button onclick="goSettings()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../../imagenes/settings.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Settings</h2>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
            <div class="update">
                <h4>Try to update</h4>
                <p>Version 1.0v</p>
                <div class="botones-update">
                    <button type="button" id="update">Update</button>
                    <button type="button" id="more">More</button>
                </div>
            </div>
            <form action="" method="POST">
                <button type="submit" name="logout" value="tonto" class="log-out">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="iconLogout">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                    </svg>

                    <h2>Log out</h2>
                </button>
            </form>
        </div>

        <!-- contenido -->
        <div class="contenido">

            <div id="arriba">

                <div id="infoApp" class="card">
                    <h2>Evaluate Students</h2>
                    <form method="POST" action="../lista/lista.php">
                        <button type="submit">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                            </a>
                            <p>back to Evaluate Activities</p>
                        </button>
                    </form>
                </div>

                <div id="description" class="card">
                    <h1><?php echo htmlspecialchars($nomStudent ?? '') . ' ' . htmlspecialchars($cogStudent ?? '') ; ?></h1>
                </div>
            </div>


            <div id="abajo">
                <div id="activity">
                    <div id="file"  class="card">
                        <p>File</p>
                        <button>Descarga</button>
                    </div>
                    <div id="info"  class="card">
                        <p>Activity</p>
                        <p><?php echo htmlspecialchars($titulo) ?></p>    
                        <p><?php echo htmlspecialchars($descripcion) ?></p>
                    </div>
                </div>

                <div id="formItems" class="card">
                    <h2>Asign Scores of the Activity</h2>
                    <?php if (!empty($items)): ?>
                        <form method="POST" action="">
                            <?php foreach ($items as $item): ?>
                                <div class="inputs">
                                    <label for="item_<?php $item['id']; ?>"><?= htmlspecialchars($item['titulo']) . ' ' . htmlspecialchars($item['valor']); ?>%</label>
                                    <?php $idItem = $item['id']; ?>
                                    <input type="text" name="item_<?php $item['id']; ?>" value="<?php mostrarNotaItemAlumno($conn, $idStudent, $idItem); ?>" min="0" max="10" required>
                                </div>
                                
                            <?php endforeach; ?>
                            <div class="buttonDiv">
                                <input type="submit" id="evaluatebtn" name="evaluate" value="Evaluate">
                            </div>
                        </form>
                    <?php else: ?>
                        <p>No items assigned to this activity.</p>
                    <?php endif; ?>
                </div>

            </div>

        </div>
    </div>
        
    <script></script>
</body>
</html>