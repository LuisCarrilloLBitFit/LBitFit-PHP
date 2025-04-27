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
