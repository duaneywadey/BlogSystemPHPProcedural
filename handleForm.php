<?php 
session_start();
require_once('dbConfig.php');
require_once('functions.php');

if (isset($_POST['regBtn'])) {
	$username = $_POST['username'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	if(empty($username) || empty($password)) {
		echo '<script> 
		alert("The input field is empty!");
		window.location.href = "register.php";
		</script>';
	}
	
	else {

		if(addUser($conn, $username, $password)) {
			header('Location: index.php');
		}

		else {
			header('Location: register.php');
		}

	}
}

if (isset($_POST['loginBtn'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) && empty($password)) {
		echo "<script>
		alert('Input fields are empty!');
		window.location.href='index.php'
		</script>";
	} 
	else {

		if(login($conn, $username, $password)) {
			header('Location: index.php');
		}

		else {
			header('Location: login.php');
		}
	}
	
}

if(isset($_POST['makePostBtn'])) {
	
	$postDescription = $_POST['postDescription'];
	$user_id = $_SESSION['user_id'];

	if(empty($postDescription)) {
		echo "<script>
		alert('Post is empty'); 
		window.location.href='makePost.php'
		</script>";
	}
	else {
		makeAPost($conn, $postDescription, $user_id);
		header('Location: index.php');
	}
	
}

if (isset($_POST['updatePostBtn'])) {
	
	$postDescription = $_POST['postDescription'];

	if(empty($postDescription)) {
		echo "<script>
		alert('Post is empty'); 
		window.location.href='editPost.php?post_id=" . $_GET['post_id'] . "'
		</script>";
	}
	else {
		updateAPost($conn, $postDescription, $_GET['post_id']);
		header('Location: allYourPosts.php');
	}
	
}

if(isset($_POST['deletePostBtn'])) {
	deleteAPost($conn, $_GET['post_id']);
	header('Location: allYourPosts.php');
}

if (isset($_POST['addCommentBtn'])) {
	
	$commentDescription = $_POST['commentDescription'];

	if(empty($commentDescription)) {
		echo '<script> 
		alert("The input field is empty!");
		window.location.href = "comments.php?post_id=' . $_GET['post_id'] . '";
		</script>';
	}
	else {
		addAComment($conn, $_GET['post_id'], $_SESSION['user_id'], $commentDescription);
		header("Location: comments.php?post_id=" . $_GET['post_id']);
	}


}

if(isset($_POST['updateCommentBtn'])) {
	
	$newCommentDescription = $_POST['newCommentDescription'];

	if(empty($newCommentDescription)) {
		echo '<script>
		alert("The input field is empty!")
		window.location.href = "comments.php?post_id=' . $_GET['post_id'] .'
		"</script>';
	}
	else {
		editComment($conn, $newCommentDescription, $_GET['comment_id']);
		header("Location: comments.php?post_id=" . $_GET['post_id']);
	}

}

if (isset($_POST['deleteCommentBtn'])) {
	deleteAComment($conn, $_GET['comment_id']);
	header("Location: comments.php?post_id=" . $_GET['post_id']);

}

?>