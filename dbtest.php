<?php  
require_once('dbConfig.php');

$stmt = $conn->prepare('SELECT * FROM posts ORDER BY date_posted DESC;');
$stmt->execute();
$queryResult = $stmt->fetch();
print_r($queryResult);

// Accessing with index
echo $queryResult[1];

// Accessing with column name
echo $queryResult['description'];

?>