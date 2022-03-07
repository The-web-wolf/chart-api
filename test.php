<?php
require('config.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');

// read data from postgresql
$query = "SELECT * FROM tasks WHERE is_active = 'f' AND worker_initials in (SELECT worker_initials FROM freelancers WHERE is_bot = false and ready_for_receiving_tasks) ORDER BY id ASC";
$result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());

// print data
$data = array();
while ($row = pg_fetch_row($result)) {
    $data[] = $row;
}

print_r(json_encode($data));
