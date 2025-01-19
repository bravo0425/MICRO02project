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

function mostrarIcon($conn, $idItem){
    $query = "SELECT icon, tipus FROM items WHERE id = $idItem";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $fila = mysqli_fetch_assoc($result);
        
        if (!empty($fila['icon']) && !empty($fila['tipus'])) {
            echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['icon']) . "' alt='Icono'>";
        } else {
            echo "<img src='../../imagenes/raul.jpg'>";
        }
    } else {
        echo "<img src='../../imagenes/raul.jpg'>";
    }
}

function añadirItem($conn, $idActivity) {    
    $titulo = $_POST['tituloNewItem'];
    $valor = $_POST['valorNewItem']; 
    $icono = $_FILES['imgIcon'];
    $tipus = $_FILES['imgIcon']['type'];

    $imgData = file_get_contents($icono['tmp_name']);
    $imgData = mysqli_real_escape_string($conn, $imgData);

    $insertQuery = "INSERT INTO items (activity_id, titulo, valor, icon, tipus) 
                    VALUES ('$idActivity', '$titulo', '$valor', '$imgData', '$tipus')";
    mysqli_query($conn, $insertQuery);

    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}


function mostrarItems($conn, $idActivity) {
    $serachItems = "SELECT * FROM items WHERE activity_id = $idActivity";
    $rI = mysqli_query($conn, $serachItems);

    if ($rI && mysqli_num_rows($rI) > 0) {
        while ($fila = mysqli_fetch_assoc($rI)) {
            $idItem = $fila['id'];
            $titulo = htmlspecialchars($fila['titulo']);
            $valor = $fila['valor'];

            echo '<div class="itemContent">';
            echo '<div class="rightPartItem">';
            echo '  <button type="submit" name="deleteItem" value="' .$idItem . '"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg></button>';
            echo '</div>';

            echo '<div class="leftPartItem">';
            echo '  <div class="imgItem">';
            echo    mostrarIcon($conn, $idItem);
            echo '  </div>';

            echo '  <label for="icon-' . $idItem . '" class="updateIcon">Update Icon:</label>';
            echo '  <input type="file" class="none" id="imgItems" name="iconItem[' . $idItem . ']" value="">';

            echo '  <label for="titulo-' . $idItem . '">Título:</label>';
            echo '  <input type="text" id="tituloItems" name="titulo[' . $idItem . ']" value="' . $titulo . '">';

            echo '  <label for="valor-' . $idItem . '">Valor:</label>';
            echo '  <select name="valor[' . $idItem . ']" id="valorItems">';
                for ($i = 10; $i <= 100; $i += 10) {
                    $selected = ($valor == $i) ? 'selected' : '';
                    echo '<option value="' . $i . '" ' . $selected . '>' . $i . '%</option>';
                }
            echo '  </select>';
            echo '</div>';
        echo '</div>';

        }
    } else {
        echo "No se encontraron ítems para esta actividad.";
    }
}


function eliminarItem($conn, $idItem) {
    $idItem = intval($idItem);

    $query = "DELETE FROM items WHERE id = $idItem";
    mysqli_query($conn, $query);

}


     
function mostrsarItems($conn, $idActivity) {
    $serachItems = "SELECT * FROM items WHERE activity_id = $idActivity";
    $rI = mysqli_query($conn, $serachItems);

    if ($rI && mysqli_num_rows($rI) > 0) {
        while ($fila = mysqli_fetch_assoc($rI)) {
            $idItem = $fila['id'];
            $titulo = htmlspecialchars($fila['titulo']);
            $valor = $fila['valor'];

            echo '<div class="item">';
                echo '<button type="submit" name="deleteItem" value="' .$idItem . '">bin</button>';
                echo mostrarIcon($conn, $idItem);

                echo '<label for="icon-' . $idItem . '" class="updateIcon">Update Icon:</label>';
                echo '<input type="file" id="icon-' . $idItem . '" name="iconItem[' . $idItem . ']" value="">';

                echo '<label for="titulo-' . $idItem . '">Título:</label>';
                echo '<input type="text" id="titulo-' . $idItem . '" name="titulo[' . $idItem . ']" value="' . $titulo . '">';

                echo '<label for="valor-' . $idItem . '">Valor:</label>';
                echo '<select name="valor[' . $idItem . ']" id="valor-' . $idItem . '">';
                for ($i = 10; $i <= 100; $i += 10) {
                    $selected = ($valor == $i) ? 'selected' : '';
                    echo '<option value="' . $i . '" ' . $selected . '>' . $i . '%</option>';
                }
                echo '</select>';
            echo '</div>';
        }
    } else {
        echo "No se encontraron ítems para esta actividad.";
    }
}

function mostrarItemsBD($conn, $idActivity) {
    $serachItems = "SELECT * FROM items WHERE activity_id = $idActivity";
    $rI = mysqli_query($conn, $serachItems);

    if ($rI && mysqli_num_rows($rI) > 0) {
        while ($fila = mysqli_fetch_assoc($rI)) {
            $idItem = $fila['id'];
            $titulo = htmlspecialchars($fila['titulo']);
            $valor = $fila['valor'];

            echo '<div class="item">';
            echo '    <div class="contenidoItem">';
            echo '        <div class="imgItem">';
            echo            mostrarIcon($conn, $idItem);
            echo '        </div>';
            echo '        <div class="tituloItem">';
            echo '            <h2>' . $titulo . '</h2>';
            echo '        </div>';
            echo '        <div class="valueItem">';
            echo '            <p>' . $valor . ' %</p>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }
    } else {
        echo "Any item yet";
    }
}



?>

