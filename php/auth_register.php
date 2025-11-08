<?php
require "db.php";

$name = trim($_POST["name"] ?? "");
$lastname = trim($_POST["lastname"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$pass  = $_POST["password"] ?? "";

if (!$name || !$lastname || !$email || !$pass) {
  http_response_code(400);
  echo json_encode(["ok" => false, "msg" => "Լրացրեք բոլոր պարտադիր դաշտերը"]);
  exit;
}

$hash = password_hash($pass, PASSWORD_BCRYPT);

// Prepare statement
$stmt = $mysqli->prepare("INSERT INTO customers (name, lastname, phone_number, email, passhash) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $lastname, $phone, $email, $hash);

if ($stmt->execute()) {
  echo json_encode(["ok" => true]);
} else {
  // Check if the error is because of duplicate email
  if ($mysqli->errno === 1062) {
    http_response_code(409);
    echo json_encode(["ok" => false, "msg" => "Էլ.փոստը արդեն գրանցված է"]);
  } else {
    http_response_code(500);
    echo json_encode(["ok" => false, "msg" => "Տեղի ունեցավ սխալ"]);
  }
}
$stmt->close();
?>
