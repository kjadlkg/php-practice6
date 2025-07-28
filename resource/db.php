<?php
$db = new mysqli("localhost", "root", "", "facebook-clone");

if ($db->connect_error) {
   die("DB 연결 실패: " . $db->connect_error);
}
?>