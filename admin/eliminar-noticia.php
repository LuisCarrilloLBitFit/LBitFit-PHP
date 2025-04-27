<?php
include "../includes/db.php";
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    die("Acceso restringido.");
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM noticias WHERE idNoticia = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Noticia eliminada.";
    } else {
        echo "Error: " . $conn->error;
    }
}

header("Location: noticias-administracion.php");
?>
