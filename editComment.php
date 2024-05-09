<?php 
session_start();
require_once('functions.php');
require_once('dbConfig.php');


if(!isset($_SESSION['username'])) {
	header('Location: login.php');
}

if (isset($_GET['comment_id'])) {
	echo "<h1>" . $_GET['comment_id'] . "</h1>";
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
		textarea {
			display: block;
			height: auto;
			width: 1000px;
			margin-top: 10px;
			font-size: 2em;
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
	<h1>Edit the comment here</h1>
	<?php $commentByID = getCommentByID($conn, $_GET['comment_id']); ?>
	<?php foreach ($commentByID as $row) { ?>
	<div class="fields">
		<form action="handleForm.php?post_id=<?php echo $_GET['post_id']?>&comment_id=<?php echo $_GET['comment_id']; ?>" method="POST">
			<textarea name="newCommentDescription" id="" rows="4"><?php echo $row['description']; ?>
			</textarea>
			<input type="submit" value="Submit" name="updateCommentBtn">
		</form>
	</div>
	<?php } ?>

</body>
</html>