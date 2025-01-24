<?php
class UserAuth {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function authenticate($username, $password) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT user_id, username, password_hash, role FROM Users WHERE username = :username OR email = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        return false;
    }
}
?>