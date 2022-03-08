<?php
require('../config.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
//connect to db
$db_name = "chart";
$conn = pg_connect("host=$db_host port=$db_port dbname=$db_name user=$db_user password=$db_pass") or die('Could not connect: ' . pg_last_error());

$query = "SELECT DISTINCT worker_initials FROM \"new-chart\" WHERE worker_initials != 'n/a' ";
$result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());

// print data
$data = array();
$index = 0;
while ($row = pg_fetch_row($result)) {
  $index++;
  // add to data with key pair values if value is not null
  if ($row[0] != null) {
    $data[] = array(
      'name' => $row[0],
      'index' => $index,
    );
  }
}
print_r(json_encode($data));
