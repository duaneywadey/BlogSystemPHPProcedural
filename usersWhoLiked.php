<?php  
session_start();

require_once('dbConfig.php');
require_once('functions.php');

if(!isset($_SESSION['username'])) {
	header('Location: login.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
		body {
			font-family: 'Arial';
			font-size: 2em;
		}

		table, th, td{
			border: 1px solid black;
			width: 50%;
		}
	</style>
</head>
<body>

<table>
	<tr>
		<th>Username</th>
		<th>Date Added</th>
	</tr>
<?php  
if(isset($_GET['post_id'])) {
	$usersWhoLiked = usersWhoLiked($conn, $_GET['post_id']);
	foreach ($usersWhoLiked as $row ) {
?>
	<tr>
		<td><?php echo $row['username']; ?></td>
		<td><?php echo $row['date_added']; ?></td>
	</tr>
<?php }}?>
</table>
<a href="index.php">Return</a>
</body>
</html>

