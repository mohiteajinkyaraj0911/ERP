📦 PJC College ERP - Enterprise Resource Planning System
=========================================================

A comprehensive Enterprise Resource Planning system for PJC College built with PHP and MySQL, running on XAMPP.

## 🎯 Features

### ✅ Core Features
- **Secure Login System** - Password hashing with bcrypt, SQL injection protection
- **Role-Based Access Control** - Admin, Faculty, Student, and Staff roles
- **Session Management** - Secure session handling with timeout
- **Audit Logging** - Complete audit trail of all user actions
- **Account Security** - Account lockout after 5 failed login attempts

### 👥 User Roles
- **Admin** - Full system control, user management, system settings
- **Faculty** - Course management, grade entry, student management
- **Student** - Course enrollment, grade viewing, assignment submission
- **Staff** - Administrative support functions

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL (via XAMPP)
- **Frontend**: HTML5, CSS3, JavaScript
- **Server**: Apache (via XAMPP)

## 📋 Project Structure

```
PJC_College_ERP_v1.0/
├── config/
│   ├── db.php              # Database configuration
│   └── functions.php       # Helper functions (includes require_role())
├── admin/
│   └── index.php           # Admin dashboard
├── faculty/
│   └── index.php           # Faculty dashboard
├── student/
│   └── index.php           # Student dashboard
├── staff/
│   └── index.php           # Staff dashboard
├── setup/
│   └── database.sql        # Database schema and sample data
├── login.php               # Login page (FIXED)
├── logout.php              # Logout functionality
├── unauthorized.php        # Unauthorized access page
└── SETUP_GUIDE.md          # Installation and setup instructions
```

## 🚀 Quick Start

### Prerequisites
- XAMPP installed and running
- MySQL service active
- PHP 7.4 or higher

### Installation Steps

1. **Extract Project**
   ```bash
   Extract to: C:\xampp\htdocs\PJC_College_ERP_v1.0\
   ```

2. **Create Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin/`
   - Import `setup/database.sql`

3. **Configure Database**
   - Edit `config/db.php` if needed

4. **Start Application**
   - Navigate to: `http://localhost/PJC_College_ERP_v1.0/login.php`

## 🔐 Demo Credentials

| Username | Password | Role |
|----------|----------|------|
| admin    | password | Admin |
| faculty  | password | Faculty |
| student  | password | Student |

## ✨ Key Security Features

✅ **Password Security**
- Bcrypt hashing algorithm
- No plaintext passwords stored

✅ **SQL Injection Protection**
- Prepared statements with parameterized queries
- Input validation and sanitization

✅ **Session Security**
- Secure session token handling
- Automatic timeout
- Role-based access verification

✅ **Account Protection**
- Account lockout after failed attempts
- IP address tracking
- Audit logging

## 📝 Functions Documentation

### Core Authentication Functions

```php
is_logged_in()              // Check if user is logged in
require_role($roles)        // Verify user role (FIXED)
get_current_user()          // Get current user information
verify_password($pwd, $hash)// Verify hashed password
hash_password($password)    // Hash password with bcrypt
```

### Helper Functions

```php
sanitize_input($data)       // Sanitize user input
redirect_by_role()          // Redirect based on user role
log_action($user_id, ...)   // Log user action to audit table
set_message($type, $msg)    // Set flash message
display_message()           // Display flash message
```

## 🐛 Fixed Issues

### Issue: "Fatal error: Uncaught Error: Call to undefined function require_role()"

**Solution**: 
- The `require_role()` function is now defined in `config/functions.php`
- It's properly included in all protected pages
- The function checks user authentication and role authorization

## 📊 Database Schema

### Users Table
- id, username, email, password (hashed)
- name, role, status
- failed_attempts, locked, lock_until
- last_login, created_at, updated_at

### Audit Logs Table
- id, user_id, action, details
- ip_address, timestamp

## 🔄 Workflow

1. User visits `login.php`
2. Credentials validated against database
3. Session created with user ID and role
4. User redirected to appropriate dashboard
5. Protected pages check session and role
6. Actions logged to audit table

## 📚 Next Steps

- [ ] Implement password reset functionality
- [ ] Add two-factor authentication
- [ ] Create user management interface
- [ ] Build course management module
- [ ] Develop grade management system
- [ ] Add email notifications
- [ ] Implement file upload system
- [ ] Create reporting dashboards
- [ ] Add attendance tracking
- [ ] Build assignment submission system

## 🆘 Troubleshooting

### Login Page Not Working
- Ensure MySQL is running in XAMPP
- Check database credentials in `config/db.php`
- Verify database.sql was imported

### "Undefined function require_role()" Error
- Confirm `config/functions.php` exists
- Check file is being required at top of protected pages
- Verify path: `require_once '../config/functions.php';`

### Database Connection Failed
- Start MySQL service in XAMPP Control Panel
- Verify credentials match your MySQL setup
- Check `config/db.php` configuration

## 📞 Support

For issues or questions:
1. Check SETUP_GUIDE.md for detailed instructions
2. Review database.sql for schema information
3. Check audit logs for action history

## 📄 License

This project is provided as-is for PJC College.

---

**Version**: 1.0
**Last Updated**: 2026-08-29
**Status**: ✅ Fixed and Ready to Use
