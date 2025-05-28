<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if (!isset($_SESSION['last_regeneration']) || (time() - $_SESSION['last_regeneration']) > 1800) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
function hasRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}
?> 