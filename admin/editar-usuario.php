<?php
require_once '../includes/header.php';
require_once '../includes/auth.php';
require_admin();

require_once '../includes/db.php';

$idUsuario = $_GET['id'] ?? 0;

// Obtener datos del usuario
$stmt = $conn->prepare("SELECT ud.*, ul.usuario, ul.rol 
                       FROM users_data ud
                       JOIN users_login ul ON ud.idUser = ul.idUser
                       WHERE ud.idUser = ?");
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación y actualización
}
?>

<main>
    <h1>Editar Usuario: <?= htmlspecialchars($usuario['nombre']) ?></h1>

    <form action="editar-usuario.php?id=<?= $idUsuario ?>" method="post">
        <!-- Formulario similar al de creación pero con valores actuales -->
        <input type="hidden" name="idUser" value="<?= $idUsuario ?>">

        <div class="form-group">
            <label for="usuario">Nombre de usuario</label>
            <input type="text" id="usuario" name="usuario" value="<?= htmlspecialchars($usuario['usuario']) ?>"
                readonly>
        </div>

        <div class="form-group">
            <label for="rol">Rol</label>
            <select id="rol" name="rol" required>
                <option value="user" <?= $usuario['rol'] === 'user' ? 'selected' : '' ?>>Usuario</option>
                <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
            </select>
        </div>

        <!-- Resto de campos del formulario -->

        <button type="submit" class="btn">Actualizar Usuario</button>
    </form>
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

<?php require_once '../includes/footer.php'; ?>