<?php
require('config.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
//connect to db
$db_name = "chart";
$conn = pg_connect("host=$db_host port=$db_port dbname=$db_name user=$db_user password=$db_pass") or die('Could not connect: ' . pg_last_error());

if (isset($_GET['name'])) {
  $name = $_GET['name'];
  $name = pg_escape_string($name);
} else {
  $name = "vat_report";
}

if (isset($_GET['freelancer'])) {
  $freelancer = $_GET['freelancer'];
  $freelancer = pg_escape_string($freelancer);
  $query = "SELECT * FROM \"new-chart\" WHERE name = '$name' AND worker_initials = '$freelancer' ";
} else {
  $query = "SELECT * FROM \"new-chart\" WHERE name = '$name' ";
}

$result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());

// print data
$data = array();
while ($row = pg_fetch_row($result)) {
  // add to data with key pair values
  $data[] = array(
    'avg_minutes_spent' => floatval($row[0]),
    'name' => $row[1],
    'sum_minutes_spent' => floatval($row[2]),
    'created' => $row[3],
    'worker_initials' => $row[4],
  );
}

print_r(json_encode($data));
