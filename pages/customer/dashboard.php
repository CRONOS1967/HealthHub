<?php
require_once '../../includes/SessionManager.php';
require_once '../../includes/Database.php';

if (!SessionManager::isLoggedIn() || $_SESSION['role'] !== 'customer') {
    header('Location: ../../index.php');
    exit();
}

include '../shared/header.php';
?>

<div class="container mt-5">
    <h1>Welcome, Customer!</h1>
    <p>You have successfully logged in as a customer.</p>
    <div class="mt-4">
        <a href="view_orders.php" class="btn btn-primary">View Orders</a>
        <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<?php include '../shared/footer.php'; ?>