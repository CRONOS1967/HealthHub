<?php
require_once '../../includes/SessionManager.php';
require_once '../../includes/Database.php';

if (!SessionManager::isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}

$id = $_GET['id'];
$database = new Database();
$conn = $database->getConnection();
$stmt = $conn->prepare("DELETE FROM Products WHERE product_id = :id");
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    header('Location: manage_products.php');
} else {
    echo "<script>alert('Failed to delete product.'); window.location.href = 'manage_products.php';</script>";
}
?>