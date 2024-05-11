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
		.link-button { 
	     background: none;
	     border: none;
	     color: #1a0dab;
	     text-decoration: underline;
	     cursor: pointer; 
	     font-size: 1em;

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
		<p>
			Total likes:
			<a href="usersWhoLiked.php?post_id=<?php echo $row['post_id']; ?>">
				<?php 
				$likesArray = countNumOfLikes($conn, $row['post_id']);
				foreach ($likesArray as $like) {
					echo $like['like_count'];
				}
				?>
			</a>
		</p>
		
		<p><?php echo $row['description']; ?></p>

		<?php  

		$usersWhoLiked = usersWhoLiked($conn, $row['post_id']);
		$usersList = array(); 
		foreach ($usersWhoLiked as $user) {
			array_push($usersList, $user['username']);
		}

		?>

		<?php if(in_array($_SESSION['username'], $usersList)) { ?>
		<form action="handleForm.php?post_id=<?php echo $row['post_id']; ?>" method="POST">
			<input type="submit" name="unlikeBtn" id="submitBtn" value="Unlike">
		</form>

		<?php } else { ?>
			<form action="handleForm.php?post_id=<?php echo $row['post_id']; ?>" method="POST">
				<input type="submit" name="likeBtn" id="submitBtn" value="Like">
			</form>
		<?php } ?>

	</div>
	<div class="commentSection">
		<p>Add a comment here</p>
		<form action="handleForm.php?post_id=<?php echo $row['post_id']; ?>" method="POST">
			<textarea name="commentDescription"></textarea>
			<input type="submit" id="submitBtn" name="addCommentBtn" value="Submit">
		</form>
		<h2>All Comments</h2>
	</div>
	<?php } ?>

	<?php 
	$allComments = allCommentsByPost($conn, $_GET['post_id']);
	foreach ($allComments as $row) {
	?>
	<div class="commentBox" style="width: 50%;border-style: solid; border-color: gray; margin-top:10px;">
		<h3><?php echo $row['username']; ?></h3>
		<p><i><?php echo $row['date_added']; ?></i></p>
		<?php if($_SESSION['user_id'] == $row['user_id']) { ?>		
		<form action="handleForm.php?post_id=<?php echo $_GET['post_id']?>&comment_id=<?php echo $row['comment_id'];?>" method="POST">
			<a href="editComment.php?post_id=<?php echo $_GET['post_id']?>&comment_id=<?php echo $row['comment_id'];?>">Edit</a>
			<input type="submit" value="Delete" class="link-button" name="deleteCommentBtn">
		</form>
		<?php } ?>

		<p><?php echo $row['description']; ?></p>
	</div>
	<?php } ?>
</body>
</html>

