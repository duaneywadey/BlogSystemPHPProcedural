<?php 
session_start();
require_once('dbConfig.php');
require_once('functions.php');

if (isset($_POST['regBtn'])) {
	$username = $_POST['username'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	if(addUser($conn, $username, $password)) {
		header('Location: index.php');
	}
	else {
		header('Location: register.php');
	}
	
}

if (isset($_POST['loginBtn'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if(login($conn, $username, $password)) {
		header('Location: index.php');
	}
	else {
		header('Location: login.php');
	}
}

if(isset($_POST['makePostBtn'])) {
	$postDescription = $_POST['postDescription'];
	$user_id = $_SESSION['user_id'];
	$query = "INSERT INTO posts (description, user_posted) VALUES(?,?)";
	$stmt = $conn->prepare($query);
	$stmt->execute([$postDescription, $user_id]);
	header('Location: index.php');
}

if (isset($_POST['updatePostBtn'])) {
	$postDescription = $_POST['postDescription'];
	updateAPost($conn, $postDescription, $_GET['post_id']);
	header('Location: allYourPosts.php');
}

if(isset($_POST['deletePostBtn'])) {
	deleteAPost($conn, $_GET['post_id']);
	header('Location: allYourPosts.php');
}

if (isset($_POST['addCommentBtn'])) {
	
	$commentDescription = $_POST['commentDescription'];

	if(!empty($commentDescription)) {
		addAComment($conn, $_GET['post_id'], $_SESSION['user_id'], $commentDescription);
		header("Location: comments.php?post_id=" . $_GET['post_id']);
	}

	else {
		echo "<h2>Please don't leave the field empty</h2>
		<a href=comments.php?post_id=" . $_GET['post_id'] . ">Return</a>";
	}
	
}

if(isset($_POST['updateCommentBtn'])) {
	$newCommentDescription = $_POST['newCommentDescription'];
	editComment($conn, $newCommentDescription, $_GET['comment_id']);
	header("Location: comments.php?post_id=" . $_GET['post_id']);

}

if (isset($_POST['deleteCommentBtn'])) {
	deleteAComment($conn, $_GET['comment_id']);
	header("Location: comments.php?post_id=" . $_GET['post_id']);

}
?>