<?php
require('config.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');

// read data from postgresql
$query = 'SELECT * FROM task_manager.tasks';
$result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());

var_dump($result);
// print data
$data = array();
