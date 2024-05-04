<?php 

function addUser($conn, $username, $password) {
	$sql = "SELECT * FROM users WHERE username=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$username]);

	if($stmt->rowCount()==0) {
		$sql = "INSERT INTO users (username,password) VALUES (?,?)";
		$stmt = $conn->prepare($sql);
		return $stmt->execute([$username, $password]);
	}
}

function login($conn, $username, $password) {
	$query = "SELECT * FROM users WHERE username=?";
	$stmt = $conn->prepare($query);
	$stmt->execute([$username]);

	if($stmt->rowCount() == 1) {
		// returns associative array
		$row = $stmt->fetch();

		// store user info as a session variable
		$_SESSION['userInfo'] = $row;

		// get values from the session variable
		$uid = $row['user_id'];
		$uname = $row['username'];
		$passHash = $row['password'];

		// validate password 
		if(password_verify($password, $passHash)) {
			$_SESSION['user_id'] = $uid;
			$_SESSION['username'] = $uname;
			$_SESSION['email'] = $email;
			$_SESSION['userLoginStatus'] = 1;
			return true;
		}
		else {
			return false;
		}
	}
}

function getAllPosts($conn) {
	$sql = "
			SELECT 
				u.username AS user_posted, 
				p.post_id AS post_id,
				p.description AS description,
				p.date_posted AS date_posted,
				p.last_updated AS last_updated
			FROM users u
			JOIN posts p ON 
			u.user_id = p.user_posted
			ORDER BY date_posted DESC
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll();
}

function getAllPostsByUser($conn, $user_logged_in) {
	$sql = "
			SELECT
				u.user_id AS user_id, 
				u.username AS user_posted, 
				p.post_id AS post_id,
				p.description AS description,
				p.date_posted AS date_posted,
				p.last_updated AS last_updated
			FROM users u
			JOIN posts p ON 
			u.user_id = p.user_posted 
			WHERE u.user_id = ?
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_logged_in]);
	return $stmt->fetchAll();
}

function getPostByID($conn, $post_id) {
	$sql = "
			SELECT
				u.user_id AS user_id,
				u.username AS username,
				p.post_id AS post_id,
				p.description AS description,
				p.date_posted AS date_posted
			FROM posts p
			JOIN users u ON
			p.user_posted = u.user_id 
			WHERE post_id = ?
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$post_id]);
	return $stmt->fetchAll();
}

function updateAPost($conn, $new_description, $post_id) {
	$sql = "
			UPDATE posts
			SET description =?, last_updated=?
			WHERE post_id = ?
			";
	$now = new DateTime(null, new DateTimeZone('Asia/Manila'));
	$timeNow = $now->format('Y-m-d H:i:s'); 
	$stmt = $conn->prepare($sql);
	$stmt->execute([$new_description, $timeNow, $post_id]);
}

function deleteAPost($conn, $post_id) {
	$sql = "
			DELETE FROM posts
			WHERE post_id = ?
			";
	
	$stmt = $conn->prepare($sql);
	$stmt->execute([$post_id]);
}


function addAComment($conn, $post_id, $user_id, $commentDescription) {
	$sql = "
			INSERT INTO comments (post_id, user_id, description)
			VALUES (?,?,?)
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$post_id, $user_id, $commentDescription]);
}

function allCommentsByPost($conn, $post_id) {
	$sql = "
			SELECT 
				c.user_id AS user_id,
				c.comment_id AS comment_id,
				c.description AS description,
				c.date_added AS date_added,
				u.username AS username
			FROM comments c 
			JOIN users u ON 
			c.user_id = u.user_id
			WHERE post_id = ?
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$post_id]);
	return $stmt->fetchAll();
}

function getCommentByID($conn, $comment_id){
	$sql = "
		SELECT
			description
		FROM comments
		WHERE comment_id = ? 
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$comment_id]);
	return $stmt->fetchAll();
}


function editComment($conn, $new_comment_description, $comment_id) {
	$sql = "
			UPDATE comments
			SET description = ?
			WHERE comment_id = ?
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$new_comment_description, $comment_id]);
}

function deleteAComment($conn, $comment_id) {
	$sql = "
			DELETE FROM comments
			WHERE comment_id = ?
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$comment_id]);
}


?>