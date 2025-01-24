<?php
require_once '../../includes/SessionManager.php';
require_once '../../includes/Database.php';

if (!SessionManager::isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}

include '../shared/header.php';

$database = new Database();
$conn = $database->getConnection();
$stmt = $conn->query("SELECT * FROM Orders");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h1>Manage Orders</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['order_id'] ?></td>
                <td><?= $order['user_id'] ?></td>
                <td>$<?= $order['total_amount'] ?></td>
                <td><?= $order['status'] ?></td>
                <td><?= $order['created_at'] ?></td>
                <td>
                    <a href="view_order.php?id=<?= $order['order_id'] ?>" class="btn btn-info btn-sm">View</a>
                    <a href="update_order_status.php?id=<?= $order['order_id'] ?>" class="btn btn-warning btn-sm">Update Status</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../shared/footer.php'; ?>