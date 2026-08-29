<?php
session_start();
require_once 'config/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        
        .error-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
        }
        
        .error-container h1 {
            font-size: 48px;
            color: #e74c3c;
            margin-bottom: 20px;
        }
        
        .error-container p {
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        .error-container a {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .error-container a:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>403</h1>
        <h2>Unauthorized Access</h2>
        <p><?php echo $_SESSION['error'] ?? 'You do not have permission to access this page.'; ?></p>
        <a href="login.php">Back to Login</a>
    </div>
</body>
</html>
