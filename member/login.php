<?php
include "../resource/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   $email = trim($_POST["email"]);
   $password = trim($_POST["password"]);

   $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
   $stmt->bind_param("s", $email);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($user = $result->fetch_assoc()) {
      if (password_verify($password, $user["password"])) {
         $_SESSION["id"] = $user["id"];
         $_SESSION["username"] = $user["username"];
         echo "<script>location.href='../index.php';</script>";
         exit;
      } else {
         echo "<script>alert('비밀번호가 올바르지 않습니다.');</script>";
      }
   } else {
      echo "<script>alert('이메일을 찾을 수 없습니다.');</script>";
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>로그인</title>
</head>

<body>
   <form method="post">
      <input type="email" name="email" placeholder="이메일" minlength="5" maxlength="30">
      <input type="password" name="password" placeholder="비밀번호" minlength="8" maxlength="30">
      <button type="submit">로그인</button>
   </form>
   <a href="forgot.php">비밀번호를 잊으셨나요?</a>
   <button type="button" onclick="location.href='register.php'">새 계정 만들기</button>
</body>

</html>