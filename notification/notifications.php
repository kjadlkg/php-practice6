<?php
require_once __DIR__ . "/../resource/require_login.php";
include __DIR__ . "/../resource/db.php";

header('Content-Type: application/json; charset-utf-8');

$user_id = $_SESSION['id'];

$stmt = $db->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$notifications = $stmt->get_result();
?>

<div class="noti_wrap">
   <div class="head">
      <h3>알림</h3>
   </div>
   <div class="noti_head">
      <h4>이전 알림</h4>
      <button type="button" id="noti_all_read">모두 읽음</button>
   </div>
   <ul>
      <?php while ($notification = $notifications->fetch_assoc()): ?>
      <li class="notification_item" data-id="<?= $notification['id'] ?>" data-url="#">
         <?= htmlspecialchars($notification['message']) ?> (<?= $notification['created_at'] ?>)
         <?php if (!$notification['is_read']): ?>
         <button type="button" class="noti_read">확인</button>
         <?php endif; ?>
      </li>
      <?php endwhile; ?>
   </ul>
</div>