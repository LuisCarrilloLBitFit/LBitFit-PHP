<<<<<<< HEAD
<?php
ob_start();
session_start();

// Inicializar variables para la navegación
$role = $_SESSION['role'] ?? 'visitor';
$username = $_SESSION['username'] ?? 'Invitado';
$logged_in = isset($_SESSION['username']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conexión a base de datos y verificación de usuario
    include 'conexion.php';
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Escapar las entradas para prevenir inyecciones SQL
    $usuario = mysqli_real_escape_string($conexion, $usuario);
    
    // Verificar en la base de datos
    $query = "SELECT * FROM users_login WHERE usuario = '$usuario' LIMIT 1";
    $result = mysqli_query($conexion, $query);
    $user = mysqli_fetch_assoc($result);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['role'] = $user['rol'];
        $_SESSION['user_id'] = $user['idUser'];
        $_SESSION['username'] = $usuario;
        header('Location: ../index.php');
        exit;
    } else {
        echo "Credenciales incorrectas.";
    }
}
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
    <title>Iniciar sesión</title>
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
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../pages/noticias.php">Noticias</a></li>
                <?php if ($role == 'user' || $role == 'admin'): ?>
                <li><a href="../pages/perfil.php">Perfil</a></li>
                <li><a href="../pages/citaciones.php">Citaciones</a></li>
                <?php endif; ?>
                <?php if ($role == 'admin'): ?>
                <li><a href="../admin/usuarios-administracion.php">Usuarios</a></li>
                <li><a href="../admin/noticias-administracion.php">Noticias (Admin)</a></li>
                <?php endif; ?>
                <?php if ($logged_in): ?>
                <li><a href="logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                <li><a href="login.php" class="active">Iniciar sesión</a></li>
                <li><a href="registro.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main class="main">
        <h2 class="red-text text-lighten-1">Iniciar sesión</h2>
        <div class="row caja-form">
            <form action="login.php" method="POST" class="col s12">
                <div class="row">
                    <div class="input-field col s6">
                        <i class="fa-regular fa-circle-user"></i>
                        <input class="validate" id="icon_prefix" type="text" name="usuario" placeholder="Usuario"
                            required>
                    </div>
                    <div class="input-field col s6">
                        <i class="fa-regular fa-key"></i>
                        <input type="password" name="password" placeholder="Contraseña" required>
                    </div>
                </div>
                <button type="submit" class="waves-effect red lighten-1 btn-large">Iniciar sesión</button>
            </form>
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
<?php ob_end_flush(); ?>
</html>
=======
<?php
include "includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users_login WHERE usuario='$usuario'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["usuario"] = $row["usuario"];
            $_SESSION["rol"] = $row["rol"];
            header("Location: index.php");
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
?>
>>>>>>> a9a6884e24fa53b71f9b10152b0b7b8b4a6933c8
