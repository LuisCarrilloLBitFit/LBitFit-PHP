<?php
include "../includes/db.php"; // Conexión a la base de datos
include "../includes/header.php"; // Encabezado común
?>

<h2>Noticias</h2>

<?php
$sql = "SELECT * FROM noticias ORDER BY fecha DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='noticia'>";
        echo "<h3>" . htmlspecialchars($row["titulo"]) . "</h3>";
        echo "<img src='../assets/" . htmlspecialchars($row["imagen"]) . "' alt='Imagen de noticia'>";
        echo "<p>" . nl2br(htmlspecialchars($row["texto"])) . "</p>";
        echo "<p><small>Publicado el " . $row["fecha"] . "</small></p>";
        echo "</div>";
    }
} else {
    echo "<p>No hay noticias disponibles.</p>";
}
?>

<?php include "../includes/footer.php"; // Pie de página ?>
