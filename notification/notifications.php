<?php
require_once "../resource/require_login.php";
include "../resource/db.php";

$user_id = $_SESSION['id'];

$stmt = $db->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$notifications = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>내 알림</title>
</head>

<body>
   <h2>내 알림</h2>
   <a href="../index.php">뒤로</a>
   <ul>
      <?php while ($notification = $notifications->fetch_assoc()): ?>
         <li>
            <?= htmlspecialchars($notification['message']) ?> (<?= $notification['created_at'] ?>)
            <?php if (!$notification['is_read']): ?>
               <a href="read.php?id=<?= $notification['id'] ?>">확인</a>
            <?php endif; ?>
         </li>
      <?php endwhile; ?>
   </ul>

</body>

</html>