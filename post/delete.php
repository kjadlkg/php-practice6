<?php
require_once "../resource/require_login.php";
include "../resource/db.php";

$post_id = (int) $_POST['post_id'];
$user_id = $_SESSION['id'];


// 삭제 권한 확인
$stmt = $db->prepare("SELECT user_id, image FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post || $post['user_id'] != $user_id) {
   echo "<script>alert('삭제 권한이 없습니다.'); history.back();</script>";
   exit;
}

// 게시글에 이미지가 있으면 삭제
if (!empty($post['image'])) {
   $file_path = "../uploads/" . $post['image'];
   if (file_exists($file_path)) {
      unlink($file_path);
   }
}

// 게시글 삭제
$stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();

echo "<script>alert('게시글이 삭제되었습니다.'); location.href='../index.php';</script>";
exit;
?>