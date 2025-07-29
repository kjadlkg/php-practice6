<?php
include "../resource/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   $username = trim($_POST["username"]);
   $email = trim($_POST["email"]);
   $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

   $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
   $stmt->bind_param("sss", $username, $email, $password);
   $stmt->execute();

   echo "<script>alert('회원가입이 완료되었습니다.'); location.href='login.php';</script>";
   exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>회원가입</title>
</head>

<body>
   <a href="../login.php">뒤로</a>
   <form method="post">
      <input type="text" name="username" placeholder="이름" minlength="2" maxlength="10">
      <input type="email" name="email" placeholder="이메일" minlength="5" maxlength="30">
      <input type="password" name="password" placeholder="비밀번호" minlength="8" maxlength="30">
      <button type="submit">가입하기</button>
   </form>
   <a href="login.php">이미 계정이 있으신가요?</a>
</body>

</html>