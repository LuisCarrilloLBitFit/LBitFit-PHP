<?php
session_start();

$role = $_SESSION['role'] ?? 'visitor'; 
$logged_in = isset($_SESSION['username']);

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Mostrar datos del perfil (básico)
$usuario = $_SESSION['username'];

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
    <title>Perfil</title>
</head>
<body>
    <nav>
        <?php
            //error_reporting(0);
        ?>
        <div class="nav-wrapper">
            <!--Logo, dentro del menú de navegación-->
            <a href="index.php" class="brand-logo" id="seccion">LBitFit Dental</a>
            <!--Menú de navegación dentro de un div-->
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <!--ítems menú de navegación-->
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="noticias.php">Noticias</a></li>
                <?php if ($role == 'user' || $role == 'admin'): ?>
                <li><a href="perfil.php" class="active">Perfil</a></li>
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
                <li><a href="login.php">Iniciar sesión</a></li>
                <li><a href="registro.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <header>
    </header>
    <div class="main">
    <h2 class="header-title red-text text-lighten-1">Bienvenido, <?php echo htmlspecialchars($usuario); ?></h2>
    <p>Aquí puedes ver o modificar tus datos.</p>
    <form action="perfil.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre del Usuario" required>
        <input type="password" name="new_password" placeholder="Nueva contraseña">
                <button type="submit" class="waves-effect red lighten-1 btn-large btn-reg">Guardar cambios</button>
    </form>
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
