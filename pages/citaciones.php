<<<<<<< HEAD
<?php
session_start();

$role = $_SESSION['role'] ?? 'visitor';
$username = $_SESSION['username'] ?? 'Invitado';
$logged_in = isset($_SESSION['username']);
$user_id = $_SESSION['user_id'] ?? null;

// Restringir acceso a usuarios no logados
if ($role !== 'user' && $role !== 'admin') {
    header("Location: login.php");
    exit();
}

// Verificar que se haya guardado correctamente el ID del usuario
if (!$user_id) {
    echo "Error: No se encontró el ID del usuario en la sesión.";
    exit();
}

include('../sql/conexion.php');

// Procesar solicitud de nueva cita
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nueva_cita'])) {
        $fecha_cita = mysqli_real_escape_string($conexion, $_POST['fecha_cita']);
        $motivo = mysqli_real_escape_string($conexion, $_POST['motivo']);
        $query = "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES ('$user_id', '$fecha_cita', '$motivo')";
        mysqli_query($conexion, $query);
    }

    // Procesar modificación de cita
    if (isset($_POST['editar_cita'])) {
        $idCita = mysqli_real_escape_string($conexion, $_POST['idCita']);
        $fecha_cita = mysqli_real_escape_string($conexion, $_POST['fecha_cita']);
        $motivo = mysqli_real_escape_string($conexion, $_POST['motivo']);
        $query = "UPDATE citas SET fecha_cita = '$fecha_cita', motivo_cita = '$motivo' WHERE idCita = '$idCita' AND idUser = '$user_id' AND fecha_cita >= CURDATE()";
        mysqli_query($conexion, $query);
    }

    // Procesar eliminación de cita
    if (isset($_POST['eliminar_cita'])) {
        $idCita = mysqli_real_escape_string($conexion, $_POST['idCita']);
        $query = "DELETE FROM citas WHERE idCita = '$idCita' AND idUser = '$user_id' AND fecha_cita >= CURDATE()";
        mysqli_query($conexion, $query);
    }
}

// Obtener citas del usuario
$query = "SELECT * FROM citas WHERE idUser = '$user_id' ORDER BY fecha_cita ASC";
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
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Mis citas</title>
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <!--Logo, dentro del menú de navegación-->
            <a href="../index.php" class="brand-logo" id="seccion">LBitFit Dental</a>
            <!--Menú de navegación dentro de un div-->
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <!--ítems menú de navegación-->
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="noticias.php">Noticias</a></li>
                <?php if ($role == 'user' || $role == 'admin'): ?>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="citaciones.php" class="active">Citaciones</a></li>
                <?php endif; ?>
                <?php if ($role == 'admin'): ?>
                <li><a href="usuarios-administracion.php">Usuarios</a></li>
                <li><a href="citas-administracion.php">Administrar Citas</a></li>
                <li><a href="noticias-administracion.php">Noticias (Admin)</a></li>
                <?php endif; ?>
                <?php if ($logged_in): ?>
                <li><a href="../sql/logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                <li><a href="login.php">Iniciar sesión</a></li>
                <li><a href="registro.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <header>
        <h2 class="header-title red-text text-lighten-1">Mis Citas</h2>
    </header>
    <div class="container main1">
        <form action="citaciones.php" method="POST">
            <input type="hidden" name="nueva_cita" value="1">
            <div class="input-field">
                <input type="date" name="fecha_cita" required>
            </div>
            <div class="input-field">
                <input type="text" name="motivo" placeholder="Motivo de la cita" required>
            </div>
            <button type="submit" class="btn red lighten-1">Solicitar cita</button>
        </form>

        <h5 class="red-text text-lighten-1">Citas programadas</h5>
        <table class="striped responsive-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Motivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <form action="citaciones.php" method="POST">
                        <input type="hidden" name="idCita" value="<?= $row['idCita'] ?>">
                        <td>
                            <input type="date" name="fecha_cita" value="<?= $row['fecha_cita'] ?>"
                                <?= ($row['fecha_cita'] < date('Y-m-d')) ? 'readonly' : '' ?>>
                        </td>
                        <td>
                            <input type="text" name="motivo" value="<?= $row['motivo_cita'] ?>"
                                <?= ($row['fecha_cita'] < date('Y-m-d')) ? 'readonly' : '' ?>>
                        </td>
                        <td>
                            <?php if ($row['fecha_cita'] >= date('Y-m-d')): ?>
                            <button class="btn-small blue" type="submit" name="editar_cita">Editar</button>
                            <button class="btn-small red" type="submit" name="eliminar_cita">Eliminar</button>
                            <?php else: ?>
                            <span class="grey-text">Cita pasada</span>
                            <?php endif; ?>
                        </td>
                    </form>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
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

if (!isset($_SESSION["usuario"])) {
    die("Inicia sesión para ver tus citas.");
}

$idUser = $_SESSION["idUser"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["fecha"])) {
    $fecha = $_POST["fecha"];
    $motivo = $_POST["motivo"];

    $sql = "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES ($idUser, '$fecha', '$motivo')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Cita agendada.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM citas WHERE idUser = $idUser ORDER BY fecha_cita DESC";
$result = $conn->query($sql);
?>

<h2>Mis Citas</h2>

<form method="POST">
    <input type="date" name="fecha" required>
    <textarea name="motivo" placeholder="Motivo de la cita" required></textarea>
    <button type="submit">Agendar</button>
</form>

<h3>Citas Agendadas</h3>
<ul>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row["fecha_cita"] . " - " . htmlspecialchars($row["motivo_cita"]) . "</li>";
    }
} else {
    echo "<li>No tienes citas agendadas.</li>";
}
?>
</ul>
>>>>>>> a9a6884e24fa53b71f9b10152b0b7b8b4a6933c8
