<?php 

$host = "localhost";
$user = "root";
$password = "";
$dbname = "test";
$dsn = "mysql:host={$host};dbname={$dbname}";

$conn = new PDO($dsn, $user, $password);
$conn->exec("SET time_zone = '+08:00';");

$now = new DateTime(null, new DateTimeZone('Asia/Manila'));
$timeNow = $now->format('Y-m-d H:i:s');


?>