<?php
session_start();
require_once 'config/functions.php';

if (is_logged_in()) {
    // Log the logout action
    log_action($_SESSION['user_id'], 'LOGOUT', 'User logged out');
}

// Destroy session
session_unset();
session_destroy();

// Redirect to login
header('Location: login.php');
exit();
?>
