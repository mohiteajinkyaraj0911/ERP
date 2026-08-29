<?php
session_start();
require_once 'config/db.php';
require_once 'config/functions.php';
require_once 'config/email-config.php';

if (is_logged_in()) {
    redirect_by_role();
}

$error = '';
$success = '';
$step = isset($_GET['step']) ? $_GET['step'] : 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($step == 1) {
        // Request password reset
        $email = sanitize_input($_POST['email'] ?? '');
        
        if (empty($email)) {
            $error = 'Please enter your email address!';
        } else {
            $stmt = $conn->prepare("SELECT id, username FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                $reset_token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', time() + 3600); // 1 hour
                
                $update_stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE id = ?");
                $update_stmt->bind_param("ssi", $reset_token, $expires, $user['id']);
                $update_stmt->execute();
                
                // Send email with reset link
                $reset_link = "http://localhost/PJC_College_ERP_v1.0/reset-password.php?token=" . $reset_token;
                $subject = "Password Reset Request - PJC College ERP";
                $body = "Hello " . $user['username'] . ",<br><br>";
                $body .= "Click the link below to reset your password:<br>";
                $body .= "<a href='" . $reset_link . "'>Reset Password</a><br><br>";
                $body .= "This link will expire in 1 hour.<br><br>";
                $body .= "If you didn't request this, ignore this email.";
                
                if (send_email($email, $subject, $body)) {
                    $success = 'Password reset link sent to your email!';
                } else {
                    $error = 'Error sending email. Please try again later.';
                }
            } else {
                // For security, don't reveal if email exists
                $success = 'If the email exists, a reset link has been sent!';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - PJC College ERP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #764ba2;
        }
        
        .link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
        }
        
        .link a {
            color: #667eea;
            text-decoration: none;
        }
        
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Forgot Password?</h1>
            <p>Enter your email to reset your password</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            
            <button type="submit" class="btn">Send Reset Link</button>
            
            <div class="link">
                <a href="login.php">Back to Login</a>
            </div>
        </form>
    </div>
</body>
</html>