<?php

    session_start();
    include "../../conexion.php";

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
                    <h1>Make a web design</h1>
                    <p>Width Html and CSS make a web beautiful</p>
                    <p>Last date: 10-12-2024 10:00</p>
                </div>
                
                <div id="estadoActividad" class="card">
                  <p>estado</p>
                  <button>Active</button>
                </div>
            </div>


            <div id="abajo" class="card">
                <div id="items">
                    <h2>Items</h2>
                    <div class="buttonsItems">
                      <button>+ Add new Item</button>
                      <button>BIN</button>
                    </div>
                    <div id="itemsGroup">
                      <div class="cardItem">
                          <div class="contenidoItem">
                            <div class="imgItem">
                              <img src="" alt="">
                            </div>
                            <div class="tituloItem">
                              <h2>Estrucutra</h2>
                            </div>
                            <div class="valueItem">
                              <p>20% <</p>
                            </div>
                          </div>
                          <div class="editBtn">

                          </div>
                      </div>
                    </div>
                </div>

                <button id="evaluarAlumnos">
                  <p>Evalua a tus alumnos -></p>
                </button>

                <div id="tablaNotas">
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
        
</body>
</html>