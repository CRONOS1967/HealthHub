<?php
require_once '../../includes/SessionManager.php';
require_once '../../includes/Database.php';

if (!SessionManager::isLoggedIn() || $_SESSION['role'] !== 'delivery') {
    header('Location: ../../index.php');
    exit();
}

include '../shared/header.php';

$order_id = $_GET['id'];
$database = new Database();
$conn = $database->getConnection();
$stmt = $conn->prepare("SELECT * FROM Orders WHERE order_id = :order_id");
$stmt->bindParam(':order_id', $order_id);
$stmt->execute();
$order = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM OrderItems WHERE order_id = :order_id");
$stmt->bindParam(':order_id', $order_id);
$stmt->execute();
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h1>Order Details</h1>
    <div class="mb-4">
        <p><strong>Order ID:</strong> <?= $order['order_id'] ?></p>
        <p><strong>User ID:</strong> <?= $order['user_id'] ?></p>
        <p><strong>Total Amount:</strong> $<?= $order['total_amount'] ?></p>
        <p><strong>Status:</strong> <?= $order['status'] ?></p>
        <p><strong>Created At:</strong> <?= $order['created_at'] ?></p>
    </div>
    <h2>Order Items</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item): ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>$<?= $item['price'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../shared/footer.php'; ?>