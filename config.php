<?php 
// require('vendor/autoload.php');
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();
error_reporting(E_ALL);
die('test');

// extract config variables from environment variables
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];
$db_port = $_ENV['DB_PORT'];

// connect to postgresql and handle errors
$conn = pg_connect("host=$db_host port=$db_port dbname=$db_name user=$db_user password=$db_pass") or die('Could not connect: ' . pg_last_error());
