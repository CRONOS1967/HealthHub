<?php
require_once '../../includes/Database.php';
require_once '../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email']);

    // Generate a unique token
    $token = bin2hex(random_bytes(32));

    // Store the token in the database
    $database = new Database();
    $conn = $database->getConnection();

    $stmt = $conn->prepare("UPDATE Users SET reset_token = :token WHERE email = :email");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        // Send the reset link to the user's email
        $reset_link = "http://yourdomain.com/pages/auth/reset_password_form.php?token=$token";
        // Use PHP's mail() function or a library like PHPMailer to send the email
        echo "<script>alert('Password reset link sent to your email.'); window.location.href = 'login.html';</script>";
    } else {
        echo "<script>alert('Failed to send reset link. Please try again.'); window.location.href = 'forgot_password.html';</script>";
    }
}
?>