<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$password = "";
$database = "clinica_salud_integral";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


if (!$conn->set_charset("utf8mb4")) {
     die("Error al cargar el conjunto de caracteres utf8mb4: " . $conn->error);
}
?>

