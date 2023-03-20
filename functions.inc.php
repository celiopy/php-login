<?php
// functions

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function User($id) {
  $db = new Database('localhost', 'root', 'tsu', 'ny');

  $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  // Get the result of the query
  $result = $stmt->get_result();

  // Check if the query returned a row
  if ($result->num_rows == 1) {
      // Return the user
      return $result->fetch_assoc();
  }
}

function Sessions($user_id) {
  $db = new Database('localhost', 'root', 'tsu', 'ny');

  $stmt = $db->prepare("SELECT * FROM sessions WHERE user_id = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();

  $result = $stmt->get_result();
  return $result->fetch_all(MYSQLI_ASSOC);
}
?>