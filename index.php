<?php
require_once "resource/require_login.php";
include "resource/db.php";

// 게시글 목록
$stmt = $db->prepare("
   SELECT p.*, u.username
   FROM posts p JOIN users u
   ON p.user_id = u.id
   ORDER BY p.created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>메인페이지</title>
   <link rel="stylesheet" href="css/reset.css">
   <link rel="stylesheet" href="css/member.css">
   <link rel="stylesheet" href="css/main.css">
</head>

<body>
   <div class="banner">
      <div class="logo_box">
         <div class="logo">
            <a href="index.php">
               <img src="https://static.xx.fbcdn.net/rsrc.php/y1/r/4lCu2zih0ca.svg" alt="facebook">
            </a>
         </div>
         <div class="menu">
            <a href="post/write.php">글쓰기</a>
            <a href="search/search.php">친구 찾기</a>
            <button type="button" onclick="location.href='notification/notifications.php'">
               <img src="images/icon/notifications.png" alt="알림">
            </button>
            <button type="button" onclick="location.href='user/profile.php'">
               <img src="images/icon/user.png" alt="프로필">
            </button>
            <button type="button" onclick="location.href='member/logout.php'">
               <img src="images/icon/logout.png" alt="로그아웃">
            </button>
         </div>
      </div>
   </div>
   <div class="main">
      <?php while ($post = $result->fetch_assoc()): ?>
         <div class="main_container">
            <div id="post">
               <h1 class="blind">게시글 영역</h1>
               <div class="user_info">
                  <div class="image">
                     <img src="images/icon/profile.png">
                  </div>
                  <div class="user_text">
                     <a href="user/profile.php?user_id=<?= $post['user_id'] ?>">
                        <?= htmlspecialchars($post['username']) ?>
                     </a>
                     <span><?= $post['created_at'] ?></span>
                  </div>
                  <!-- 게시글 삭제 -->
                  <div class="delete">
                     <?php if ($_SESSION['id'] == $post['user_id']): ?>
                        <form method="post" action="post/delete.php">
                           <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                           <button type="submit" onclick="return confirm('게시글을 삭제하시겠습니까?')">
                              <img src="images/icon/close.png" alt="삭제">
                           </button>
                        </form>
                     <?php endif; ?>
                  </div>
               </div>
               <div class="content">
                  <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                  <?php if ($post['image']): ?>
                     <img src="uploads/<?= htmlspecialchars($post['image']) ?>" width="200">
                  <?php endif; ?>
               </div>
               <div class="post_bottom_box">
                  <!-- 게시글 좋아요 버튼 -->
                  <form method="post" action="post/like.php?post_id=<?= $post['id'] ?>">
                     <button type="submit">
                        <img src="images/icon/like.png" alt="좋아요">
                        <?php
                        $like_stmt = $db->prepare("SELECT COUNT(*) AS cnt FROM post_likes WHERE post_id = ?");
                        $like_stmt->bind_param("i", $post['id']);
                        $like_stmt->execute();
                        $like_result = $like_stmt->get_result()->fetch_assoc();
                        ?>
                        <?= $like_result['cnt'] ?>
                        좋아요
                     </button>
                  </form>
               </div>
            </div>
            <div id="comment">
               <h1 class="blind">댓글 영역</h1>
               <div class="comment_wrap">
                  <?php
                  // 댓글 불러오기
                  $cid = $post['id'];
                  $cstmt = $db->prepare("
                     SELECT c.id, c.user_id, u.username, c.content, c.created_at, u.profile_image
                     FROM comments c JOIN users u
                     ON c.user_id = u.id
                     WHERE c.post_id = ?
                     ORDER BY c.created_at
                  ");
                  $cstmt->bind_param("i", $cid);
                  $cstmt->execute();
                  $comments = $cstmt->get_result();
                  while ($comment = $comments->fetch_assoc()): ?>
                     <div class="user_info">
                        <div class="image">
                           <img src="images/icon/profile.png">
                        </div>
                        <div class="content">
                           <div class="user_text">
                              <a href="user/profile.php?user_id=<?= $comment['user_id'] ?>">
                                 <?= htmlspecialchars($comment['username']) ?>
                              </a>
                           </div>
                           <?= htmlspecialchars($comment['content']) ?>
                        </div>
                     </div>
                     <div class="comment_bottom_box">
                        <span><?= $comment['created_at'] ?></span>
                        <!-- 댓글 좋아요 버튼 -->
                        <form method="post" action="comment/like.php?comment_id=<?= $comment['id'] ?>">
                           <button type="submit">
                              좋아요
                              <?php
                              $like_stmt = $db->prepare("SELECT COUNT(*) AS cnt FROM comment_likes WHERE comment_id = ?");
                              $like_stmt->bind_param("i", $comment['id']);
                              $like_stmt->execute();
                              $like_result = $like_stmt->get_result()->fetch_assoc();
                              ?>
                              <?= $like_result['cnt'] ?>
                           </button>
                        </form>
                        <!-- 삭제 버튼 -->
                        <div class="delete">
                           <?php if ($_SESSION['id'] == $comment['user_id']): ?>
                              <form method="post" action="comment/delete.php">
                                 <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                 <button type="submit" onclick="return confirm('댓글을 삭제하시겠습니까?')">삭제</button>
                              </form>
                           <?php endif; ?>
                           </p>
                        </div>
                     </div>
                  <?php endwhile; ?>
                  <!-- 댓글 작성 -->
                  <div class="comment_box">
                     <div class="user_info">
                        <div class="image">
                           <?php if (empty($comment['profile_image'])): ?>
                              <img src="images/icon/profile.png">
                           <?php endif; ?>
                        </div>
                     </div>
                     <form method="post" action="comment/add.php" onsubmit="return setComment(this)">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <input type="hidden" name="content">
                        <div contenteditable="true" class="comment_input" data-placeholder="댓글을 입력하세요..."></div>
                        <button type="submit">등록</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      <?php endwhile; ?>
   </div>
</body>
<script>
   function setComment(form) {
      const commentInput = form.querySelector('.comment_input');
      const commentContent = form.querySelector('input[name="content"]');

      commentContent.value = commentInput.innerText.trim();

      if (!commentContent.value) {
         alert('내용을 입력해주세요');
         return false;
      }
      return true;
   }
</script>

</html>