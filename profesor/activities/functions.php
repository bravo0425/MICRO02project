<?php

function mostrarImg($conn)
{
    $idProfe = $_SESSION['idProfe'];

    $queryName = 'SELECT img, tipus FROM profesores WHERE id = ' . $idProfe;
    $r = mysqli_query($conn, $queryName);

    if ($r && mysqli_num_rows($r) > 0) {
        $fila = mysqli_fetch_assoc($r);

        echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['img']) . "' >";
    }
}

function mostrarIcon($conn, $idItem)
{
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

function añadirItem($conn, $idActivity)
{
    $titulo = $_POST['tituloNewItem'];
    $valor = $_POST['valorNewItem'];
    $icono = $_FILES['imgIcon'];
    $tipus = $_FILES['imgIcon']['type'];

    $imgData = file_get_contents($icono['tmp_name']);
    $imgData = mysqli_real_escape_string($conn, $imgData);

    $insertQuery = "INSERT INTO items (activity_id, titulo, valor, icon, tipus) 
                    VALUES ('$idActivity', '$titulo', '$valor', '$imgData', '$tipus')";
    mysqli_query($conn, $insertQuery);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


function mostrarItems($conn, $idActivity){
    $serachItems = "SELECT * FROM items WHERE activity_id = $idActivity";
    $rI = mysqli_query($conn, $serachItems);
    echo "<div class='itemListContainer'>";
    if ($rI && mysqli_num_rows($rI) > 0) {
        while ($fila = mysqli_fetch_assoc($rI)) {
            $idItem = $fila['id'];
            $titulo = htmlspecialchars($fila['titulo']);
            $valor = $fila['valor'];

            echo '<div class="itemCard">';
            echo '<div class="itemImage">';
            echo mostrarIcon($conn, $idItem); 
            echo '</div>';
            echo '<p class="itemLabel">' . $titulo . '</p>';
            echo '<p class="itemLabel">' . $valor . '%</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No se encontraron ítems para esta actividad.</p>';
    }
    echo "</div>";

}


function mostrarItemsEditar($conn, $idActivity){
    $serachItems = "SELECT * FROM items WHERE activity_id = $idActivity";
    $rI = mysqli_query($conn, $serachItems);

    echo "<div class='itemsContainer'>";
    if ($rI && mysqli_num_rows($rI) > 0) {
        while ($fila = mysqli_fetch_assoc($rI)) {
            $idItem = $fila['id'];
            $titulo = htmlspecialchars($fila['titulo']);
            $valor = $fila['valor'];

            echo '<div class="itemWrapper">';

            echo '<div class="itemDeleteButton">';
            echo '  <button type="submit" name="deleteItem" value="' . $idItem . '">';
            echo '  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="iconSize">';
            echo '  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />';
            echo '  </svg></button>';
            echo '</div>';

            echo '<div class="itemDetailsWrapper">';
            echo '  <div class="itemImageContainer">';
            echo    mostrarIcon($conn, $idItem);
            echo '  </div>';
            echo '  <label for="iconItem-' . $idItem . '" class="iconUpdateLabel">Update Icon:</label>';
            echo '  <input type="file" class="hiddenInput" id="iconItem-' . $idItem . '" name="iconItem[' . $idItem . ']" value="">';

            echo '  <label for="titulo-' . $idItem . '" class="itemTitleLabel">Título:</label>';
            echo '  <input type="text" class="itemTitleInput" id="tituloItems" name="titulo[' . $idItem . ']" value="' . $titulo . '">';

            echo '  <label for="valor-' . $idItem . '" class="itemValueLabel">Valor:</label>';
            echo '  <select name="valor[' . $idItem . ']" id="valorItems" class="itemValueSelect">';
            for ($i = 10; $i <= 100; $i += 10) {
                $selected = ($valor == $i) ? 'selected' : '';
                echo '<option value="' . $i . '" ' . $selected . '>' . $i . '%</option>';
            }
            echo '  </select>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No se encontraron ítems para esta actividad.</p>';
    }
    echo "</div>";
}


function eliminarItem($conn, $idItem){
    $idItem = intval($idItem);

    $query = "DELETE FROM items WHERE id = $idItem";
    mysqli_query($conn, $query);
}

function updateItems($conn, $idActivity) {
    if (!empty($_POST['titulo']) && !empty($_POST['valor'])) {
        $titulos = $_POST['titulo'];
        $valores = $_POST['valor'];
        $files = $_FILES['iconItem'] ?? null;

        // Comprobar si la suma de valores es 100
        $totalValor = array_sum($valores);
        if ($totalValor != 100) {
            echo "<p>Error: La suma de los valores debe ser igual a 100. La suma actual es $totalValor.</p>";
            return;
        }

        // Si la suma es correcta, proceder con la actualización
        foreach ($titulos as $idItem => $titulo) {
            $valor = $valores[$idItem] ?? null;

            if ($valor !== null) {
                $titulo = mysqli_real_escape_string($conn, $titulo);
                $valor = mysqli_real_escape_string($conn, $valor);

                $updateQuery = "UPDATE items SET titulo = '$titulo', valor = '$valor'";

                if (!empty($files['tmp_name'][$idItem]) && is_uploaded_file($files['tmp_name'][$idItem])) {
                    $iconFile = $files['tmp_name'][$idItem];
                    $iconData = file_get_contents($iconFile);
                    $iconData = mysqli_real_escape_string($conn, $iconData);
                    $updateQuery .= ", icon = '$iconData'";
                }

                $updateQuery .= " WHERE id = $idItem AND activity_id = $idActivity";

                $result = mysqli_query($conn, $updateQuery);

                if (!$result) {
                    echo "<p>Error al actualizar el ítem con ID $idItem: " . mysqli_error($conn) . "</p>";
                }
            }
        }

        echo "<p>Ítems actualizados correctamente.</p>";
    } else {
        echo "<p>No se enviaron datos para actualizar.</p>";
    }
}

