<?php
require_once 'includes/db.php';

// Prueba de conexión
$result = $conn->query("SHOW TABLES");
if ($result) {
    echo "¡Conexión exitosa! Tablas encontradas:<br>";
    while ($row = $result->fetch_row()) {
        echo "- " . $row[0] . "<br>";
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>