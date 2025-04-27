<?php
include "../includes/db.php";
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    die("Acceso restringido.");
}

// Agregar noticia
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["titulo"])) {
    $titulo = $_POST["titulo"];
    $texto = $_POST["texto"];
    $imagen = "default.jpg"; // Por ahora usamos una imagen por defecto
    $idUser = 1; // Suponiendo que el administrador tiene ID 1

    $sql = "INSERT INTO noticias (titulo, imagen, texto, fecha, idUser) VALUES ('$titulo', '$imagen', '$texto', NOW(), $idUser)";
    
    if ($conn->query($sql) === TRUE) {
        echo "Noticia agregada.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Mostrar noticias
$sql = "SELECT * FROM noticias ORDER BY fecha DESC";
$result = $conn->query($sql);
?>

<h2>Administración de Noticias</h2>

<form method="POST">
    <input type="text" name="titulo" placeholder="Título" required>
    <textarea name="texto" placeholder="Contenido de la noticia" required></textarea>
    <button type="submit">Publicar</button>
</form>

<h3>Noticias Publicadas</h3>
<ul>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($row["titulo"]) . " <a href='eliminar-noticia.php?id=" . $row["idNoticia"] . "'>Eliminar</a></li>";
    }
} else {
    echo "<li>No hay noticias.</li>";
}
?>
</ul>
