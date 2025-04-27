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
