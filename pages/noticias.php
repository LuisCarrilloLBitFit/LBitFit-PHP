<<<<<<< HEAD
<?php
session_start();
include '../sql/conexion.php';

// Inicializo $logged_in y $role
$logged_in = isset($_SESSION['username']);
$role = $_SESSION['role'] ?? 'visitor';

// Verifico si el usuario está logueado
if (isset($_SESSION['idUser']) && $_SESSION['idUser'] !== null) {
    $logged_in = true;
    // Asigno el rol si está disponible en la sesión
    if (isset($_SESSION['role'])) {
        $role = $_SESSION['role'];
    }
}

$query = "SELECT noticias.*, users_data.nombre FROM noticias 
          JOIN users_data ON noticias.idUser = users_data.idUser
          ORDER BY fecha DESC";
$result = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- Librerías -->
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- Iconos (Font Awesome) -->
    <script src="https://kit.fontawesome.com/a9890f8bd0.js" crossorigin="anonymous"></script>
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Noticias</title>
</head>

<body>
    <nav>
        <?php
            //error_reporting(0);
        ?>
        <div class="nav-wrapper">
            <!--Logo, dentro del menú de navegación-->
            <a href="../index.php" class="brand-logo" id="seccion">LBitFit Dental</a>
            <!--Menú de navegación dentro de un div-->
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <!--ítems menú de navegación-->
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="noticias.php" class="active">Noticias</a></li>
                <?php if ($role == 'user' || $role == 'admin'): ?>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="citaciones.php">Citaciones</a></li>
                <?php endif; ?>
                <?php if ($role == 'admin'): ?>
                <li><a href="usuarios-administracion.php">Usuarios</a></li>
                <li><a href="citas-administracion.php">Administrar Citas</a></li>
                <li><a href="noticias-administracion.php">Noticias (Admin)</a></li>
                <?php endif; ?>
                <?php if ($logged_in): ?>
                <li><a href="../sql/logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                <li><a href="../sql/login.php">Iniciar sesión</a></li>
                <li><a href="../sql/registro.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main>
        <div>
            <h2 class="red-text text-lighten-1">Noticias</h2>
        </div>
        <div class="box-news">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                <i class="fa-regular fa-newspaper"></i>
                <h3 class="red-text text-lighten-1"><?php echo htmlspecialchars($row['titulo']); ?></h3>
                <p><strong>Publicado por:</strong> <?php echo htmlspecialchars($row['nombre']); ?> el
                    <?php echo $row['fecha']; ?></p>
                <p><?php echo nl2br(htmlspecialchars($row['texto'])); ?></p>
            </div>
            <?php endwhile; ?>
        </div>
    </main>
    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">Contacto</h5>
                    <p class="grey-text text-lighten-4">Plaza de Azucena, Leganés - Madrid</p>
                    <p class="grey-text text-lighten-4">Email: lbitfititstore@gmail.com</p>
                    <p>Telefono 624 37 60 29</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Condiciones de uso y Políticas</h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="#!">Condiciones de uso</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Políticas de privacidad</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Políticas de envios</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Trabaja con nosotros</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © 2025 Copyright LBitFit IT
                <a class="grey-text text-lighten-4 right" href="#seccion">Ir arriba ↑</a>
            </div>
        </div>
    </footer>
</body>

</html>
=======
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
>>>>>>> a9a6884e24fa53b71f9b10152b0b7b8b4a6933c8
