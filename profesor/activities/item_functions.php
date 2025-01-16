<?php

function addItem($conn, $idActivity, $titulo, $valor, $file) {
    if (empty($titulo) || empty($valor)) {
        return "Título y valor son requeridos.";
    }

    if ($file && $file['error'] == 0) {
        $imgData = mysqli_real_escape_string($conn, file_get_contents($file['tmp_name']));
        $tipus = mysqli_real_escape_string($conn, $file['type']);
    } else {
        $imgData = null;
        $tipus = null;
    }

    $insertQuery = "INSERT INTO items (activity_id, titulo, valor, icon, tipus) 
                    VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, "isiss", $idActivity, $titulo, $valor, $imgData, $tipus);
    
    if (mysqli_stmt_execute($stmt)) {
        return "Item añadido correctamente.";
    } else {
        return "Error al añadir el item: " . mysqli_error($conn);
    }
}

function editItem($conn, $idItem, $titulo, $valor) {
    if (empty($titulo) || empty($valor)) {
        return "Título y valor son requeridos.";
    }

    $updateQuery = "UPDATE items SET titulo = ?, valor = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "sii", $titulo, $valor, $idItem);
    
    if (mysqli_stmt_execute($stmt)) {
        return "Item actualizado correctamente.";
    } else {
        return "Error al actualizar el item: " . mysqli_error($conn);
    }
}

function validateTotalValue($conn, $idActivity) {
    $query = "SELECT SUM(valor) as total FROM items WHERE activity_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $idActivity);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    return $row['total'] == 100;
}

?>