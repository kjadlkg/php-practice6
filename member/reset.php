<?php
include "../resource/db.php";

$email = isset($_GET["email"]) ? trim($_GET["email"]) : "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   $email = $_POST["email"];
   $new_password = $_POST["new_password"] ?? "";
   $confirm_password = $_POST["confirm_password"] ?? "";

   if (empty($new_password) || empty($confirm_password)) {
      $message = "빈칸이 존재합니다.";
   } else if ($new_password !== $confirm_password) {
      $message = "비밀번호가 일치하지 않습니다.";
   } else {
      // 이메일로 사용자 검색
      $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 1) {
         $user = $result->fetch_assoc();
         $hashed_pw = password_hash($new_password, PASSWORD_DEFAULT);

         // 비밀번호 업데이트
         $update_stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
         $update_stmt->bind_param("si", $hashed_pw, $user['id']);
         if ($update_stmt->execute()) {
            echo "<script>alert('비밀번호가 변경되었습니다. 다시 로그인해주세요.'); location.href='login.php';</script>";
            exit;
         }
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
         <img src="https://static.xx.fbcdn.net/rsrc.php/y1/r/4lCu2zih0ca.svg" alt="facebook">
      </div>
   </div>
   <div class="forgot_wrap">
      <div class="account_search">
         <div class="head">
            <h3>비밀번호 재설정</h3>
         </div>
         <form method="post">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            <div class="forgot_input first">
               <input type="password" class="input_text" name="new_password" placeholder="새 비밀번호" minlength="8"
                  maxlength="30">
            </div>
            <div class="forgot_input second">
               <input type="password" class="input_text" name="confirm_password" placeholder="새 비밀번호 확인" minlength="8"
                  maxlength="30">
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
                     <button type="submit">변경</button>
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