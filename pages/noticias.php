<?php
error_reporting(E_ALL);

include_once '../includes/db.php';

// Establecer el título de la página antes de incluir el header.
$pageTitle = "Noticias - LBitFit Dental";
// Incluir el encabezado común de la página.
include_once '../includes/header.php';

// Lógica para obtener las noticias de la base de datos.
$query = "SELECT n.titulo, n.texto, n.fecha, n.imagen, ud.nombre 
          FROM noticias n
          JOIN users_data ud ON n.idUser = ud.idUser
          ORDER BY n.fecha DESC";

$stmt = $conn->prepare($query);
if ($stmt === false) {
    echo "<p class='card-panel red lighten-4 red-text text-darken-4'>Error al preparar la consulta de noticias: " . htmlspecialchars($conn->error) . "</p>";
    $result = false; 
} else {
    $stmt->execute();
    $result = $stmt->get_result(); // Obtener el resultado de la consulta.
}
?>
<main>
    <div class="title-main">
        <h2 class="red-text text-lighten-1">Noticias</h2>
    </div>
    <div class="container"> 
        <div class="row">
            <?php 
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()): 
            ?>
                <div class="col s12 m6 l4"> 
                    <div class="card sticky-action"> <!-- Card para cada noticia -->
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="../assets/img/<?php echo htmlspecialchars($row['imagen']); ?>" 
                                 alt="<?php echo htmlspecialchars($row['titulo']); ?>" 
                                 onerror="this.onerror=null; this.src='https://placehold.co/600x400/CCCCCC/FFFFFF?text=No+Imagen';">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4">
                                <?php echo htmlspecialchars($row['titulo']); ?>
                                <i class="material-icons right">more_vert</i>
                            </span>
                            <p><small>Publicado por: <?php echo htmlspecialchars($row['nombre']); ?> el <?php echo htmlspecialchars($row['fecha']); ?></small></p>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">
                                <?php echo htmlspecialchars($row['titulo']); ?>
                                <i class="material-icons right">close</i>
                            </span>
                            <p><?php echo nl2br(htmlspecialchars($row['texto'])); ?></p>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile;
                $stmt->close(); // Cerrar la sentencia preparada
            } else {
                echo "<p class='col s12'>No hay noticias disponibles.</p>";
            }
            ?>
        </div>
    </div>
</main>

<?php
// Incluir el pie de página común.
include_once '../includes/footer.php';
?>
