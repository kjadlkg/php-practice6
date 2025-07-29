<?php
require_once "../resource/require_login.php";
include "../resource/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   $user_id = $_SESSION['id'];
   $content = trim($_POST['content']);

   $image_path = null;
   if (!empty($_FILES['image']['name'])) {
      $filename = time() . '_' . basename($_FILES['image']['name']);
      $target_path = "../uploads/" . $filename;
      move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
      $image_path = $filename;
   }

   $stmt = $db->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
   $stmt->bind_param("iss", $user_id, $content, $image_path);
   $stmt->execute();

   echo "<script>alert('게시글이 등록되었습니다.'); location.href='../index.php';</script>";
   exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>글쓰기</title>
</head>

<body>
   <a href="../index.php">뒤로</a>
   <form method="post" enctype="multipart/form-data">
      <textarea name="content" autocomplete="off" maxlength="400" placeholder="일상을 공유해주세요"></textarea>
      <input type="file" name="image" placeholder="이미지 업로드">
      <button type="submit">게시하기</button>
   </form>
</body>

</html>