<?php
require_once '../../includes/SessionManager.php';

SessionManager::logout();
header('Location: ../../index.php');
exit();
?>