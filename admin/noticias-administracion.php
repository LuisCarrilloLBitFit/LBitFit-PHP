<<<<<<< HEAD
<?php
session_start();

$role = $_SESSION['role'] ?? 'visitor';
$username = $_SESSION['username'] ?? 'Invitado';
$logged_in = isset($_SESSION['username']);

if ($role != 'admin') {
    header('Location: login.php');
    exit();
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Crear nueva noticia
    $titulo = $_POST['titulo'];
    $texto = $_POST['texto'];
    $fecha = date('Y-m-d');
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO noticias (titulo, texto, fecha, idUser) VALUES ('$titulo', '$texto', '$fecha', '$user_id')";
    if (mysqli_query($conexion, $query)) {
        echo "Noticia publicada correctamente.";
        header('Location: noticias-administracion.php');
        exit;
    } else {
        echo "Error al publicar la noticia.";
        header('Location: noticias-administracion.php');
        exit;
    }
}

$query = "SELECT * FROM noticias";
$result = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administración de Noticias</title>
</head>

<body>
    <h2 class="header-title red-text text-lighten-1">Administración de Noticias</h2>

    <h3 class="header-title red-text text-lighten-1">Crear nueva noticia</h3>
    <form action="noticias-administracion.php" method="POST">
        <input type="text" name="titulo" placeholder="Título de la noticia" required>
        <textarea name="texto" placeholder="Texto de la noticia" required></textarea>
        <button type="submit">Publicar noticia</button>
    </form>

    <h2>Noticias publicadas</h2>
    <table>
        <tr>
            <th>Título</th>
            <th>Fecha</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['titulo']; ?></td>
            <td><?php echo $row['fecha']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
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
>>>>>>> a9a6884e24fa53b71f9b10152b0b7b8b4a6933c8
