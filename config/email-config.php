<?php
// Email Configuration for Notifications
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your_email@gmail.com');
define('SMTP_PASS', 'your_app_password');
define('SENDER_EMAIL', 'noreply@pjcerp.edu');
define('SENDER_NAME', 'PJC College ERP');

/**
 * Send Email Notification
 */
function send_email($to, $subject, $body, $html = true) {
    require_once 'PHPMailer/PHPMailer.php';
    require_once 'PHPMailer/SMTP.php';
    require_once 'PHPMailer/Exception.php';
    
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = 'tls';
        $mail->Port = SMTP_PORT;
        
        $mail->setFrom(SENDER_EMAIL, SENDER_NAME);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->isHTML($html);
        $mail->Body = $body;
        
        return $mail->send();
    } catch (Exception $e) {
        error_log('Email error: ' . $mail->ErrorInfo);
        return false;
    }
}
?>