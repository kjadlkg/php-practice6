<?php
require_once __DIR__ . "/../resource/require_login.php";
include __DIR__ . "/../resource/db.php";

$user_id = $_SESSION['id'];
$username = $_SESSION['username'];

$stmt = $db->prepare("SELECT profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   $content = trim($_POST['content']);
   $content = strip_tags($content);

   if (!$content && empty($_FILES['image']['name'])) {
      echo "<script>alert('내용을 작성해주세요.'); history.back(); </script>";
      exit;
   }

   $image_path = null;
   if (!empty($_FILES['image']['name'])) {
      $filename = time() . '_' . basename($_FILES['image']['name']);
      $target_path = __DIR__ . "/../uploads/post/" . $filename;
      move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
      $image_path = $filename;
   }

   $stmt = $db->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
   $stmt->bind_param("iss", $user_id, $content, $image_path);
   $stmt->execute();

   echo "<script>alert('게시글이 등록되었습니다.'); location.href='/php-practice6/index.php';</script>";
   exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>게시물 작성</title>
   <link rel="stylesheet" href="/php-practice6/css/post.css">
</head>

<body>
   <div class="post_wrap">
      <div class="head">
         <h3>게시물 작성</h3>
      </div>
      <div class="user_info">
         <div class="image">
            <a href="/php-practice6/profile.php?user_id=<?= $user_id ?>">
               <img src="/php-practice6/uploads/profile/<?= $post['profile_image'] ?? 'default_profile.png' ?>"
                  alt="프로필 이미지">
            </a>
         </div>
         <div class="user_text">
            <a href="/php-practice6/user/profile.php?user_id=<?= $user_id ?>">
               <?= htmlspecialchars($username) ?>
            </a>
         </div>
      </div>
      <form method="post" action="/php-practice6/post/write.php" enctype="multipart/form-data"
         onsubmit="return setPost(this)">
         <input type="hidden" name="content">
         <div contenteditable="true" class="post_input" data-placeholder="지금 무슨 생각을 하고 계신가요?"></div>
         <input type="file" id="imgInput" name="image">
         <div class="post_bottom_box">
            <button type="button" onclick="document.getElementById('imgInput').click();">사진 추가</button>
            <button type="submit">게시</button>
         </div>
      </form>
   </div>
</body>

</html>