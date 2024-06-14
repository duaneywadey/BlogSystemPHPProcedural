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
	<div class="findFriends">
		<h1>Find friends</h1>
		<table>
			<tr>
				<th>Username</th>
				<th>Action</th>
			</tr>
			<?php $seeAllUsers = seeAllUsers($conn, $_SESSION['user_id']); ?>
			<?php foreach ($seeAllUsers as $row) { ?>
				<tr>
					<td><?php echo $row['username']; ?></td>
					<td>
						<form action="handleForm.php" method="POST">
							<input type="hidden" value="<?php echo $row['user_id']; ?>" name="friendBeingAdded">
							<input type="submit" value="Add Friend" name="addFriendBtn">
						</form>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
	<div class="addedFriends">
		<h1>Friend Requests Sent</h1>
		<table>
			<tr>
				<th>Username</th>
				<th>Friend Request Sent Date</th>
			</tr>
			<?php $seeAllAddedFriends = seeAllAddedFriends($conn, $_SESSION['user_id']); ?>
			<?php foreach ($seeAllAddedFriends as $row) { ?>
			<tr>
				<td><?php echo $row['username']; ?></td>
				<td><?php echo $row['dateFriendRequestSent']; ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
</body>
</html>