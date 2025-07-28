<?php
require_once "../resource/require_login.php";
include "../resource/db.php";

$post_id = (int) $_POST['post_id'];
$user_id = $_SESSION['id'];
$content = trim($_POST['content']);

$stmt = $db->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $post_id, $user_id, $content);
$stmt->execute();

// 알림 생성
// 게시글 작성자 확인
$post_stmt = $db->prepare("SELECT user_id FROM posts WHERE id = ?");
$post_stmt->bind_param("i", $post_id);
$post_stmt->execute();
$post_result = $post_stmt->get_result();
$post = $post_result->fetch_assoc();

// 본인 댓글 제외
if ($post && $post['user_id'] != $user_id) {
   $message = $_SESSION['username'] . "님이 댓글을 남겼습니다.";
   $noti_stmt = $db->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
   $noti_stmt->bind_param("is", $post['user_id'], $message);
   $noti_stmt->execute();
}

header("Location: ../index.php");
exit;
?>