<?php 
session_start();

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
		textarea {
			display: block;
			height: auto;
			width: 600px;
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
			font-family: Arial, Helvetica, sans-serif;
		}

	</style>
</head>
<body>
	<?php include('links.php'); ?>
	<h1>Write your post here</h1>
	<div class="fields">
		<form action="handleForm.php" method="POST">
			<textarea name="postDescription" id="" rows="4" cols="50"></textarea>
			<input type="submit" value="Submit" name="makePostBtn">
		</form>
	</div>
</body>
</html>