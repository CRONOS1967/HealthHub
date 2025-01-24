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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE Orders SET status = :status WHERE order_id = :order_id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':order_id', $order_id);

    if ($stmt->execute()) {
        header('Location: view_orders.php');
    } else {
        echo "<script>alert('Failed to update order status.');</script>";
    }
}

$stmt = $conn->prepare("SELECT * FROM Orders WHERE order_id = :order_id");
$stmt->bindParam(':order_id', $order_id);
$stmt->execute();
$order = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h1>Update Order Status</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Pending" <?= $order['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Shipped" <?= $order['status'] === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                <option value="Delivered" <?= $order['status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>
</div>

<?php include '../shared/footer.php'; ?>