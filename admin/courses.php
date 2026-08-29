<?php
require_once '../config/db.php';
require_once '../config/functions.php';

require_role('admin');

$user = get_current_user();

// Add courses table schema if needed
$courses = $conn->query("SELECT * FROM courses ORDER BY created_at DESC LIMIT 100") or 
           $courses = new stdClass(); // Empty result if table doesn't exist
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management - Admin Panel</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .header h2 {
            color: #667eea;
            margin: 0;
        }
        
        .message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>PJC College ERP</h1>
        <div>
            <span style="margin-right: 20px;">Welcome, <?php echo htmlspecialchars($user['name']); ?></span>
            <a href="index.php" style="color: white; text-decoration: none; margin-right: 10px;">Dashboard</a>
            <a href="../logout.php" style="color: white; text-decoration: none;">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="header">
            <h2>📚 Course Management</h2>
            <p>Manage courses, allocate faculty, and track enrollments.</p>
            
            <div class="message">
                <strong>Coming Soon:</strong> Full course management interface with faculty allocation, student enrollment tracking, and curriculum management.
            </div>
        </div>
    </div>
</body>
</html>