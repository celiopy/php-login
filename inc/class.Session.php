<?php

class Session {
    private $db;
    private $user_id;
  
    public function __construct($db, $user_id) {
      $this->db = $db;
      $this->user_id = $user_id;
    }
  
    public function generateToken() {
      return bin2hex(random_bytes(32));
    }
  
    public function create() {
        $token = $this->generateToken();
        $stmt = $this->db->prepare("INSERT INTO sessions (user_id, token) VALUES (?, ?)");
        $stmt->bind_param("is", $this->user_id, $token);
        $stmt->execute();

        $stmt = $this->db->prepare("UPDATE users SET last_session = ? WHERE id = ?");
        $stmt->bind_param("si", date('Y-m-d H:i:s'), $this->user_id);
        $stmt->execute();

        return $token;
    }

    // Function to check if the user is already logged in
    public static function destroy() {
        // Connect to the database
        $db = new Database('localhost', 'root', 'tsu', 'ny');

        // Get the session token from the cookie
        $token = $_COOKIE['token'];

        // Prepare the SQL statement for selecting the session
        $sql = "UPDATE sessions SET active = 0 WHERE token = ?";
        $stmt = $db->prepare($sql);

        // Bind the session token to the prepared statement
        $stmt->bind_param("s", $token);

        // Execute the prepared statement
        $stmt->execute();

        // Delete token in a cookie
        setcookie('token', $token, time() - 3600, '/', '', false, true);
    }
}