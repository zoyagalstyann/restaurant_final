<?php
require "db.php";
$res = $mysqli->query("SELECT menuitem_id, name, price, image FROM menuitems ORDER BY menuitem_id");
echo json_encode($res->fetch_all(MYSQLI_ASSOC));
