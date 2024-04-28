<?php 
session_start();

if(isset($_SESSION['welcomeMessage']) && !isset($_SESSION['username'])) {
	echo $_SESSION['welcomeMessage'];
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
	</style>
</head>
<body>
	<p>Login here</p>
	<form action="handleForm.php" method="POST">
		<div class="fields">
			<input type="text" placeholder="username here" class="fields" name="username">
			<input type="password" placeholder="password here" class="fields" name="password">
			<input type="submit" value="login" id="loginBtn" name="loginBtn">
		</div>
	</form>
	<a href="register.php">Register</a>
</body>
</html>