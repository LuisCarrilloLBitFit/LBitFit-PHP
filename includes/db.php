<<<<<<< HEAD
<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "mi_sitio_web";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
=======
<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "mi_sitio_web";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
>>>>>>> a9a6884e24fa53b71f9b10152b0b7b8b4a6933c8
