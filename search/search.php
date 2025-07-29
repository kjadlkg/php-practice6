<?php
require_once "../resource/require_login.php";
include "../resource/db.php";

$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];

if ($keyword !== '') {
   $search = "%{$keyword}%";
   $stmt = $db->prepare("SELECT id, username FROM users WHERE username LIKE ?");
   $stmt->bind_param("s", $search);
   $stmt->execute();
   $results = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>사용자 검색</title>
</head>

<body>
   <h2>사용자 검색</h2>
   <form method="get">
      <input type="text" name="q" placeholder="사용자 이름" value="<?= htmlspecialchars($keyword) ?> ">
      <button type="submit">검색</button>
   </form>

   <?php if ($keyword !== ''): ?>
      <h3>검색 결과</h3>
      <?php if ($results->num_rows > 0): ?>
         <ul>
            <?php while ($user = $results->fetch_assoc()): ?>
               <li>
                  <a href="../user/profile.php?user_id=<?= $user['id'] ?>">
                     <?= htmlspecialchars($user['username']) ?>
                  </a>
               </li>
            <?php endwhile; ?>
         </ul>
      <?php else: ?>
         <p>일치하는 사용자가 없습니다.</p>
      <?php endif; ?>
   <?php endif; ?>
</body>

</html>