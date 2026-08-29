# PJC College ERP - Login System Setup Guide

## Prerequisites
- XAMPP installed and running
- MySQL running
- PHP 7.4 or higher

## Step 1: Extract and Place Files
1. Extract your project to: `C:\xampp\htdocs\PJC_College_ERP_v1.0\`
2. Ensure the folder structure includes:
   - `config/` (with `db.php` and `functions.php`)
   - `admin/`, `faculty/`, `student/`, `staff/` (role directories)
   - `login.php`
   - `logout.php`
   - `unauthorized.php`

## Step 2: Create Database
1. Open phpMyAdmin: `http://localhost/phpmyadmin/`
2. Go to the SQL tab
3. Copy and paste the contents of `setup/database.sql`
4. Click "Go" to execute

## Step 3: Configure Database Connection
Edit `config/db.php` if needed:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // Change if different
define('DB_PASS', '');              // Add password if set
define('DB_NAME', 'pjc_erp');
```

## Step 4: Test Login
1. Start XAMPP and make sure Apache and MySQL are running
2. Navigate to: `http://localhost/PJC_College_ERP_v1.0/login.php`

### Demo Credentials:
| Username | Password | Role |
|----------|----------|------|
| admin    | password | Admin |
| faculty  | password | Faculty |
| student  | password | Student |

## Step 5: Fix the Error
The error you got was because `require_role()` was not defined. Now it's in `config/functions.php`, which is properly included in:
- `login.php`
- `admin/index.php` 
- Other admin pages

## Features Included:
✅ **Secure Password Hashing** - Using bcrypt
✅ **SQL Injection Protection** - Using prepared statements
✅ **Session Management** - Proper session handling
✅ **Role-Based Access Control** - Admin, Faculty, Student, Staff
✅ **Account Lockout** - After 5 failed attempts (30 minutes)
✅ **Audit Logging** - Tracks all user actions
✅ **Responsive Design** - Works on mobile and desktop
✅ **Error Handling** - Clear error messages

## Security Tips:
1. Change demo passwords after first login
2. Set a strong database password
3. Use HTTPS in production
4. Regularly check audit logs
5. Keep PHP and MySQL updated

## Troubleshooting:

### "Connection failed" error
- Make sure MySQL is running in XAMPP
- Check database credentials in `config/db.php`

### "Undefined function require_role()" error
- Make sure `config/functions.php` is properly included
- Check file paths in include statements

### "Access Denied" error
- Check MySQL password in `config/db.php`
- Verify the database was created from SQL file

### Password not working
- Demo password is "password" for all users
- If you changed it, use: `password_hash('your_password', PASSWORD_BCRYPT)` in PHP

## Next Steps:
1. Create student/faculty/admin dashboard pages
2. Add password reset functionality
3. Implement role-specific features
4. Add two-factor authentication
5. Create user management interface
6. Add email notifications

---
For support or questions, feel free to ask!
