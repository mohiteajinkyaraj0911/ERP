<?php
require_once '../config/db.php';
require_once '../config/functions.php';

require_role('admin');

$user = get_current_user();
$users_list = $conn->query("SELECT id, username, email, name, role, status, last_login FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin Panel</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .btn-add {
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        
        .btn-add:hover {
            background: #764ba2;
        }
        
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th {
            background: #667eea;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        
        table tr:hover {
            background: #f9f9f9;
        }
        
        .badge {
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-admin {
            background: #e74c3c;
            color: white;
        }
        
        .badge-faculty {
            background: #3498db;
            color: white;
        }
        
        .badge-student {
            background: #2ecc71;
            color: white;
        }
        
        .badge-active {
            background: #2ecc71;
            color: white;
        }
        
        .badge-inactive {
            background: #95a5a6;
            color: white;
        }
        
        .actions {
            display: flex;
            gap: 5px;
        }
        
        .actions a {
            padding: 5px 10px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            font-size: 12px;
        }
        
        .actions a:hover {
            background: #2980b9;
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
            <h2>User Management</h2>
            <a href="add-user.php" class="btn-add">+ Add New User</a>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($u = $users_list->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u['username']); ?></td>
                        <td><?php echo htmlspecialchars($u['name']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td><span class="badge badge-<?php echo $u['role']; ?>"><?php echo ucfirst($u['role']); ?></span></td>
                        <td><span class="badge badge-<?php echo $u['status']; ?>"><?php echo ucfirst($u['status']); ?></span></td>
                        <td><?php echo $u['last_login'] ? date('M d, Y h:i A', strtotime($u['last_login'])) : 'Never'; ?></td>
                        <td>
                            <div class="actions">
                                <a href="edit-user.php?id=<?php echo $u['id']; ?>">Edit</a>
                                <a href="delete-user.php?id=<?php echo $u['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>