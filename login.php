<?php
require_once ('./inc/class.Database.php');
require_once ('./inc/class.Session.php');
require_once ('./inc/class.User.php');

// Check if the user is already logged in
$user_id = User::is_logged_in();

// If the user is already logged in, redirect them to the home page
if ($user_id !== false) {
  header('Location: index.php');
  exit();
}

// If the user is not logged in, display the login form
// PHP code to handle form submission
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Create a new database connection
    $db = new Database('localhost', 'root', 'tsu', 'ny');
  
    // Create a new user object
    $user = new User($db, $_POST['username'], $_POST['password']);
  
    try {
      // Authenticate the user
      $user_id = $user->authenticate();
  
      // Create a new session
      $session = new Session($db, $user_id);
      $token = $session->create();
  
      // Store the token in a cookie
      setcookie('token', $token, time() + (10 * 365 * 24 * 60 * 60), '/', '', false, true);
  
      // Redirect the user to the home page
      header('Location: index.php');
      exit();
    } catch (Exception $e) {
      // Display error message
      echo $e->getMessage();
    }
} else {
  // Display the login form
  echo '<form method="POST">';
  echo '<label for="username">Username:</label>';
  echo '<input type="text" name="username" id="username" required>';
  echo '<label for="password">Password:</label>';
  echo '<input type="password" name="password" id="password" required>';
  echo '<input type="submit" value="Log in">';
  echo '</form>';
}