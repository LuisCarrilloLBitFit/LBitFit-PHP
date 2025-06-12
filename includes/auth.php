<?php
/**
 * Validación de autenticación y roles
 */

// Verificar si hay una sesión activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirigir si no está logueado
function require_auth() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header("Location: /login.php");
        exit();
    }
}

// Redirigir si no es administrador
function require_admin() {
    require_auth();
    if ($_SESSION['rol'] !== 'admin') {
        header("Location: /index.php");
        exit();
    }
}

// Redirigir si no es usuario normal
function require_user() {
    require_auth();
    if ($_SESSION['rol'] !== 'user') {
        header("Location: /index.php");
        exit();
    }
}
?>