<?php 
session_start();

require_once('dbConfig.php');
require_once('functions.php');

if(!isset($_SESSION['username'])) {
	header('Location: login.php');
}


// if(isset($_SESSION['userInfo'])) {
// 	$userInfo = $_SESSION['userInfo'];
// 	foreach ($userInfo as $key => $value) {
// 		echo $key . " - " . $value . "<br>";
// 	}
// }

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
		}

		.fields input {
			display: block;
			height: auto;
			width: 500px;
			margin-top: 10px;
			font-size: 2em;
		}
		#submitBtn {
			margin-top: 10px;
			height: auto;
			width: 300px;
			font-size: 2em;
		}
		#greeting {
			font-family: Arial, Helvetica, sans-serif;
		}

	</style>
</head>
<body>
	<div id="greeting">
		<h1>Hello there,
		<?php if(isset($_SESSION['username'])) { 
			echo $_SESSION['username'];
		}?>
		</h1>
	</div>
	<?php include('links.php'); ?>
	<div id="table">
		<table>
			<tr>
				<td>Description</td>
				<td>Posted By</td>
				<td>Date Posted</td>
				<td>Last Updated</td>
			</tr>
			<?php $allPosts = getAllPosts($conn); ?>
			<?php foreach ($allPosts as $row) { ?>
			<tr>
				<td>
					<a href="comments.php?post_id=<?php echo $row['post_id'] ?>">
					<?php echo $row['description']; ?>
					</a>
				</td>
				<td><?php echo $row['user_posted']; ?></td>
				<td><?php echo $row['date_posted']; ?></td>
				<td><?php echo $row['last_updated']; ?></td>
			</tr>
			<?php }?>
		</table>
	</div>
</body>
</html>