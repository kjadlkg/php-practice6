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
         echo "<script>alert('비밀번호가 올바르지 않습니다.'); history.back();</script>";
      }
   } else {
      echo "<script>alert('이메일을 찾을 수 없습니다.'); history.back();</script>";
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>로그인</title>
   <link rel="stylesheet" href="../css/reset.css">
   <link rel="stylesheet" href="../css/member.css">
</head>

<body>
   <div>
      <div id="login_container">
         <div class="login_wrap">
            <div class="logo_box">
               <div class="logo">
                  <a href="../index.php">
                     <img src="https://static.xx.fbcdn.net/rsrc.php/y1/r/4lCu2zih0ca.svg" alt="facebook">
                  </a>
               </div>
               <h2>facebook에서 전세계에 있는 친구, 가족, 지인들과 함께 이야기를 나눠보세요.</h2>
            </div>
            <div class="login_box">
               <form method="post">
                  <div class="login_input">
                     <input type="email" class="input_text" name="email" placeholder="이메일" minlength="5" maxlength="30">
                  </div>
                  <div class="login_input">
                     <input type="password" class="input_text" name="password" placeholder="비밀번호" minlength="8"
                        maxlength="30">
                  </div>
                  <div class="login_btn">
                     <button type="submit">로그인</button>
                  </div>
               </form>
               <div class="forgot">
                  <a href="forgot.php">비밀번호를 잊으셨나요?</a>
               </div>
               <div class="line"></div>
               <div class="login_btn_new">
                  <button type="button" onclick="location.href='register.php'">새 계정 만들기</button>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="footer">
      <div id="footer">
         kjadlkg © 2025
      </div>
   </div>
</body>

</html>