<?php
require_once "../resource/require_login.php";
include "../resource/db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>비밀번호를 잊으셨나요?</title>
</head>

<body>
   <h3>내 계정 찾기</h3>
   <form>
      <p>계정을 검색하려면 이메일 주소를 입력하세요.</p>
      <input type="email" name="email">
   </form>
</body>

</html>