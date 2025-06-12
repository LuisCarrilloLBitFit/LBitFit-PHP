<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Salud Integral - <?= $page_title ?? '' ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Clínica Salud Integral</h1>
        </div>
        
        <nav>
            <ul>
                <li <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'class="active"' : '' ?>>
                    <a href="/index.php">Inicio</a>
                </li>
                <li <?= basename($_SERVER['PHP_SELF']) === 'noticias.php' ? 'class="active"' : '' ?>>
                <a href="noticias.php">Noticias</a>
                </li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['rol'] === 'user'): ?>
                        <li <?= basename($_SERVER['PHP_SELF']) === 'citaciones.php' ? 'class="active"' : '' ?>>
                            <a href="/user/citaciones.php">Mis Citas</a>
                        </li>
                        <li <?= basename($_SERVER['PHP_SELF']) === 'perfil.php' ? 'class="active"' : '' ?>>
                            <a href="/user/perfil.php">Mi Perfil</a>
                        </li>
                    <?php elseif ($_SESSION['rol'] === 'admin'): ?>
                        <li <?= basename($_SERVER['PHP_SELF']) === 'usuarios-administracion.php' ? 'class="active"' : '' ?>>
                            <a href="/admin/usuarios-administracion.php">Usuarios</a>
                        </li>
                        <li <?= basename($_SERVER['PHP_SELF']) === 'citas-administracion.php' ? 'class="active"' : '' ?>>
                            <a href="/admin/citas-administracion.php">Citas</a>
                        </li>
                        <li <?= basename($_SERVER['PHP_SELF']) === 'noticias-administracion.php' ? 'class="active"' : '' ?>>
                            <a href="/admin/noticias-administracion.php">Noticias</a>
                        </li>
                    <?php endif; ?>
                    
                    <li>
                        <a href="/logout.php">Cerrar Sesión</a>
                    </li>
                <?php else: ?>
                    <li <?= basename($_SERVER['PHP_SELF']) === 'login.php' ? 'class="active"' : '' ?>>
                        <a href="/login.php">Iniciar Sesión</a>
                    </li>
                    <li <?= basename($_SERVER['PHP_SELF']) === 'registro.php' ? 'class="active"' : '' ?>>
                        <a href="/registro.php">Registro</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    
    <main>