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

function changePassword($conn, $user_id, $password, $newPassword) {
	$sql = "SELECT * FROM users WHERE user_id=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_id]);
	$userInfo = $stmt->fetch();
	$passHash = $userInfo['password'];

	if(password_verify($password, $passHash)) {
		$newPassHash = password_hash($newPassword, PASSWORD_DEFAULT);
		$sql = "UPDATE users 
				SET password = ? 
				WHERE user_id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$newPassHash, $user_id]);	
	}
	else {
		return false;
	}
}


function makeAPost($conn, $description, $user_posted) {
	$sql = "INSERT INTO posts (description, user_posted) VALUES(?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$description, $user_posted]);
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

function addNewLikeToPost($conn, $post_id, $user_id) {

	$sql = "
			SELECT * FROM likesfromposts 
			WHERE post_id = ? AND user_id = ?
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$post_id, $user_id]);

	if($stmt->rowCount()==0) {
		$sql = "
			INSERT INTO likesfromposts (post_id,user_id)
			VALUES(?,?)
			";
		$stmt = $conn->prepare($sql);
		return $stmt->execute([$post_id, $user_id]);
	}
	else {
		return false;
	}
	
}

function unlikeAPost($conn, $post_id, $user_id) {
	$sql = "
			DELETE FROM likesfromposts
			WHERE post_id = ? AND user_id = ?
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$post_id, $user_id]);
}

function countNumOfLikes($conn, $post_id) {
	$sql = "
			SELECT COUNT(*) AS like_count
			FROM likesfromposts
			WHERE post_id = ?
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$post_id]);
	return $stmt->fetchAll();
}

function usersWhoLiked($conn, $post_id) {
	$sql = "
			SELECT 
				u.username AS username, 
				l.date_added AS date_added
			FROM users u
			JOIN likesfromposts l 
			ON u.user_id = l.user_id
			WHERE l.post_id = ?
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$post_id]);
	return $stmt->fetchAll();
}

function seeAllUsers($conn, $user_id)
{
	$sql = "SELECT * FROM users WHERE NOT user_id =?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_id]);
	return $stmt->fetchAll();
}

function sendAFriendRequest($conn, $userWhoAdded, $userBeingAdded)
{
	$sql = "INSERT INTO friends (userWhoAdded, userBeingAdded) VALUES(?,?)";
	$stmt = $conn->prepare($sql);
	return $stmt->execute([$userWhoAdded, $userBeingAdded]);
}

function seeAllAddedFriends($conn, $userWhoAdded)
{
	$sql = "SELECT 
				users.username AS username, 
				friends.userBeingAdded AS userBeingAdded, 
				friends.dateFriendRequestSent AS dateFriendRequestSent
			FROM users
			JOIN friends ON friends.userBeingAdded = users.user_id
			WHERE friends.userWhoAdded = ?
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$userWhoAdded]);
	return $stmt->fetchAll();
}

function seeAllFriendRequests($conn, $userBeingAdded)
{
	$sql = "SELECT
				friends.friend_id AS friend_id,
				users.username AS username,
				friends.userWhoAdded AS userWhoAdded,
				friends.dateFriendRequestSent AS dateFriendRequestSent
			FROM users
			JOIN friends ON friends.userWhoAdded = users.user_id
			WHERE friends.userBeingAdded = ? AND friends.isAccepted = 0
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$userBeingAdded]);
	return $stmt->fetchAll();
}

function acceptAFriendRequest($conn, $friend_id)
{
	$sql = "UPDATE friends SET isAccepted = 1 WHERE friend_id = ?";
	$stmt = $conn->prepare($sql);
	return $stmt->execute([$friend_id]);
}

function seeAllFriends($conn, $user_id)
{
	$sql = "SELECT
				users.username AS username,
				friends.userWhoAdded AS userWhoAdded,
				friends.dateFriendRequestSent AS dateFriendRequestSent
			FROM users
			JOIN friends ON friends.userWhoAdded = users.user_id
			WHERE friends.userBeingAdded = ? AND friends.isAccepted = 1
			UNION
			SELECT
				users.username AS username,
				friends.userBeingAdded AS userBeingAdded,
				friends.dateFriendRequestSent AS dateFriendRequestSent
			FROM users
			JOIN friends ON friends.userBeingAdded = users.user_id
			WHERE friends.userWhoAdded = ? AND friends.isAccepted = 1
			";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_id, $user_id]);
	return $stmt->fetchAll();
}


?>