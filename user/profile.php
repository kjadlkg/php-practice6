<?php
require_once "../resource/require_login.php";
include "../resource/db.php";

$profile_user_id = isset($_GET['user_id']) ? (int) $_GET['user_id'] : $_SESSION['id'];
$current_user_id = $_SESSION['id'];
$is_self = ($current_user_id === $profile_user_id);

// 유저 정보
$stmt = $db->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $profile_user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// 팔로우 여부
$is_following = false;
if (!$is_self) {
   $stmt = $db->prepare("SELECT 1 FROM follows WHERE follower_id = ? AND followee_id = ?");
   $stmt->bind_param("ii", $current_user_id, $profile_user_id);
   $stmt->execute();
   $is_following = $stmt->get_result()->num_rows > 0;
}

// 유저 게시글
$stmt = $db->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $profile_user_id);
$stmt->execute();
$posts = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>프로필</title>
</head>

<body>
   <a href="../index.php">뒤로</a>
   <a href="profile.php"><?= htmlspecialchars($_SESSION['username']) ?></a>
   <a href="member/logout.php">로그아웃</a>
   <h2><?= htmlspecialchars($user['username']) ?>님의 프로필</h2>

   <?php if (!$is_self): ?>
      <a href="follow.php?user_id=<?= $profile_user_id ?>">
         <?= $is_following ? "언팔로우" : "팔로우" ?>
      </a>
   <?php endif; ?>

   <h3>게시물</h3>
   <ul>
      <?php while ($row = $posts->fetch_assoc()): ?>
         <li>
            <?= htmlspecialchars($row['content']) ?>
            <?php if ($row['image']): ?>
               <img src="../uploads/<?= $row['image'] ?>" width="200">
            <?php endif; ?>
         </li>
      <?php endwhile; ?>
   </ul>
</body>

</html>