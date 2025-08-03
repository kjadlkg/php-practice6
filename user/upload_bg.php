<?php
session_start();
include "../resource/db.php";

if (!isset($_SESSION['id'])) {
   echo "<script>alert('권한이 없습니다.'); history.back();</script>";
   exit;
}

$user_id = $_SESSION['id'];

if (isset($_FILES['background']) && $_FILES['background']['error'] === 0) {
   $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
   if (!in_array($_FILES['background']['type'], $allowed_types)) {
      echo "<script>alert('허용되지 않는 파일 형식입니다.'); history.back();</script>";
      exit;
   }

   $ext = pathinfo($_FILES['background']['name'], PATHINFO_EXTENSION);
   $filename = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
   $target = "../uploads/bg/" . $filename;
   if (move_uploaded_file($_FILES['background']['tmp_name'], $target)) {
      $stmt = $db->prepare("UPDATE users SET background = ? WHERE id = ?");
      $stmt->bind_param("si", $filename, $user_id);
      $stmt->execute();
   }
}

header("Location: profile.php");
exit;
?>