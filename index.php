<?php
session_start();
$role = $_SESSION['role'] ?? 'visitor';
$username = $_SESSION['username'] ?? 'Invitado';
$logged_in = isset($_SESSION['username']);
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
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Bienvenido al Sitio Web</title>
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <!--Logo, dentro del menú de navegación-->
            <a href="index.php" class="brand-logo" id="seccion">LBitFit Dental</a>
            <!--Menú de navegación dentro de un div-->
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="index.php" class="active">Inicio</a></li>
                <li><a href="pages/noticias.php">Noticias</a></li>

                <?php if ($role == 'user' || $role == 'admin'): ?>
                <li><a href="pages/perfil.php">Perfil</a></li>
                <li><a href="pages/citaciones.php">Citaciones</a></li>
                <?php endif; ?>

                <?php if ($role == 'admin'): ?>
                <li><a href="admin/usuarios-administracion.php">Usuarios</a></li>
                <li><a href="admin/citas-administracion.php">Administrar Citas</a></li>
                <li><a href="admin/noticias-administracion.php">Noticias (Admin)</a></li>
                <?php endif; ?>

                <?php if ($logged_in): ?>
                <li><a href="sql/logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                <li><a href="sql/login.php">Iniciar sesión</a></li>
                <li><a href="sql/registro.php">Registrarse</a></li> <!-- Asegúrate de tener este archivo o crea uno -->
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <header>
        <!--Título sitio web-->
        <h2 class="header-title red-text text-lighten-1">Bienvenido, <?php echo htmlspecialchars($username); ?></h2>
        <div class="header-caja">
            <div class="header-cajatext">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquid, eveniet assumenda. Laborum cumque
                    quod officiis molestias aut laboriosam ducimus tempore corrupti tenetur perferendis ullam, debitis,
                    iste inventore? Vel, porro consectetur.
                    Nobis quaerat, quos porro id ipsa omnis, velit, suscipit exercitationem distinctio voluptatibus ab
                    quo. Minima dolores vitae assumenda molestias officia autem sequi mollitia tenetur. Doloremque
                    aperiam suscipit ad dolore optio?</p>
            </div>
            <div class="header-cajanota">
                <blockquote>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur tempore corrupti officiis
                    exercitationem omnis inventore mollitia quas ex, similique quasi facere iste quisquam velit unde ad
                    minima provident. Ipsum, dignissimos!
                </blockquote>
            </div>
        </div>
    </header>
    <main>
        <div class="main-cajatex">
            <h2 class="red-text text-lighten-1">LBitFit Dental</h2>
            <p>En LBitFit Dental somos especialistas en estética dental, ortodoncia invisible e implantes dentales.
                Además contamos con todos los tratamientos que pueda necesitar tu boca como endodoncia, sedación
                consciente, periodoncia y odontopediatría para los más pequeños.</p>
        </div>
        <div class="row">
            <div class="col s4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="assets/img/servicio-dental.webp">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Servicios dental<i
                                class="material-icons right">more_vert</i></span>
                        <p><a href="#">Leer mas</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4"><i
                                class="fa-solid fa-xmark red-text text-lighten-1"></i></span>
                        <p>Here is some more information about this product that is only revealed once clicked on.</p>
                    </div>
                </div>
            </div>
            <div class="col s4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="assets/img/consultorio-dental.webp">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Consultorio dental<i
                                class="material-icons right">more_vert</i></span>
                        <p><a href="#">Leer mas</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4"><i
                                class="fa-solid fa-xmark red-text text-lighten-1"></i></span>
                        <p>Here is some more information about this product that is only revealed once clicked on.</p>
                    </div>
                </div>
            </div>
            <div class="col s4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="assets/img/tecnologia-dental.webp">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Tecnología punta dental<i
                                class="material-icons right">more_vert</i></span>
                        <p><a href="#">Leer mas</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4"><i
                                class="fa-solid fa-xmark red-text text-lighten-1"></i></span>
                        <p>Here is some more information about this product that is only revealed once clicked on.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="boton-cita">
            <a href="https://wa.me/624376029" target="_blank" class="waves-effect red lighten-1 btn-large">Pedir
                información</a>
        </div>
        <h2 class="title-info red-text text-lighten-1">Facilidades de pago</h2>
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