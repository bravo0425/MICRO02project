<?php
    include "../../conexion.php";
    include "functions.php";
    
    session_start();

    if(isset($_SESSION['nombreUser'])){
        $usuarioLog = $_SESSION['nombreUser'];
        $nom = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
    }else{
        header('Location: ../../login/login.php');
        exit();
    }

    if (!empty($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: ../../login/login.php');
        exit();
    }

    if (!empty($_POST['añadirItem'])) {
        añadirItem($conn);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activities</title>
    <link rel="stylesheet" href="activity.css">
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
                    <img src="../../imagenes/usuario.png" width="23px">
                    <h3><?php echo $nom ?></h3>
                </div>
                <div class="navbar">
                    <button onclick="goDasboard()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/dashboard.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Dashboard</h2>
                            </div>
                        </div>
                        
                    </button>
                    <button onclick="goCursos()" class="menu active">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/cursos.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Cursos</h2>
                            </div>
                        </div>
                    </button>
                    <button onclick="goStudents()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/students.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Students</h2>
                            </div>
                        </div>
                    </button>
                    <button onclick="goChat()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/chat.png" width="27px">
                            </div>
                            <div class="h2Nav">
                                <h2>Chat</h2>
                            </div>
                        </div>
                    </button>
                    <button onclick="goSettings()" class="menu">
                        <div class="positionButton">
                            <div class="imgNav">
                                <img src="../../imagenes/settings.png" width="27px">
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
                    <h2>Activities</h2>
                    <form method="POST" action="../projects/project.php">
                        <button type="submit">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                            </a>
                            <p>back to projects</p>
                        </button>
                    </form>
                </div>

                <div id="description" class="card">
                    <?php
                        $IdActividad = $_GET['actividad_id'];
                        $select = "SELECT titulo, descripcion, due_date FROM actividades WHERE id = '$IdActividad'";
                        $resACT = mysqli_query($conn, $select);
                        while ($fila = mysqli_fetch_assoc($resACT)) {
                            ?>
                            <h1><?php echo $fila['titulo'] ?><h1>
                            <p><?php echo $fila['descripcion']?></p>
                            <p>Last date: <?php echo $fila['due_date']?></p>
                    <?php
                        }
                    ?>
                </div>
                
                <div id="estadoActividad" class="card">
                  <p>estado</p>
                  <button>Active</button>
                </div>
            </div>


            <div id="abajo">
                <div id="items" class="card">
                    <div class="buttonsItems">
                      <h2>Items</h2>
                      <button type="button" name="show_popup" class="addbtn" id="addbtn">+ Add new Item</button>
                      <div id="popUp">
                        <form action="" method="POST" id="añadirItemF">
                            <button type="submit" id="close_popup" name="close_popup" class="close-btn" value="close_popup">X</button>
                            <div class="contenidoForm">
                                <label for="actividad">Actividad:</label>
                                <select name="actividad" id="actividad">
                                    <?php
                                        $selectAct = "SELECT id, titulo FROM actividades";
                                        $resActividad = mysqli_query($conn, $selectAct);
                                        while ($fila = mysqli_fetch_assoc($resActividad)) {
                                            echo "<option required value='" . $fila['id'] . "'>" . $fila['titulo'] . "</option>";
                                        }
                                    ?>
                                </select>
                                <label for="titulo">Title: </label>
                                <input type="text" name="titulo" id="titulo">
                                <label for="valor">Value: </label>
                                <select name="valores" id="valores">
                                    <option value="10">10%</option>
                                    <option value="20">20%</option>
                                    <option value="30">30%</option>
                                    <option value="40">40%</option>
                                    <option value="50">50%</option>
                                    <option value="60">60%</option>
                                    <option value="70">70%</option>
                                    <option value="80">80%</option>
                                    <option value="90">90%</option>
                                    <option value="100">100%</option>
                                </select>
                                <button type="submit" id="añadirItem" name="añadirItem" value="añadirItem">Add Item</button>
                            </div>
                        </form>
                      </div>
                      <button class="deletebtn">BIN</button>
                    </div>
                    <div id="itemsGroup">
                        <?php
                            $selectItems = "SELECT titulo, valor FROM items WHERE activity_id = $IdActividad";
                            $resItem = mysqli_query($conn, $selectItems);
                            while ($fila = mysqli_fetch_assoc($resItem)) {
                        ?>
                        <div class="cardItem">
                            <div class="contenidoItem">
                                <div class="imgItem">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75 16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                                    </svg>
                                </div>
                                <div class="tituloItem">
                                <h2><?php echo $fila['titulo'] ?></h2>
                                </div>
                                <div class="valueItem">
                                <p><?php echo $fila['valor'] ?></p>
                                </div>
                            </div>
                            <div class="editBtn">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php
                            }
                    ?>
                    </div>
                </div>

                <form method="POST" action="../evaluar/lista/lista.php">
                    <button type="submit" id="evaluarAlumnos">
                        <p>Evalua a tus alumnos -></p>
                    </button>
                </form>

                <div id="tablaNotas" class="card">
                    <h2>Notas alumnos</h2>
                    <table>
                      <thead>
                        <tr>
                          <th>nom</th>
                          <th>item 1</th>
                          <th>item 2</th>
                          <th>item 3</th>
                          <th>item 4</th>
                          <th>Nota final</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Ferran Bravo</td>
                          <td>8</td>
                          <td>7</td>
                          <td>10</td>
                          <td>5</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>Ferran Bravo</td>
                          <td>8</td>
                          <td>7</td>
                          <td>10</td>
                          <td>5</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>Ferran Bravo</td>
                          <td>8</td>
                          <td>7</td>
                          <td>10</td>
                          <td>5</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>Ferran Bravo</td>
                          <td>8</td>
                          <td>7</td>
                          <td>10</td>
                          <td>5</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>Ferran Bravo</td>
                          <td>8</td>
                          <td>7</td>
                          <td>10</td>
                          <td>5</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>Ferran Bravo</td>
                          <td>8</td>
                          <td>7</td>
                          <td>10</td>
                          <td>5</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>Ferran Bravo</td>
                          <td>8</td>
                          <td>7</td>
                          <td>10</td>
                          <td>5</td>
                          <td>8</td>
                        </tr>
                      </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
        
    <script src="activity.js"></script>
</body>
</html>