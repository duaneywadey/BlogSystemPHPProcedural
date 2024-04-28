<?php 
session_start();

require_once('dbConfig.php');
require_once('functions.php');

if(!isset($_SESSION['username'])) {
	header('Location: login.php');
}

// if(isset($_GET['post_id'])) {
// 	echo "<h2>Post ID: " . $_GET['post_id'] . "</h2>";
// }


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

		textarea {
			display: block;
			height: 150px;
			width: 600px;
			margin-top: 10px;
			font-size: 1em;
		}

		#submitBtn {
			margin-top: 10px;
			height: auto;
			width: 200px;
			font-size: 1.5em;
		}
		#greeting {
			font-family: Arial, Helvetica, sans-serif;
		}
	</style>
</head>
<body>
	<?php include 'links.php'; ?>
	<?php 
	$post = getPostByID($conn, $_GET['post_id']);
	foreach ($post as $row) {
	?>
	<div class="postSection" style="border: solid 4px;">
		<h1><?php echo $row['username']; ?></h1>
		<p><i><?php echo $row['date_posted'];?></i></p>
		<p><?php echo $row['description']; ?></p>
	</div>
	<div class="commentSection">
		<p>Add a comment here</p>
		<form action="#">
			<textarea name="comment" id=""></textarea>
			<input type="submit" id="submitBtn" value="Submit">
		</form>
		<h2>All Comments</h2>
	</div>
	<?php } ?>
	<div class="commentBox" style="width: 50%;border-style: solid; border-color: gray;">
		<h3>User</h3>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa nesciunt id natus nostrum, blanditiis assumenda ipsa, nihil voluptatum sint aliquam necessitatibus. Eius fugit, eligendi aspernatur nihil consequuntur rem provident, dignissimos.</p>
	</div>
</body>
</html>