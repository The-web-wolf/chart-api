<?php 
error_reporting(E_ALL);
require('vendor/autoload.php');

if(file_exists(__DIR__.'/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}
// extract config variables from environment variables
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];
$db_port = $_ENV['DB_PORT'];