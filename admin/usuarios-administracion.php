<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Crear nuevo usuario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $query = "INSERT INTO users_data (nombre, email) VALUES ('$nombre', '$email')";
    if (mysqli_query($conexion, $query)) {
        $user_id = mysqli_insert_id($conexion);
        $query = "INSERT INTO users_login (idUser, usuario, password, rol) VALUES ('$user_id', '$email', '$password', '$role')";
        if (mysqli_query($conexion, $query)) {
            echo "Usuario creado correctamente.";
        }
    } else {
        echo "Error al crear el usuario.";
    }
}

$query = "SELECT * FROM users_data";
$result = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administración de Usuarios</title>
</head>

<body>
    <h2 class="header-title red-text text-lighten-1">Administración de Usuarios</h2>

    <h3 class="header-title red-text text-lighten-1">Crear nuevo usuario</h3>
    <form action="usuarios-administracion.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <select name="role">
            <option value="user">Usuario</option>
            <option value="admin">Administrador</option>
        </select>
        <button type="submit">Crear usuario</button>
    </form>

    <h2>Usuarios registrados</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['rol']; ?></td>
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