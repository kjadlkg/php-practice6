<?php
require_once __DIR__ . "/../resource/require_login.php";
include __DIR__ . "/../resource/db.php";

$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];

if ($keyword !== '') {
   $search = "%{$keyword}%";
   $stmt = $db->prepare("SELECT id, username, profile_image FROM users WHERE username LIKE ?");
   $stmt->bind_param("s", $search);
   $stmt->execute();
   $results = $stmt->get_result();
}
?>

<div class="search_wrap">
   <div class="head">
      <h3>사용자 검색</h3>
   </div>
   <div class="search">
      <form id="searchForm" method="get" action="search/search.php">
         <input type="text" name="q" placeholder="사용자 이름" value="<?= htmlspecialchars($keyword) ?> ">
         <button type="submit">검색</button>
      </form>
   </div>
   <div class="search_reasult">
      <?php if ($keyword !== ''): ?>
         <div class="head">
            <h4>검색 결과</h4>
         </div>
         <?php if ($results->num_rows > 0): ?>
            <ul>
               <?php while ($user = $results->fetch_assoc()): ?>
                  <li>
                     <a href="user/profile.php?user_id=<?= $user['id'] ?>">
                        <img src="uploads/profile/<?= $user['profile_image'] ?? 'default_profile.png' ?>" alt="프로필 이미지">
                        <?= htmlspecialchars($user['username']) ?>
                     </a>
                  </li>
               <?php endwhile; ?>
            </ul>
         <?php else: ?>
            <p>일치하는 사용자가 없습니다.</p>
         <?php endif; ?>
      <?php endif; ?>
   </div>
</div>