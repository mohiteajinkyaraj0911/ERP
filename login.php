<?php
session_start();
require_once 'config/db.php';
require_once 'config/functions.php';

// Redirect if already logged in
if (is_logged_in()) {
    redirect_by_role();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = 'Please enter username and password!';
    } else {
        // Check for account lockout
        $stmt = $conn->prepare("SELECT id, password, role, locked, lock_until FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Check if account is locked
            if ($user['locked'] == 1) {
                if (time() < strtotime($user['lock_until'])) {
                    $error = 'Account is locked. Try again later.';
                } else {
                    // Unlock account
                    $unlock_stmt = $conn->prepare("UPDATE users SET locked = 0, failed_attempts = 0 WHERE id = ?");
                    $unlock_stmt->bind_param("i", $user['id']);
                    $unlock_stmt->execute();
                }
            }
            
            // Verify password
            if (empty($error) && verify_password($password, $user['password'])) {
                // Password correct - reset failed attempts and login
                $login_stmt = $conn->prepare("UPDATE users SET failed_attempts = 0, locked = 0, last_login = NOW() WHERE id = ?");
                $login_stmt->bind_param("i", $user['id']);
                $login_stmt->execute();
                
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['username'] = $username;
                
                // Log action
                log_action($user['id'], 'LOGIN', 'User logged in successfully');
                
                // Redirect based on role
                redirect_by_role();
            } else {
                // Wrong password
                if (!empty($error)) {
                    // Account is locked, error already set
                } else {
                    // Increment failed attempts
                    $failed_attempts = ($user['failed_attempts'] ?? 0) + 1;
                    
                    if ($failed_attempts >= 5) {
                        // Lock account for 30 minutes
                        $lock_until = date('Y-m-d H:i:s', time() + (30 * 60));
                        $lock_stmt = $conn->prepare("UPDATE users SET failed_attempts = ?, locked = 1, lock_until = ? WHERE id = ?");
                        $lock_stmt->bind_param("isi", $failed_attempts, $lock_until, $user['id']);
                        $lock_stmt->execute();
                        
                        $error = 'Too many failed attempts. Account locked for 30 minutes.';
                    } else {
                        $update_stmt = $conn->prepare("UPDATE users SET failed_attempts = ? WHERE id = ?");
                        $update_stmt->bind_param("ii", $failed_attempts, $user['id']);
                        $update_stmt->execute();
                        
                        $error = 'Invalid username or password!';
                    }
                }
            }
        } else {
            $error = 'Invalid username or password!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PJC College ERP - Login</title>
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
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #666;
            font-size: 14px;
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
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.1);
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
        
        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #666;
        }
        
        .login-footer a {
            color: #667eea;
            text-decoration: none;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        .demo-credentials {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 5px;
            padding: 12px;
            margin-top: 20px;
            font-size: 12px;
            color: #004085;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>PJC College ERP</h1>
            <p>Enterprise Resource Planning System</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            
            <button type="submit" class="login-btn">Login</button>
            
            <div class="login-footer">
                <a href="forgot-password.php">Forgot Password?</a>
            </div>
        </form>
        
        <div class="demo-credentials">
            <strong>Demo Credentials:</strong><br>
            Admin: admin / password<br>
            Faculty: faculty / password<br>
            Student: student / password
        </div>
    </div>
</body>
</html>
