<?php
// php/db.php
$host = "sql106.infinityfree.com";     // from InfinityFree MySQL Hostname
$user = "if0_40368731";                // MySQL Username
$pass = "";          // replace with your real MySQL password
$db   = "if0_40368731_restaurant_db";  // MySQL Database Name
$port = 3306; 

$mysqli = new mysqli($host, $user, $pass, $db, $port);
if ($mysqli->connect_errno) {
  http_response_code(500);
  echo json_encode(["error" => "DB connection failed: " . $mysqli->connect_error]);
  exit;
}

$mysqli->set_charset("utf8mb4");
header("Content-Type: application/json; charset=utf-8");
?>
