<?php
require_once "../resource/require_login.php";
include "../resource/db.php";

$id = (int) $_GET['id'];
$user_id = $_SESSION['id'];

$stmt = $db->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();

header("Location: notifications.php");
exit;
?>