<?php
require_once __DIR__ . "/../resource/require_login.php";
include __DIR__ . "/../resource/db.php";

header('Content-Type: application/json; charset-utf-8');

$user_id = $_SESSION['id'] ?? null;
$success = false;

$stmt = $db->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0");
$stmt->bind_param("i", $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
   $success = true;
}

echo json_encode(['success' => $success]);
?>