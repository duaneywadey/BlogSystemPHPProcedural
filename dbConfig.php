<?php 

$host = "localhost";
$user = "root";
$password = "";
$dbname = "test";
$dsn = "mysql:host={$host};dbname={$dbname}";

try {
	$conn = new PDO($dsn, $user, $password);
	$conn->exec("SET time_zone = '+08:00';");

} catch (PDOException $e) {
	die("Error : ".$e->getMessage());
}

?>