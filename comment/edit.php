<?php
require_once "../resource/require_login.php";
include "../resource/db.php";

$comment_id = (int) $_POST['comment_id'];
$content = trim($_POST['content']);
$user_id = $_SESSION['id'];

// 수정 권한 확인
$stmt = $db->prepare("SELECT user_id FROM comments WHERE id = ?");
$stmt->bind_param("i", $comment_id);
$stmt->execute();
$result = $stmt->get_result();
$comment = $result->fetch_assoc();

if (!$comment || $comment['user_id'] != $user_id) {
   echo "<script>alert('수정 권한이 없습니다.'); history.back();</script>";
   exit;
}

// 댓글 수정
$stmt = $db->prepare("UPDATE comments SET content = ? WHERE id = ?");
$stmt->bind_param("si", $content, $comment_id);
$stmt->execute();

header("Location: ../index.php");
exit;
?>