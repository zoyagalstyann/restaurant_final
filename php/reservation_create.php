<?php
require "db.php";
// expects: customer_id, reservationdate (YYYY-MM-DD), numberofguests, table_number
$c = intval($_POST["customer_id"] ?? 0);
$d = $_POST["reservationdate"] ?? "";
$g = intval($_POST["numberofguests"] ?? 0);
$t = intval($_POST["table_number"] ?? 0);

if ($c<=0 || !$d || $g<=0 || $t<=0) {
  http_response_code(400);
  echo json_encode(["ok"=>false,"msg"=>"Լրացրեք բոլոր դաշտերը"]);
  exit;
}

$stmt = $mysqli->prepare("INSERT INTO reservations(customer_id,reservationdate,numberofguests,table_number) VALUES (?,?,?,?)");
$stmt->bind_param("isii",$c,$d,$g,$t);
try {
  $stmt->execute();
  echo json_encode(["ok"=>true]);
} catch(Exception $e){
  http_response_code(500);
  echo json_encode(["ok"=>false,"msg"=>"Չհաջողվեց ամրագրել"]);
}
