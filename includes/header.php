<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);

$logged_in = isset($_SESSION['idUser']) && $_SESSION['idUser'] !== null;
$role = $_SESSION['rol'] ?? 'visitor'; // 'visitor' si el rol no está definido.
$username = $_SESSION['username'] ?? 'Invitado'; // 'Invitado' si el nombre de usuario no está definido.
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Librerías Materialize CSS y JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- Iconos (Font Awesome) -->
    <script src="https://kit.fontawesome.com/a9890f8bd0.js" crossorigin="anonymous"></script>
    <!-- Estilos CSS -->
    <!-- La ruta 'assets/css/styles.css' es relativa al directorio raíz del proyecto para páginas en 'sql/' o 'pages/' -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title><?php echo $pageTitle ?? 'LBitFit Dental'; ?></title> <!-- Título dinámico para la página -->
</head>

<body>
    <nav>
        <div class="nav-wrapper red lighten-1">
            <!-- Logo y enlace al inicio -->
            <a href="../index.php" class="brand-logo" id="seccion">LBitFit Dental</a>
            <!-- Menú de navegación principal -->
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../pages/noticias.php">Noticias</a></li>
                <?php if ($role == 'user' || $role == 'admin'): ?>
                <li><a href="../pages/perfil.php">Perfil</a></li>
                <li><a href="../pages/citaciones.php">Citaciones</a></li>
                <?php endif; ?>
                <?php if ($role == 'admin'): ?>
                <li><a href="../admin/usuarios-administracion.php">Usuarios</a></li>
                <li><a href="../admin/citas-administracion.php">Administrar Citas</a></li>
                <li><a href="../admin/noticias-administracion.php">Noticias (Admin)</a></li>
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
    </header>

    <main>
    </main>
</body>
</html>