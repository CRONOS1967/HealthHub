<?php
class SessionManager {
    public static function startSession($user) {
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
    }

    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function redirectBasedOnRole() {
        if (isset($_SESSION['role'])) {
            switch ($_SESSION['role']) {
                case 'admin':
                    header('Location: ../pages/admin/dashboard.php');
                    break;
                case 'customer':
                    header('Location: ../pages/customer/dashboard.php');
                    break;
                case 'delivery':
                    header('Location: ../pages/delivery/dashboard.php');
                    break;
                default:
                    header('Location: ../index.php');
                    break;
            }
            exit();
        }
    }
}
?>