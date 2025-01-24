<?php
require_once '../../includes/Database.php';
require_once '../../includes/UserAuth.php';
require_once '../../includes/SessionManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_username = sanitizeInput($_POST['username']);
    $input_password = sanitizeInput($_POST['password']);

    $database = new Database();
    $userAuth = new UserAuth($database);

    // Authenticate the user
    $user = $userAuth->authenticate($input_username, $input_password);

    if ($user) {
        SessionManager::startSession($user);
        SessionManager::redirectBasedOnRole();
    } else {
        echo "<script>alert('Invalid username or password.'); window.location.href = 'login.html';</script>";
    }
}
?>