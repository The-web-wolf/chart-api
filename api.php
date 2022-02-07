<?php
require('config.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');


// $expense_type = 'energy';
// $expense = 'electricity';
// $expense_date = '2018-01-01';
// $expense_amount = 100;

// // insert data into database
// $query = "INSERT INTO report (expense_type, expense, expense_date, amount) VALUES ('$expense_type', '$expense', '$expense_date', '$expense_amount')";

// $run = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());


// read data from postgresql
$query = "SELECT * FROM report";
$result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());

// create object of results
$receipts = array();

$rows_count = pg_num_rows($result);
for ($i = 0; $i < $rows_count; $i++) {
    $row = pg_fetch_assoc($result);
   // check if value of expense_type is already in receipts array
    if(!in_array($row['expense_type'], $receipts)) {
      $row_extract = array(
        'expense' => $row['expense'],
        'expense_date' => $row['expense_date'],
        'amount' => $row['amount']
      );
      $receipts[$row['expense_type']][] = array(
        'name' => $row['expense_type'],
        'value' => array($row_extract)
      );
      
    }
}


$receipts = json_encode([$receipts]);
print($receipts);
