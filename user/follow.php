<?php
require_once "../resource/require_login.php";
include "../resource/db.php";

$follower_id = $_SESSION['id'];
$followee_id = (int) $_GET['user_id'];

$stmt = $db->prepare("SELECT * FROM follows WHERE folower_id = ? AND followee_id = ?");
$stmt->bind_param("ii", $follower_id, $followee_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
   // 언팔로우
   $stmt = $db->prepare("DELETE FROM follows WHERE folower_id =  ? AND followee_id = ?");
   $stmt->bind_param("ii", $follower_id, $followee_id);
   $stmt->execute();
} else {
   // 팔로우
   $stmt = $db->prepare("INSERT INTO follows (follower_id, followee_id) VALUES (?, ?)");
   $stmt->bind_param("ii", $follower_id, $followee_id);
   $stmt->execute();
}

header("Location: profile.php?user_id=$followee_id");
exit;
?>