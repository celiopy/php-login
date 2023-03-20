<?php

class User {
    private $db;
    private $username;
    private $password;
  
    public function __construct($db, $username, $password) {
        $this->db = $db;
        $this->username = $username;
        $this->password = $password;
    }
  
    public function authenticate() {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $this->db->bindParam($stmt, "s", $this->username);
        $result = $this->db->execute($stmt);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($this->password, $user['password'])) {
                return $user['id'];
            } else {
                throw new Exception("Incorrect password");
            }
        } else {
            throw new Exception("Incorrect username");
        }
    }

    // Function to check if the user is already logged in
    public static function is_logged_in() {
        // Check if a session token is set in a cookie
        if (isset($_COOKIE['token'])) {
            // Connect to the database
            $db = new Database('localhost', 'root', 'tsu', 'ny');

            // Get the session token from the cookie
            $token = $_COOKIE['token'];

            // Prepare the SQL statement for selecting the session
            $sql = "SELECT user_id FROM sessions WHERE token = ?";
            $stmt = $db->prepare($sql);

            // Bind the session token to the prepared statement
            $stmt->bind_param("s", $token);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result of the query
            $result = $stmt->get_result();

            // Check if the query returned a row
            if ($result->num_rows == 1) {
                // Get the user ID from the session
                $row = $result->fetch_assoc();
                $user_id = $row['user_id'];

                // Return the user ID
                return $user_id;
            }
        }

        // If no session token is set, or the session is invalid, return false
        return false;
    }
}