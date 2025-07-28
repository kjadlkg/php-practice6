<?php
require_once "../resource/require_login.php";
include "../resource/db.php";

$post_id = (int) $_GET['post_id'];
$user_id = $_SESSION['id'];

// 게시글 작성자 확인
$owner_stmt = $db->prepare("SELECT user_id FROM posts WHERE id = ?");
$owner_stmt->bind_param("i", $post_id);
$owner_stmt->execute();
$owner_result = $owner_stmt->get_result()->fetch_assoc();
$post_owner = $owner_result['user_id'] ?? null;

// 기존 좋아요 확인
$stmt = $db->prepare("SELECT id FROM post_likes WHERE post_id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
   // 좋아요 취소
   $db->query("DELETE FROM post_likes WHERE post_id = $post_id AND user_id = $user_id");
} else {
   // 좋아요 추가
   $stmt = $db->prepare("INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)");
   $stmt->bind_param("ii", $post_id, $user_id);
   $stmt->execute();

   // 본인 글 제외 알림 전송
   if ($post_owner && $post_owner != $user_id) {
      $message = $_SESSION['username'] . "님이 당신의 게시글에 좋아요를 눌렀습니다.";
      $noti_stmt = $db->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
      $noti_stmt->bind_param("is", $post_owner, $message);
      $noti_stmt->execute();
   }
}

header("Location: ../index.php");
exit;
?>