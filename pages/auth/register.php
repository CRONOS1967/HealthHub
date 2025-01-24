<?php
require_once '../../includes/Database.php';
require_once '../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $role = 'customer'; // Default role for new users

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $database = new Database();
    $conn = $database->getConnection();

    $stmt = $conn->prepare("INSERT INTO Users (username, email, password_hash, role) VALUES (:username, :email, :password_hash, :role)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password_hash', $password_hash);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href = 'login.html';</script>";
    } else {
        echo "<script>alert('Registration failed. Please try again.'); window.location.href = 'register.html';</script>";
    }
}
?>