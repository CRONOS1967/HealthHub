<?php
require_once '../../includes/SessionManager.php';
require_once '../../includes/Database.php';

if (!SessionManager::isLoggedIn() || $_SESSION['role'] !== 'customer') {
    header('Location: ../../index.php');
    exit();
}

include '../shared/header.php';

$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $total_amount = $_POST['total_amount'];
    $status = 'Pending';

    $stmt = $conn->prepare("INSERT INTO Orders (user_id, total_amount, status) VALUES (:user_id, :total_amount, :status)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':total_amount', $total_amount);
    $stmt->bindParam(':status', $status);

    if ($stmt->execute()) {
        $order_id = $conn->lastInsertId();
        foreach ($_POST['items'] as $item) {
            $stmt = $conn->prepare("INSERT INTO OrderItems (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':product_id', $item['product_id']);
            $stmt->bindParam(':quantity', $item['quantity']);
            $stmt->bindParam(':price', $item['price']);
            $stmt->execute();
        }
        header('Location: view_orders.php');
    } else {
        echo "<script>alert('Failed to place order.');</script>";
    }
}

$stmt = $conn->query("SELECT * FROM Products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h1>Place Order</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="total_amount" class="form-label">Total Amount</label>
            <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" required>
        </div>
        <div class="mb-3">
            <label for="items" class="form-label">Order Items</label>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['name'] ?></td>
                        <td><input type="number" name="items[<?= $product['product_id'] ?>][quantity]" class="form-control" min="1" value="1"></td>
                        <td>$<?= $product['price'] ?></td>
                        <input type="hidden" name="items[<?= $product['product_id'] ?>][product_id]" value="<?= $product['product_id'] ?>">
                        <input type="hidden" name="items[<?= $product['product_id'] ?>][price]" value="<?= $product['price'] ?>">
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>

<?php include '../shared/footer.php'; ?>