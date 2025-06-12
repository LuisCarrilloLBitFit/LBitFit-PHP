<<<<<<< HEAD
<?php
session_start();
$logged_in = isset($_SESSION['idUser']);
$role = $_SESSION['rol'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conexion.php';

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = 'user';

    // Comprobar si el email ya está registrado
    $check_query = "SELECT idUser FROM users_data WHERE email = '$email'";
    $result = mysqli_query($conexion, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Ya existe un usuario con ese email
        $mensaje = "<div class='card-panel red lighten-4 red-text text-darken-4'>
                        El correo ya está registrado. <a href='login.php'>Inicia sesión</a> o <a href='index.php'>volver al inicio</a>.
                    </div>";
    } else {
        // Insertar en users_data
        $query1 = "INSERT INTO users_data (nombre, email) VALUES ('$nombre', '$email')";
        if (mysqli_query($conexion, $query1)) {
            $user_id = mysqli_insert_id($conexion);

            // Insertar en users_login con rol 'user'
            $query2 = "INSERT INTO users_login (idUser, usuario, password, rol) VALUES ('$user_id', '$email', '$password', '$rol')";
            if (mysqli_query($conexion, $query2)) {
                // Éxito: Redirigir al login después de 3 segundos
                echo "<div class='card-panel green lighten-4 green-text text-darken-4'>
                        Registro exitoso. Serás redirigido al <a href='login.php'>login</a> en unos segundos...
                      </div>";
                echo "<script>
                        setTimeout(function(){
                            window.location.href = 'login.php';
                        }, 3000);
                      </script>";
                exit;
            } else {
                $mensaje = "<div class='card-panel red lighten-4 red-text text-darken-4'>
                                Error al registrar el usuario en el sistema.
                            </div>";
            }
        } else {
            $mensaje = "<div class='card-panel red lighten-4 red-text text-darken-4'>
                            Error al guardar tus datos personales.
                        </div>";
        }
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
    <!-- Enlace a CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Registro</title>
</head>

<body>
    <nav>
        <?php
            //error_reporting(0);
        ?>
        <div class="nav-wrapper">
            <!--Logo, dentro del menú de navegación-->
            <a href="../index.php" class="brand-logo" id="seccion">LBitFit Dental</a>
            <!--Menú de navegación dentro de un div-->
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <!--ítems menú de navegación-->
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../pages/noticias.php">Noticias</a></li>
                <?php if ($role == 'user' || $role == 'admin'): ?>
                <li><a href="pages/perfil.php">Perfil</a></li>
                <li><a href="pages/citaciones.php">Citaciones</a></li>
                <?php endif; ?>
                <?php if ($role == 'admin'): ?>
                <li><a href="pages/usuarios-administracion.php">Usuarios</a></li>
                <li><a href="pages/noticias-administracion.php">Noticias (Admin)</a></li>
                <?php endif; ?>
                <?php if ($logged_in): ?>
                <li><a href="logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                <li><a href="login.php">Iniciar sesión</a></li>
                <li><a href="registro.php" class="active">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main class="main">
        <div class="title-main">
            <h2 class="red-text text-lighten-1">Registro</h2>
        </div>
        <div class="formu-main">
            <form action="registro.php" method="POST">
                <?php if (isset($mensaje)) echo $mensaje; ?>
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit" class="waves-effect red lighten-1 btn-large btn-reg">Registrarse</button>
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

</html>
=======
<?php
include "includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $email = $_POST["email"];
    $usuario = $_POST["usuario"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Insertar en users_data
    $sql = "INSERT INTO users_data (nombre, apellidos, email) VALUES ('$nombre', '$apellidos', '$email')";
    
    if ($conn->query($sql) === TRUE) {
        $idUser = $conn->insert_id;
        
        // Insertar en users_login
        $sql2 = "INSERT INTO users_login (idUser, usuario, password, rol) VALUES ($idUser, '$usuario', '$password', 'user')";
        
        if ($conn->query($sql2) === TRUE) {
            echo "Registro exitoso. Redirigiendo...";
            header("Refresh:2; url=login.php");
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="apellidos" placeholder="Apellidos" required>
    <input type="email" name="email" placeholder="Correo electrónico" required>
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Registrarse</button>
</form>
>>>>>>> a9a6884e24fa53b71f9b10152b0b7b8b4a6933c8
