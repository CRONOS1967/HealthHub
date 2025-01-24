<?php
require_once '../../includes/SessionManager.php';

if (!SessionManager::isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}
?>
<?php include '../shared/header.php'; ?>
<div class="container">
  <h1>Welcome, Admin!</h1>
  <p>You have successfully logged in as an administrator.</p>
</div>
<?php include '../shared/footer.php'; ?>