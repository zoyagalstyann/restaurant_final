<?php
require "db.php";
// expects: customer_id, paymentmethod, items=[{menuitem_id, qty, price}]
$customer_id    = intval($_POST["customer_id"] ?? 0);
$paymentmethod  = trim($_POST["paymentmethod"] ?? "Քարտ (թեստ)");
$items_json     = $_POST["items"] ?? "[]";
$items = json_decode($items_json, true);

if ($customer_id<=0 || !is_array($items) || count($items)==0) {
  http_response_code(400);
  echo json_encode(["ok"=>false,"msg"=>"Սխալ տվյալներ"]);
  exit;
}
$total = 0;
foreach ($items as $it) { $total += floatval($it["price"])*intval($it["qty"]); }

$mysqli->begin_transaction();
try {
  $stmt = $mysqli->prepare("INSERT INTO orders(customer_id,totalamount,paymentmethod) VALUES (?,?,?)");
  $stmt->bind_param("ids",$customer_id,$total,$paymentmethod);
  $stmt->execute();
  $order_id = $stmt->insert_id;

  $od = $mysqli->prepare("INSERT INTO orderdetails(order_id,menuitem_id,price,qty) VALUES (?,?,?,?)");
  foreach($items as $it){
    $id = intval($it["menuitem_id"]);
    $pr = floatval($it["price"]);
    $qt = intval($it["qty"]);
    $od->bind_param("iidi",$order_id,$id,$pr,$qt);
    $od->execute();
  }
  $mysqli->commit();
  echo json_encode(["ok"=>true,"order_id"=>$order_id,"total"=>$total]);
} catch(Exception $e){
  $mysqli->rollback();
  http_response_code(500);
  echo json_encode(["ok"=>false,"msg"=>"Չհաջողվեց պահպանել պատվերը"]);
}
