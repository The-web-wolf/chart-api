<?php
require('config.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');

// read data from postgresql
$status = "f";
$query = "SELECT * FROM task_manager.tasks WHERE is_done = '$status'";
$result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());

// print data
$data = array();
while ($row = pg_fetch_row($result)) {
    $data[] = $row;
}

print_r(json_encode($data));
