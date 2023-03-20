<?php

class Database {
  private $host;
  private $username;
  private $password;
  private $database;
  private $connection;

  public function __construct($host, $username, $password, $database) {
    $this->host = $host;
    $this->username = $username;
    $this->password = $password;
    $this->database = $database;

    $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
    if (!$this->connection) {
      die('Could not connect: ' . mysqli_connect_error());
    }
  }

  public function prepare($query) {
    return mysqli_prepare($this->connection, $query);
  }

  public function execute($stmt) {
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
  }

  public function bindParam($stmt, $type, $param) {
    mysqli_stmt_bind_param($stmt, $type, $param);
  }

  public function getLastInsertId() {
    return mysqli_insert_id($this->connection);
  }
}