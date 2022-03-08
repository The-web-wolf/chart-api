<?php
require('config.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');

// connect to postgresql and handle errors
$conn = pg_connect("host=$db_host port=$db_port dbname=$db_name user=$db_user password=$db_pass") or die('Could not connect: ' . pg_last_error());

// read data from postgresql
$query = "SELECT * FROM report";
$result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());

// create object of results
$receipts = array();

$rows_count = pg_num_rows($result);
for ($i = 0; $i < $rows_count; $i++) {
  $row = pg_fetch_assoc($result);
  // check if value of expense_type is already in receipts array
  if (!in_array($row['expense_type'], $receipts)) {
    $row_extract = array(
      'expense' => $row['expense'],
      'expense_date' => $row['expense_date'],
      'amount' => $row['amount']
    );
    $receipts[$row['expense_type']][] = $row_extract;
  }
}


// loop through receipts array and append to each expense type

$merged_receipts = array();

foreach ($receipts as $key => $value) {
  $merged_receipts[$key] = array_reduce($value, function ($carry, $item) {
    // check if two expenses have same name
    $carry[$item['expense']][] = // add all expenses with that name
      array(
        'expense_date' => $item['expense_date'],
        'amount' => $item['amount']
      );
    return $carry;
  });
}


print_r(json_encode($merged_receipts));
