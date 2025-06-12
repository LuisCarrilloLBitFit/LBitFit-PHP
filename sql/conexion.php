<?php
$conexion = mysqli_connect("localhost", "root", "", "clinica_salud_integral");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
