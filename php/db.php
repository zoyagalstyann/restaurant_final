<?php
// php/db.php
$host = "127.0.0.1";
$user = "root";      // XAMPP default
$pass = "";          // XAMPP default empty
$db   = "restaurant_db";
$port = 3306; 

$mysqli = new mysqli($host, $user, $pass, $db, $port);
if ($mysqli->connect_errno) {
  http_response_code(500);
  echo json_encode(["error" => "DB connection failed"]);
  exit;
}
$mysqli->set_charset("utf8mb4");
header("Content-Type: application/json; charset=utf-8");
