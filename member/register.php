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
   <link rel="stylesheet" href="../css/reset.css">
   <link rel="stylesheet" href="../css/member.css">
</head>

<body>
   <div id="register_container">
      <div class="logo_box">
         <div class="logo">
            <a href="../index.php">
               <img src="https://static.xx.fbcdn.net/rsrc.php/y1/r/4lCu2zih0ca.svg" alt="facebook">
            </a>
         </div>
      </div>
      <div class="register_wrap">
         <form method="post">
            <div class="title">
               <h3>새 계정 만들기</h3>
            </div>
            <div class="content">
               <div class="register_input">
                  <input type="text" class="input_text" name="username" placeholder="이름" minlength="2" maxlength="10">
               </div>
               <div class="register_input">
                  <input type="email" class="input_text" name="email" placeholder="이메일" minlength="5" maxlength="30">
               </div>
               <div class="register_input">
                  <input type="password" class="input_text" name="password" placeholder="비밀번호" minlength="8"
                     maxlength="30">
               </div>
               <div class="register_btn">
                  <button type="submit">가입하기</button>
               </div>
               <div class="go_login">
                  <a href="login.php">이미 계정이 있으신가요?</a>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="footer">
      <div id="footer">
         kjadlkg © 2025
      </div>
   </div>
</body>

</html>