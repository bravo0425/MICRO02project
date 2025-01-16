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
        
        // Verificar que la imagen y el tipo están presentes
        if (!empty($fila['icon']) && !empty($fila['tipus'])) {
            echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['icon']) . "' alt='Icono'>";
        } else {
            echo "<p>NoIMG</p>"; // En caso de que no haya imagen
        }
    } else {
        echo "<p>NoIMG</p>"; // En caso de que no se encuentre el item
    }
}

function addItem($conn, $idActivity, $titulo, $valor, $file) {
    if ($file && $file['error'] == 0) {
        $imgData = mysqli_real_escape_string($conn, file_get_contents($file['tmp_name']));
        $tipus = mysqli_real_escape_string($conn, $file['type']);
    } else {
        $imgData = null;
        $tipus = null;
    }

    $titulo = mysqli_real_escape_string($conn, $titulo);
    $valor = mysqli_real_escape_string($conn, $valor);

    if (empty($titulo) || empty($valor)) {
        return "Error: Título y valor son obligatorios.";
    }

    $insertQuery = "INSERT INTO items (activity_id, titulo, valor, icon, tipus) 
                    VALUES ('$idActivity', '$titulo', '$valor', '$imgData', '$tipus')";
    if (mysqli_query($conn, $insertQuery)) {
        return "";
    } else {
        return "Error al insertar el ítem: " . mysqli_error($conn);
    }
}

function editItem($conn, $idItem, $titulo, $valor) {
    $titulo = mysqli_real_escape_string($conn, $titulo);
    $valor = mysqli_real_escape_string($conn, $valor);

    if (empty($titulo) || empty($valor)) {
        return "Error: Título y valor son obligatorios.";
    }

    $updateQuery = "UPDATE items SET titulo = '$titulo', valor = '$valor' WHERE id = $idItem";
    if (mysqli_query($conn, $updateQuery)) {
        return "";
    } else {
        return "Error al actualizar el ítem: " . mysqli_error($conn);
    }
}

function validateTotalValue($conn, $idActivity) {
    $query = "SELECT SUM(valor) AS total_valor FROM items WHERE activity_id = $idActivity";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_valor'] == 100;
    } else {
        return false; // Error al consultar la base de datos
    }
}


function añadirItem($conn, $idActivity) {
    $tituloItems = $_POST['titulo'] ?? [];
    $valorItems = $_POST['valor'] ?? [];
    $idItems = $_POST['idItem'] ?? [];
    
    $nuevoTitulo = $_POST['tituloNewItem'] ?? null;
    $nuevoValor = $_POST['valorNewItem'] ?? null; 
    $file = $_FILES['imgIcon'] ?? null;

    // Update existing items
    foreach ($idItems as $index => $idItem) {
        $result = editItem($conn, $idItem, $tituloItems[$index], $valorItems[$index]);
        if (strpos($result, "Error") !== false) {
            echo $result;
            return;
        }
    }

    // Add new item if provided
    if (!empty($nuevoTitulo) && !empty($nuevoValor)) {
        $result = addItem($conn, $idActivity, $nuevoTitulo, $nuevoValor, $file);
        if (strpos($result, "Error") !== false) {
            echo $result;
            return;
        }
    }

    // Validate total value
    if (!validateTotalValue($conn, $idActivity)) {
        echo "La suma total de los porcentajes debe ser exactamente 100%.";
        return;
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}



function mostrarItems($conn, $idActivity) {
    $serachItems = "SELECT * FROM items WHERE activity_id = $idActivity";
    $rI = mysqli_query($conn, $serachItems);

    if ($rI && mysqli_num_rows($rI) > 0) {
        while ($fila = mysqli_fetch_assoc($rI)) {
            $idItem = $fila['id'];
            $titulo = $fila['titulo'];
            $valor = $fila['valor'];
            $icon = $fila['tipus'];

            echo '<div class="item">';
                echo '<input type="hidden" name="idItem[]" value="' . $idItem . '">';
                echo mostrarIcon($conn, $idItem);

                
                echo '<label for="titulo_' . $idItem . '">Título:</label>';
                echo '<input type="text" id="titulo_' . $idItem . '" name="titulo[]" value="' . htmlspecialchars($titulo) . '">';
                
                echo '<label for="valor_' . $idItem . '">Valor:</label>';
                echo '<select name="valor[]" id="valor_' . $idItem . '">';
                    for ($i = 10; $i <= 100; $i += 10) {
                        if ($valor == $i) {
                            $selected = 'selected';
                        } else {
                            $selected = '';
                        }
                        
                        echo '<option value="' . $i . '" ' . $selected . '>' . $i . '%</option>';
                    }
                echo '</select>';
            echo '</div>';
        }
    } else {
        echo "No se encontraron ítems para esta actividad.";
    }
}





?>