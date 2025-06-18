<?php
session_start();

include_once '../includes/db.php';

$logged_in = isset($_SESSION['idUser']);
$role = $_SESSION['rol'] ?? null;
$mensaje = ''; // Variable de mensaje para mostrar al usuario.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''));
    $apellidos = htmlspecialchars(trim($_POST['apellidos'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $telefono = htmlspecialchars(trim($_POST['telefono'] ?? ''));
    $fecha_nacimiento = htmlspecialchars(trim($_POST['fecha_nacimiento'] ?? ''));
    $direccion = htmlspecialchars(trim($_POST['direccion'] ?? ''));
    $sexo = htmlspecialchars(trim($_POST['sexo'] ?? ''));

    // Datos de inicio de sesión.
    $usuario = htmlspecialchars(trim($_POST['usuario'] ?? ''));
    $password_plain = $_POST['password'] ?? ''; 
    $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT); // Hashear la contraseña.
    $rol = 'user'; // Rol por defecto para nuevos registros.

    if (empty($nombre) || empty($apellidos) || empty($email) || empty($telefono) || 
        empty($fecha_nacimiento) || empty($sexo) || empty($usuario) || empty($password_plain)) {
        $mensaje = "<div class='card-panel red lighten-4 red-text text-darken-4'>
                        Por favor, rellena todos los campos obligatorios.
                    </div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "<div class='card-panel red lighten-4 red-text text-darken-4'>
                        El formato del correo electrónico no es válido.
                    </div>";
    } elseif (strlen($password_plain) < 6) { 
        $mensaje = "<div class='card-panel red lighten-4 red-text text-darken-4'>
                        La contraseña debe tener al menos 6 caracteres.
                    </div>";
    } else {
        // Iniciar una transacción para asegurar la atomicidad de las operaciones.
        $conn->begin_transaction();

        try {
            // Comprobar si el email o el usuario ya están registrados.
            $stmt_check_email = $conn->prepare("SELECT idUser FROM users_data WHERE email = ?");
            $stmt_check_email->bind_param("s", $email);
            $stmt_check_email->execute();
            $result_check_email = $stmt_check_email->get_result();

            
            //verificar usuario en users_login.
            $stmt_check_user = $conn->prepare("SELECT idLogin FROM users_login WHERE usuario = ?");
            $stmt_check_user->bind_param("s", $usuario);
            $stmt_check_user->execute();
            $result_check_user = $stmt_check_user->get_result();

            if ($result_check_email->num_rows > 0) {
                $mensaje = "<div class='card-panel red lighten-4 red-text text-darken-4'>
                                El correo electrónico ya está registrado. <a href='login.php'>Inicia sesión</a> o <a href='../index.php'>volver al inicio</a>.
                            </div>";
                $conn->rollback(); 
            } elseif ($result_check_user->num_rows > 0) {
                $mensaje = "<div class='card-panel red lighten-4 red-text text-darken-4'>
                                El nombre de usuario ya está en uso. Por favor, elige otro.
                            </div>";
                $conn->rollback(); 
            } else {
                //Insertar datos en users_data.
                $stmt_insert_data = $conn->prepare("INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) VALUES (?, ?, ?, ?, ?, ?, ?)");
               
                $stmt_insert_data->bind_param("sssssss", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo);
                if ($stmt_insert_data->execute()) {
                    $idUser = $conn->insert_id; // Obtener el ID del usuario recién insertado.

                    // Insertar datos en users_login.
                    $stmt_insert_login = $conn->prepare("INSERT INTO users_login (idUser, usuario, password, rol) VALUES (?, ?, ?, ?)");
                   
                    $stmt_insert_login->bind_param("isss", $idUser, $usuario, $password_hashed, $rol);
                    
                    if ($stmt_insert_login->execute()) {
                        $conn->commit(); 
                        // Éxito: Redirigir al login después de 3 segundos.
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
                        // Error al insertar en users_login.
                        $mensaje = "<div class='card-panel red lighten-4 red-text text-darken-4'>
                                        Error al registrar el usuario en el sistema. Por favor, inténtalo de nuevo.
                                    </div>";
                        $conn->rollback(); 
                    }
                } else {
                    // Error al insertar en users_data.
                    $mensaje = "<div class='card-panel red lighten-4 red-text text-darken-4'>
                                    Error al guardar tus datos personales. Por favor, inténtalo de nuevo.
                                </div>";
                    $conn->rollback(); 
                }
            }
        } catch (Exception $e) {
            // Capturar cualquier excepción que pueda ocurrir durante la transacción.
            $conn->rollback();
            $mensaje = "<div class='card-panel red lighten-4 red-text text-darken-4'>
                            Ocurrió un error inesperado durante el registro: " . $e->getMessage() . "
                        </div>";
        } finally {
            
            if (isset($stmt_check_email)) $stmt_check_email->close();
            if (isset($stmt_check_user)) $stmt_check_user->close();
            if (isset($stmt_insert_data)) $stmt_insert_data->close();
            if (isset($stmt_insert_login)) $stmt_insert_login->close();
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
    <!-- Enlace a CSS personalizado -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Registro</title>
</head>

<body>
    <nav>
        <div class="nav-wrapper red lighten-1">
            <!--Logo, dentro del menú de navegación-->
            <a href="../index.php" class="brand-logo" id="seccion">LBitFit Dental</a>
            <!--Menú de navegación dentro de un div-->
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <!--ítems menú de navegación-->
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
                    <li><a href="login.php">Iniciar sesión</a></li>
                    <li><a href="registro.php" class="active">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main class="main">
        <div class="title-main">
            <h2 class="red-text text-lighten-1">Registro de Usuario</h2>
        </div>
        <div class="formu-main">
            <form action="registro.php" method="POST">
                <?php if (isset($mensaje)) echo $mensaje; // Muestra mensajes de éxito/error aquí ?>

                <div class="input-field col s12">
                    <i class="material-icons fa-regular fa-user prefix"></i>
                    <input id="nombre" type="text" name="nombre" class="validate" required>
                    <label for="nombre">Nombre</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons fa-regular fa-user prefix"></i>
                    <input id="apellidos" type="text" name="apellidos" class="validate" required>
                    <label for="apellidos">Apellidos</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons fa-regular fa-envelope prefix"></i>
                    <input id="email" type="email" name="email" class="validate" required>
                    <label for="email">Correo electrónico</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons fa-solid fa-phone prefix"></i>
                    <input id="telefono" type="tel" name="telefono" class="validate" required>
                    <label for="telefono">Teléfono</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons fa-solid fa-calendar-alt prefix"></i>
                    <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" class="validate" required>
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons fa-solid fa-map-marker-alt prefix"></i>
                    <input id="direccion" type="text" name="direccion" class="validate">
                    <label for="direccion">Dirección (Opcional)</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons fa-solid fa-venus-mars prefix"></i>
                    <select id="sexo" name="sexo" required>
                        <option value="" disabled selected>Selecciona tu sexo</option>
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                        <option value="Otro">Otro</option>
                        <option value="Prefiero no decir">Prefiero no decir</option>
                    </select>
                    <label for="sexo">Sexo</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons fa-regular fa-id-badge prefix"></i>
                    <input id="usuario" type="text" name="usuario" class="validate" required>
                    <label for="usuario">Nombre de Usuario</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons fa-solid fa-lock prefix"></i>
                    <input id="password" type="password" name="password" class="validate" required>
                    <label for="password">Contraseña</label>
                </div>

                <button type="submit" class="waves-effect red lighten-1 btn-large btn-reg">Registrarse</button>
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
        // Inicializa los selects de Materialize
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);

            // Inicializa el datepicker de Materialize
            var datepickerElems = document.querySelectorAll('input[type="date"]');
            M.Datepicker.init(datepickerElems, {
                format: 'yyyy-mm-dd', // Formato de fecha para la base de datos
                i18n: { // Traducciones para el datepicker
                    cancel: 'Cancelar',
                    clear: 'Limpiar',
                    done: 'Ok',
                    months: [
                        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
                        'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                    monthsShort: [
                        'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul',
                        'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
                    ],
                    weekdays: [
                        'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'
                    ],
                    weekdaysShort: [
                        'Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'
                    ],
                    weekdaysAbbrev: ['D', 'L', 'M', 'X', 'J', 'V', 'S']
                },
                maxDate: new Date(), // No permitir fechas futuras
                yearRange: 20 // Rango de años para seleccionar
            });
        });
    </script>
</body>

</html>
