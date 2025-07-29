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
</head>

<body>
   <a href="../login.php">뒤로</a>
   <h3>내 계정 찾기</h3>
   <form method="post">
      <p>계정을 검색하려면 이메일 주소를 입력하세요.</p>
      <input type="email" name="email" placeholder="이메일 주소" minlength="5" maxlength="30">
      <button type="submit">확인</button>
   </form>

   <?php if ($message): ?>
      <p><?= $message ?></p>
   <?php endif; ?>
</body>

</html>