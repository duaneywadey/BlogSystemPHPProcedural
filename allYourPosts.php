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
			font-family: Verdana, Arial, Helvetica, sans-serif;
		}

	</style>
</head>
<body>
	<h1>Your posts</h1>
	<?php include('links.php'); ?>
	<div id="table">
		<table>
			<tr>
				<td>Description</td>
				<td>Posted By</td>
				<td>Date posted</td>
				<td>Last updated</td>
			</tr>

			<?php $allPostsByUser = getAllPostsByUser($conn, $_SESSION['user_id']); ?>
			<?php foreach ($allPostsByUser as $key) { ?>
				<tr>
					<td><a href="editPost.php?post_id=<?php echo $key['post_id']; ?>"><?php echo $key['description']; ?></a></td>
					<td><?php echo $key['user_posted']; ?></td>
					<td><?php echo $key['date_posted']; ?></td>
					<td><?php echo $key['last_updated']; ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>
</body>
</html>