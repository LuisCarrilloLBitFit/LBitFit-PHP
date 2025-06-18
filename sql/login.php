<?php
ob_start();
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../includes/db.php';



// Inicializar variables para la navegación
$role = $_SESSION['role'] ?? 'visitor';
$username = $_SESSION['username'] ?? 'Invitado';
$logged_in = isset($_SESSION['username']);
$error_message = ''; // Variable para almacenar mensajes de error de inicio de sesión.



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conexión a base de datos y verificación de usuario
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($usuario) || empty($password)) {
        $error_message = "Por favor, ingresa tu usuario y contraseña.";
    } else {
        $stmt = $conn->prepare("SELECT idUser, usuario, password, rol FROM users_login WHERE usuario = ? LIMIT 1");

        if ($stmt === false) {
            $error_message = "Error interno del servidor al preparar la consulta de login.";
        } else {
            $stmt->bind_param("s", $usuario); 
            $stmt->execute(); 
            $result = $stmt->get_result(); 
            $user = $result->fetch_assoc(); 
            $stmt->close(); 



     // Verificar si se encontró un usuario y si la contraseña es correcta.
            if ($user && password_verify($password, $user['password'])) {
                // Inicio de sesión exitoso.
                // Guardar la información del usuario en la sesión.
                $_SESSION['rol'] = $user['rol'];
                $_SESSION['idUser'] = $user['idUser']; // Guarda el ID del usuario.
                $_SESSION['username'] = $user['usuario']; // Guarda el nombre de usuario.

                // Redirigir al usuario a la página de inicio.
                header('Location: ../index.php');
                exit; // Terminar el script después de la redirección.
            } else {
                // Usuario no encontrado o contraseña incorrecta.
                $error_message = "Usuario o contraseña incorrectos.";
            }
        }
    }
}
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
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Iniciar sesión</title>
</head>

<body>
    <nav>
        <div class="nav-wrapper red lighten-1">
            <!-- Logo y menú de navegación -->
            <a href="../index.php" class="brand-logo" id="seccion">LBitFit Dental</a>
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
                <?php if (!empty($error_message)): ?>
                    <div class='card-panel red lighten-4 red-text text-darken-4'>
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons fa-regular fa-circle-user prefix"></i>
                        <input class="validate" id="usuario" type="text" name="usuario" required>
                        <label for="usuario">Usuario</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons fa-regular fa-key prefix"></i>
                        <input id="password" type="password" name="password" required>
                        <label for="password">Contraseña</label>
                    </div>
                </div>
                <button type="submit" class="waves-effect red lighten-1 btn-large">Iniciar sesión</button>
            </form>
        </div>
    </main>
    <footer class="page-footer red lighten-1">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Materialize labels often need to be "activated" if the input field has a value
            // or is pre-filled. This ensures the labels float correctly.
            M.updateTextFields();
        });
    </script>
</body>

</html>
<?php ob_end_flush(); // Finalizar el buffer de salida. ?>