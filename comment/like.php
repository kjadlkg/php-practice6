<?php
require_once "../resource/require_login.php";
include "../resource/db.php";

$comment_id = (int) $_GET['comment_id'];
$user_id = $_SESSION['id'];

// 댓글 작성자 확인
$owner_stmt = $db->prepare("SELECT user_id FROM comments WHERE id = ?");
$owner_stmt->bind_param("i", $comment_id);
$owner_stmt->execute();
$owner_result = $owner_stmt->get_result()->fetch_assoc();
$comment_owner = $owner_result['user_id'] ?? null;

// 기존 좋아요 확인
$stmt = $db->prepare("SELECT id FROM comment_likes WHERE comment_id = ? AND user_id = ?");
$stmt->bind_param("ii", $comment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
   // 좋아요 취소
   $db->query("DELETE FROM comment_likes WHERE comment_id = $comment_id AND user_id = $user_id");
} else {
   // 좋아요 추가
   $stmt = $db->prepare("INSERT INTO comment_likes (comment_id, user_id) VALUES (?, ?)");
   $stmt->bind_param("ii", $comment_id, $user_id);
   $stmt->execute();

   // 본인 댓글 제외 알림 전송
   if ($comment_owner && $comment_owner != $user_id) {
      $message = $_SESSION['username'] . "님이 당신의 댓글에 좋아요를 눌렀습니다.";
      $noti_stmt = $db->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
      $noti_stmt->bind_param("is", $comment_owner, $message);
      $noti_stmt->execute();
   }
}

header("Location: ../index.php");
exit;
?>