<?php

function mostrarImg($conn) {
    $idProfe = $_SESSION['idProfe'];
    $queryName = 'SELECT img, tipus FROM profesores WHERE id = ' . $idProfe;
    $r = mysqli_query($conn, $queryName);
    if ($r && mysqli_num_rows($r) > 0) {
        $fila = mysqli_fetch_assoc($r);
        if (!empty($fila['img'])) {
            echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['img']) . "' >";
        } else {
            echo "<img src='../../imagenes/usuario.png' alt='Imagen por defecto'>";
        }
    } else {
        echo "<img src='../../imagenes/usuario.png' alt='Imagen por defecto'>";
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

function añadirItem($conn, $idActivity){
    $titulo = $_POST['tituloNewItem'];
    $valor = $_POST['valorNewItem'];
    $icono = $_FILES['imgIcon'];
    $tipus = $_FILES['imgIcon']['type'];

    if (empty($_POST['tituloNewItem']) || empty($_POST['valorNewItem']) || empty($_FILES['imgIcon']['name'])) {
        mostrarErrorPopup("All fields are required");
        return;
    }

    $imgData = file_get_contents($icono['tmp_name']);
    $imgData = mysqli_real_escape_string($conn, $imgData);

    $insertQuery = "INSERT INTO items (activity_id, titulo, valor, icon, tipus) 
                    VALUES ('$idActivity', '$titulo', '$valor', '$imgData', '$tipus')";
    mysqli_query($conn, $insertQuery);

    $idultimaItem = mysqli_insert_id($conn);
    $selectItems = "SELECT id_alumno FROM alumnos_actividades WHERE id_actividad = $idActivity";
    $r = mysqli_query($conn, $selectItems);
    while ($row = mysqli_fetch_assoc($r)) {
        $idAlumno = $row['id_alumno'];
        $insertarAlumnos = "INSERT INTO alumnos_items (id_alumno, id_item) VALUES ('$idAlumno', '$idultimaItem')";
        mysqli_query($conn, $insertarAlumnos);
    }

    mostrarSuccesPopup("Skill added succesfully");
    return;
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
    } 
    echo "</div>";
}

function eliminarItem($conn, $idItem){
    $idItem = intval($idItem);

    $query = "DELETE FROM items WHERE id = $idItem";
    mysqli_query($conn, $query);
    mostrarSuccesPopup("Skill deleted successfully");
}

function updateItems($conn, $idActivity) {
    if (!empty($_POST['titulo']) && !empty($_POST['valor'])) {
        $titulos = $_POST['titulo'];
        $valores = $_POST['valor'];
        $files = $_FILES['iconItem'] ?? null;

        // Comprobar si la suma de valores es 100
        $totalValor = array_sum($valores);
        if ($totalValor != 100) {
            mostrarErrorPopup("Error: La suma de los valores debe ser igual a 100. Y es $totalValor");
            return;
        }
        // Si la suma es 100 hace el update
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
                mysqli_query($conn, $updateQuery);
            }
        }

        mostrarSuccesPopup("Skills updated successfully");
    } else {
        mostrarErrorPopup("Error updating skills");
    }
}

function getScoreItem($conn, $idAlumno, $idItem) {
    $sqlItem = "SELECT * FROM alumnos_items WHERE id_alumno = $idAlumno and id_item = $idItem";
    $r = mysqli_query($conn, $sqlItem);
    if (mysqli_num_rows($r) > 0) {
        $row = mysqli_fetch_assoc($r);
        return $row['notaItem'];
    } else {
        return null;
    }
}

function notaActividad($conn, $idAlumno, $idActivity) {
    $sqlItems = "SELECT * FROM items WHERE activity_id = $idActivity";
    $result = mysqli_query($conn, $sqlItems);
    $nota = 0;

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Obtener la puntuación del ítem
            $itemsScore = getScoreItem($conn, $idAlumno, $row['id']);
            // Verificar si no se obtuvo puntuación
            if ($itemsScore === null) {
                return null;  // Si algún ítem no tiene puntuación, retorna null
            }
            // Sumar la puntuación ponderada
            $nota += intval($itemsScore) * (intval($row['valor']) / 100);
        }
    } else {
        return null;  // Si no hay items para la actividad, retornar null
    }
    return $nota;
}

