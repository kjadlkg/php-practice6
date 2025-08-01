<?php
session_start();
if (!isset($_SESSION['id'])) {
   echo "<script>location.href='member/login.php';</script>";
   exit;
}
?>