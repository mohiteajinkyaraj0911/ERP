<?php
require_once '../config/db.php';
require_once '../config/functions.php';

// Check if user is logged in and is staff
require_role('staff');

$user = get_current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - PJC College ERP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .navbar-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .navbar-right a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .navbar-right a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        
        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .welcome-section h2 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .dashboard-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        
        .dashboard-card h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .dashboard-card .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        
        .dashboard-card a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .dashboard-card a:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>PJC College ERP</h1>
        <div class="navbar-right">
            <span>Welcome, <?php echo htmlspecialchars($user['name']); ?></span>
            <a href="profile.php">Profile</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="welcome-section">
            <h2>Staff Dashboard</h2>
            <p>Welcome to your staff dashboard. Manage administrative tasks and support functions here.</p>
        </div>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="icon">👥</div>
                <h3>User Management</h3>
                <p>Manage all user accounts and roles.</p>
                <a href="users.php">Manage Users</a>
            </div>
            
            <div class="dashboard-card">
                <div class="icon">📚</div>
                <h3>Course Management</h3>
                <p>Manage courses and allocations.</p>
                <a href="courses.php">Manage Courses</a>
            </div>
            
            <div class="dashboard-card">
                <div class="icon">📋</div>
                <h3>Requests</h3>
                <p>Process administrative requests.</p>
                <a href="requests.php">View Requests</a>
            </div>
            
            <div class="dashboard-card">
                <div class="icon">📊</div>
                <h3>Reports</h3>
                <p>Generate system reports and analytics.</p>
                <a href="reports.php">View Reports</a>
            </div>
            
            <div class="dashboard-card">
                <div class="icon">📧</div>
                <h3>Messages</h3>
                <p>Communicate with faculty and students.</p>
                <a href="messages.php">View Messages</a>
            </div>
            
            <div class="dashboard-card">
                <div class="icon">⚙️</div>
                <h3>Settings</h3>
                <p>Manage system settings.</p>
                <a href="settings.php">Go to Settings</a>
            </div>
        </div>
    </div>
</body>
</html>
