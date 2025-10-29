<?php
require "db.php";
$email = trim($_POST["email"] ?? "");
$pass  = $_POST["password"] ?? "";
$q = $mysqli->prepare("SELECT customer_id, passhash, name, lastname FROM customers WHERE email=?");
$q->bind_param("s",$email);
$q->execute();
$r = $q->get_result()->fetch_assoc();
if ($r && password_verify($pass, $r["passhash"])) {
  echo json_encode(["ok"=>true,"customer_id"=>$r["customer_id"], "name"=>$r["name"], "lastname"=>$r["lastname"]]);
} else {
  http_response_code(401);
  echo json_encode(["ok"=>false,"msg"=>"Սխալ էլ.փոստ կամ գաղտնաբառ"]);
}