function generarTablaAlumnosNotas($conn, $idActivity) {
    // Obtener los ítems asociados a la actividad
    $itemIds = [];
    $queryItems = "SELECT id, titulo FROM items WHERE activity_id = $idActivity";
    $resultItems = mysqli_query($conn, $queryItems);

    if ($resultItems && mysqli_num_rows($resultItems) > 0) {
        while ($item = mysqli_fetch_assoc($resultItems)) {
            $itemIds[] = $item['id'];
        }
    }

    // Iniciar el contenido de la tabla
    $tabla = "<table>
                <thead>
                    <tr>
                        <th id='borderLeft'>Name</th>";

                        foreach ($itemIds as $itemId) {
                            $queryTitulo = "SELECT titulo FROM items WHERE id = $itemId";
                            $resultTitulo = mysqli_query($conn, $queryTitulo);
                            $titulo = mysqli_fetch_assoc($resultTitulo)['titulo'] ?? 'Item';
                            $tabla .= "<th>" . htmlspecialchars($titulo) . "</th>";
                        }

    $tabla .= "         <th id='borderRight'>Nota final</th>
                    </tr>
                </thead>
                <tbody>";

    // Consultar alumnos relacionados con la actividad
    $queryAlumnos = "SELECT alumnos.id AS alumno_id, alumnos.name AS alumno_name FROM alumnos WHERE alumnos.id IN (SELECT id_alumno FROM alumnos_items WHERE id_item IN (SELECT id FROM items WHERE activity_id = $idActivity))";
    $resultAlumnos = mysqli_query($conn, $queryAlumnos);

    // Variables para estructurar los datos
    $currentAlumnoId = null;
    $notasAlumno = [];
    $notaFinal = 0;

    while ($fila = mysqli_fetch_assoc($resultAlumnos)) {
        if ($currentAlumnoId !== $fila['alumno_id']) {
            // Cerrar la fila anterior, si existe
            if ($currentAlumnoId !== null) {
                foreach ($itemIds as $itemId) {
                    $tabla .= "<td>" . htmlspecialchars(getScoreItem($conn, $currentAlumnoId, $itemId) ?? '0') . "</td>";
                }
                $tabla .= "<td>" . htmlspecialchars(notaActividad($conn, $currentAlumnoId, $idActivity) ?? '0') . "</td>";
                $tabla .= "</tr>";
            }

            // Reiniciar para el nuevo alumno
            $currentAlumnoId = $fila['alumno_id'];
            $notasAlumno = array_fill_keys($itemIds, 0);
            $notaFinal = 0;

            // Iniciar una nueva fila para el alumno
            $tabla .= "<tr>";
            $tabla .= "<td>" . htmlspecialchars($fila['alumno_name'] ?? '') . "</td>";
        }

        // Guardar la nota para el ítem actual
        foreach ($itemIds as $itemId) {
            $notaItem = getScoreItem($conn, $currentAlumnoId, $itemId);
            $notasAlumno[$itemId] = $notaItem !== null ? $notaItem : 0;
        }
    }

    // Imprimir la última fila
    if ($currentAlumnoId !== null) {
        foreach ($itemIds as $itemId) {
            $tabla .= "<td>" . htmlspecialchars($notasAlumno[$itemId] ?? '0') . "</td>";
        }
        $tabla .= "<td>" . htmlspecialchars(notaActividad($conn, $currentAlumnoId, $idActivity) ?? '0') . "</td>";
        $tabla .= "</tr>";
    }

    // Cerrar la tabla
    $tabla .= "</tbody></table>";

    // Retornar la tabla completa
    return $tabla;
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