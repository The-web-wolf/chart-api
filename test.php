<?php
require('config.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');


$db_name = "chart";

$conn = pg_connect("host=$db_host port=$db_port dbname=$db_name user=$db_user password=$db_pass") or die('Could not connect: ' . pg_last_error());

// read data from postgresql
$query = 'SELECT * FROM "new-chart" ';
$result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());

// print data
$data = array();
while ($row = pg_fetch_row($result)) {
    $data[] = $row;
}

print_r(json_encode($data));
