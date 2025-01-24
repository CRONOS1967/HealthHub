<?php
// Start the session and include necessary files
require_once '../../includes/SessionManager.php';
require_once '../../includes/Database.php';

// Check if the user is logged in and is an admin
if (!SessionManager::isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}

// Include the shared header
include '../shared/header.php';
?>

<div class="container mt-5">
    <h1>Welcome, Admin!</h1>
    <p>You have successfully logged in as an administrator.</p>

    <!-- Admin Dashboard Navigation -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Products</h5>
                    <p class="card-text">Add, update, or delete products in the store.</p>
                    <a href="manage_products.php" class="btn btn-primary">Go to Products</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Orders</h5>
                    <p class="card-text">View and manage customer orders.</p>
                    <a href="manage_orders.php" class="btn btn-primary">Go to Orders</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">View and manage user accounts.</p>
                    <a href="manage_users.php" class="btn btn-primary">Go to Users</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="mt-4">
        <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<?php
// Include the shared footer
include '../shared/footer.php';
?>
