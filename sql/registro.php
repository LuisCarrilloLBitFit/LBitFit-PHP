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
