<?php

    session_start();
    include "../../../conexion.php";


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



?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proyecto con Cake Frame y Animaciones</title>
  <style>
    /* Estilos iniciales */
    body {
      margin: 0;
      height: 100vh;
      display: grid;
      grid-template-columns: repeat(12, 1fr); /* 12 columnas para el diseño */
      grid-template-rows: repeat(12, 1fr); /* 12 filas */
      gap: 20px; /* Espacio entre los elementos */
      background: #f4f4f4; /* Fondo gris claro */
      padding: 20px;
      overflow: hidden; /* Evitar barras de desplazamiento */
    }

    /* Fondo de la página con animación */
    .background {
      grid-column: 1 / 13; /* Ocupa toda la anchura */
      grid-row: 1 / 13; /* Ocupa toda la altura */
      background: linear-gradient(135deg, #ff7e5f, #feb47b); /* Fondo de degradado */
      border-radius: 10px;
      animation: backgroundAnim 5s ease-in-out infinite; /* Animación de fondo */
    }

    /* Animación del fondo */
    @keyframes backgroundAnim {
      0% {
        background: linear-gradient(135deg, #ff7e5f, #feb47b);
      }
      50% {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
      }
      100% {
        background: linear-gradient(135deg, #ff7e5f, #feb47b);
      }
    }

    /* Caja central o contenido con animación */
    .content {
      grid-column: 3 / 11; /* Alineación central en el grid */
      grid-row: 3 / 11; /* Alineación central en el grid */
      background-color: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      opacity: 0; /* Inicialmente invisible */
      animation: slideUp 1s ease-out forwards; /* Animación de deslizamiento */
    }

    /* Animación de deslizamiento */
    @keyframes slideUp {
      0% {
        transform: translateY(100px); /* Comienza desde abajo */
        opacity: 0;
      }
      100% {
        transform: translateY(0); /* Llega a la posición final */
        opacity: 1;
      }
    }

    /* Texto dentro de la caja */
    .content h1 {
      font-size: 3em;
      text-align: center;
      color: #333;
    }

    .content p {
      font-size: 1.2em;
      color: #666;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="background"></div>
  <div class="content">
    <h1>Bienvenido a mi Proyecto</h1>
    <p>Este es un ejemplo de un diseño con animaciones usando CSS Grid.</p>
  </div>
</body>
</html>
