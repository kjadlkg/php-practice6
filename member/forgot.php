<?php
include "../resource/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   $email = trim($_POST["email"]);

   // 이메일 유효성 검사
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $message = "유효한 이메일 형식을 입력해주세요.";
   } else {
      // 이메일로 사용자 검색
      $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 1) {
         header("Location: reset.php?email=" . urlencode($email));
         exit;
      } else {
         $message = "해당 이메일로 가입된 계정이 없습니다.";
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>비밀번호를 잊으셨나요?</title>
   <link rel="stylesheet" href="../css/reset.css">
   <link rel="stylesheet" href="../css/member.css">
</head>

<body>
   <div class="banner">
      <div class="logo">
         <a href="../index.php">
            <img src="https://static.xx.fbcdn.net/rsrc.php/y1/r/4lCu2zih0ca.svg" alt="facebook">
         </a>
      </div>
   </div>
   <div class="forgot_wrap">
      <div class="account_search">
         <div class="head">
            <h3>내 계정 찾기</h3>
         </div>
         <div class="content">
            <p>계정을 검색하려면 이메일 주소를 입력하세요.</p>
         </div>
         <form method="post">
            <div class="forgot_input">
               <input type="email" class="input_text" name="email" placeholder="이메일 주소" minlength="5" maxlength="30">
            </div>
            <div class="forgot_btn">
               <div class="clearfix">
                  <div class="message">
                     <?php if ($message): ?>
                        <p><?= $message ?></p>
                     <?php endif; ?>
                  </div>
                  <div class="fr">
                     <button type="button" onclick="location.href='login.php'">취소</button>
                     <button type="submit">확인</button>
                  </div>
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