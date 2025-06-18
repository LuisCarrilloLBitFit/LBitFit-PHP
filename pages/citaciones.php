<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir la conexión a la base de datos.
include_once '../includes/db.php';

$pageTitle = "Mis Citaciones - LBitFit Dental";

// Incluir el encabezado común de la página.
include_once '../includes/header.php';

$user_id = $_SESSION['idUser'] ?? null;
$citas = []; // Array para almacenar los resultados de las citaciones

if ($user_id) { 
    $sql_citas = "SELECT idCita, fecha_cita, motivo_cita, especialidad, estado, notas, fecha_creacion
                  FROM citas
                  WHERE idUser = ?
                  ORDER BY fecha_cita DESC";
    $stmt_citas = $conn->prepare($sql_citas);


   if ($stmt_citas) {
        $stmt_citas->bind_param("i", $user_id); // 'i' para integer
        $stmt_citas->execute();
        $result_citas = $stmt_citas->get_result();

        while ($row = $result_citas->fetch_assoc()) {
            $citas[] = $row;
        }
        $stmt_citas->close();
    } else {
        echo "<p class='card-panel red lighten-4 red-text text-darken-4'>Error al preparar la consulta de citas: " . htmlspecialchars($conn->error) . "</p>";
    }
} else {
    echo "<p class='card-panel orange lighten-4 orange-text text-darken-4'>Debes iniciar sesión para ver tus citas.</p>";
}

?>

<main>
    <div class="container">
        <h2 class="red-text text-lighten-1 center-align">Mis Citas</h2>

        <?php if (!empty($citas)): ?>
            <div class="row">
                <?php foreach ($citas as $cita): ?>
                    <div class="col s12 m6 l4">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title activator grey-text text-darken-4">
                                    Cita para el: <?php echo htmlspecialchars(date('d/m/Y', strtotime($cita['fecha_cita']))); ?>
                                    <i class="material-icons right">more_vert</i>
                                </span>
                                <p>Hora: <?php echo htmlspecialchars(date('H:i', strtotime($cita['fecha_cita']))); ?></p>
                                <p>Motivo: <?php echo htmlspecialchars($cita['motivo_cita']); ?></p>
                                <p>Especialidad: <?php echo htmlspecialchars($cita['especialidad']); ?></p>
                                <p>Estado: **<?php echo htmlspecialchars(ucfirst($cita['estado'])); ?>**</p>
                            </div>
                            <div class="card-reveal">
                                <span class="card-title grey-text text-darken-4">
                                    Detalles de la Cita<i class="material-icons right">close</i>
                                </span>
                                <p>Fecha: <?php echo htmlspecialchars(date('d/m/Y', strtotime($cita['fecha_cita']))); ?></p>
                                <p>Hora: <?php echo htmlspecialchars(date('H:i', strtotime($cita['fecha_cita']))); ?></p>
                                <p>Motivo: <?php echo htmlspecialchars($cita['motivo_cita']); ?></p>
                                <p>Especialidad: <?php echo htmlspecialchars($cita['especialidad']); ?></p>
                                <p>Estado: **<?php echo htmlspecialchars(ucfirst($cita['estado'])); ?>**</p>
                                <p>Notas: <?php echo nl2br(htmlspecialchars($cita['notas'] ?? 'No hay notas.')); ?></p>
                                <p><small>Creada el: <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($cita['fecha_creacion']))); ?></small></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="center-align">No tienes citas programadas en este momento.</p>
        <?php endif; ?>
    </div>
</main>

<?php
// Incluir el pie de página común.
include_once '../includes/footer.php';
?>
