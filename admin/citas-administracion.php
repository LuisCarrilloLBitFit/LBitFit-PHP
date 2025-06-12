<<<<<<< HEAD
<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Crear nueva cita para un usuario
    $user_id = $_POST['user_id'];
    $fecha_cita = $_POST['fecha_cita'];
    $motivo = $_POST['motivo'];

    $query = "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES ('$user_id', '$fecha_cita', '$motivo')";
    if (mysqli_query($conexion, $query)) {
        echo "Cita creada correctamente.";
    } else {
        echo "Error al crear la cita.";
    }
}

$query = "SELECT * FROM citas";
$result = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administración de Citas</title>
</head>

<body>
    <h2 class="header-title red-text text-lighten-1">Administración de Citas</h2>

    <h3 class="header-title red-text text-lighten-1">Crear nueva cita</h3>
    <form action="citas-administracion.php" method="POST">
        <select name="user_id">
            <?php
            // Mostrar usuarios
            $users_query = "SELECT * FROM users_data";
            $users_result = mysqli_query($conexion, $users_query);
            while ($user = mysqli_fetch_assoc($users_result)): ?>
            <option value="<?php echo $user['idUser']; ?>"><?php echo $user['nombre']; ?></option>
            <?php endwhile; ?>
        </select>
        <input type="date" name="fecha_cita" required>
        <input type="text" name="motivo" placeholder="Motivo de la cita" required>
        <button type="submit">Crear cita</button>
    </form>

    <h2>Citas programadas</h2>
    <table>
        <tr>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Motivo</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['idUser']; ?></td>
            <td><?php echo $row['fecha_cita']; ?></td>
            <td><?php echo $row['motivo_cita']; ?></td>
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

$sql = "SELECT c.idCita, c.fecha_cita, c.motivo_cita, u.nombre, u.apellidos 
        FROM citas c
        JOIN users_data u ON c.idUser = u.idUser
        ORDER BY c.fecha_cita DESC";

$result = $conn->query($sql);
?>

<h2>Administración de Citas</h2>

<ul>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row["fecha_cita"] . " - " . $row["nombre"] . " " . $row["apellidos"] . " - " . htmlspecialchars($row["motivo_cita"]) . " <a href='eliminar-cita.php?id=" . $row["idCita"] . "'>Eliminar</a></li>";
    }
} else {
    echo "<li>No hay citas agendadas.</li>";
}
?>
</ul>
>>>>>>> a9a6884e24fa53b71f9b10152b0b7b8b4a6933c8
