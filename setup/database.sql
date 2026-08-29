-- Create database
CREATE DATABASE IF NOT EXISTS pjc_erp;
USE pjc_erp;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'faculty', 'student', 'staff') NOT NULL DEFAULT 'student',
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    phone VARCHAR(20),
    address TEXT,
    failed_attempts INT DEFAULT 0,
    locked TINYINT DEFAULT 0,
    lock_until DATETIME,
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Audit logs table
CREATE TABLE IF NOT EXISTS audit_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(100),
    details TEXT,
    ip_address VARCHAR(45),
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample users
INSERT INTO users (username, email, password, name, role, status, phone) VALUES
('admin', 'admin@pjc.edu', '$2y$10$vIpFV8d4P2h1E9v5P8q3OebEb9vPjMbEJZr.nU5X5ZvQVvH0CJlxm', 'Admin User', 'admin', 'active', '9876543210'),
('faculty', 'faculty@pjc.edu', '$2y$10$vIpFV8d4P2h1E9v5P8q3OebEb9vPjMbEJZr.nU5X5ZvQVvH0CJlxm', 'Faculty User', 'faculty', 'active', '9876543211'),
('student', 'student@pjc.edu', '$2y$10$vIpFV8d4P2h1E9v5P8q3OebEb9vPjMbEJZr.nU5X5ZvQVvH0CJlxm', 'Student User', 'student', 'active', '9876543212');

-- Note: All demo passwords are hashed as 'password'
-- To generate a new password hash, use: password_hash('your_password', PASSWORD_BCRYPT)
