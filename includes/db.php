<?php
error_reporting(0);
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
