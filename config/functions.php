<?php
// Include database connection
require_once __DIR__ . '/db.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
}

/**
 * Check user role and redirect if unauthorized
 */
function require_role($allowed_roles = []) {
    // If not logged in, redirect to login
    if (!is_logged_in()) {
        header('Location: /PJC_College_ERP_v1.0/login.php');
        exit();
    }
    
    // If specific roles are required, check them
    if (!empty($allowed_roles)) {
        $allowed_roles = (array) $allowed_roles;
        
        if (!in_array($_SESSION['user_role'], $allowed_roles)) {
            $_SESSION['error'] = 'Unauthorized access!';
            header('Location: /PJC_College_ERP_v1.0/unauthorized.php');
            exit();
        }
    }
    
    return true;
}

/**
 * Get current user info
 */
function get_current_user() {
    global $conn;
    
    if (!is_logged_in()) {
        return null;
    }
    
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT id, username, email, role, name FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}

/**
 * Sanitize input
 */
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

/**
 * Hash password
 */
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Verify password
 */
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Redirect to dashboard based on role
 */
function redirect_by_role() {
    $role = $_SESSION['user_role'] ?? 'student';
    
    $redirects = [
        'admin' => '/PJC_College_ERP_v1.0/admin/index.php',
        'faculty' => '/PJC_College_ERP_v1.0/faculty/index.php',
        'student' => '/PJC_College_ERP_v1.0/student/index.php',
        'staff' => '/PJC_College_ERP_v1.0/staff/index.php'
    ];
    
    $redirect = $redirects[$role] ?? '/PJC_College_ERP_v1.0/student/index.php';
    header('Location: ' . $redirect);
    exit();
}

/**
 * Log user action
 */
function log_action($user_id, $action, $details = '') {
    global $conn;
    
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $timestamp = date('Y-m-d H:i:s');
    
    $stmt = $conn->prepare("INSERT INTO audit_logs (user_id, action, details, ip_address, timestamp) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $action, $details, $ip, $timestamp);
    $stmt->execute();
}

/**
 * Set flash message
 */
function set_message($type, $message) {
    $_SESSION['message'] = [
        'type' => $type,
        'text' => $message
    ];
}

/**
 * Display flash message
 */
function display_message() {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        echo '<div class="alert alert-' . $message['type'] . '">' . $message['text'] . '</div>';
        unset($_SESSION['message']);
    }
}
?>
