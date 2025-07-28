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
</head>

<body>
   <a href="search/search.php">사용자 검색</a>
   <a href="notification/notifications.php">알림 확인</a>
   <a href="post/write.php">새 글 작성</a>
   <a href="user/profile.php"><?= htmlspecialchars($_SESSION['username']) ?></a>
   <a href="member/logout.php">로그아웃</a>


   <?php while ($post = $result->fetch_assoc()): ?>
      <div>
         <h3><?= htmlspecialchars($post['username']) ?> 님의 글</h3>
         <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

         <?php if ($post['image']): ?>
            <img src="uploads/<?= htmlspecialchars($post['image']) ?>" width="200">
         <?php endif; ?>

         <small><?= $post['created_at'] ?></small>

         <!-- 게시글 좋아요 버튼 -->
         <form method="post" action="post/like.php?post_id=<?= $post['id'] ?>">
            <button type="submit">좋아요</button>
         </form>
         <?php
         $like_stmt = $db->prepare("SELECT COUNT(*) AS cnt FROM post_likes WHERE post_id = ?");
         $like_stmt->bind_param("i", $post['id']);
         $like_stmt->execute();
         $like_result = $like_stmt->get_result()->fetch_assoc();
         ?>
         <?= $like_result['cnt'] ?>


         <!-- 게시글 삭제 -->
         <?php if ($_SESSION['id'] == $post['user_id']): ?>
            <form method="post" action="post/delete.php">
               <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
               <button type="submit" onclick="return confirm('게시글을 삭제하시겠습니까?')">삭제</button>
            </form>
         <?php endif; ?>


         <h4>댓글</h4>
         <?php
         // 댓글 불러오기
         $cid = $post['id'];
         $cstmt = $db->prepare("
            SELECT c.id, c.content, u.username, c.user_id
            FROM comments c JOIN users u
            ON c.user_id = u.id
            WHERE c.post_id = ?
            ORDER BY c.created_at
         ");
         $cstmt->bind_param("i", $cid);
         $cstmt->execute();
         $comments = $cstmt->get_result();
         while ($comment = $comments->fetch_assoc()): ?>
            <p>
               <strong><?= htmlspecialchars($comment['username']) ?>:</strong>
               <?= htmlspecialchars($comment['content']) ?>

               <!-- 댓글 좋아요 버튼 -->
            <form method="post" action="comment/like.php?comment_id=<?= $comment['id'] ?>">
               <button type="submit">좋아요</button>
            </form>
            <?php
            $like_stmt = $db->prepare("SELECT COUNT(*) AS cnt FROM comment_likes WHERE comment_id = ?");
            $like_stmt->bind_param("i", $comment['id']);
            $like_stmt->execute();
            $like_result = $like_stmt->get_result()->fetch_assoc();
            ?>
            <?= $like_result['cnt'] ?>

            <?php if ($_SESSION['id'] == $comment['user_id']): ?>
               <!-- 수정 폼 -->
               <form method="post" action="comment/edit.php">
                  <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                  <input type="text" name="content" value="<?= htmlspecialchars($comment['content']) ?>">
                  <button type="submit">수정</button>
               </form>

               <!-- 삭제 버튼  -->
               <form method="post" action="comment/delete.php">
                  <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                  <button type="submit" onclick="return confirm('댓글을 삭제하시겠습니까?')">삭제</button>
               </form>
            <?php endif; ?>
            </p>
         <?php endwhile; ?>
      </div>

      <!-- 댓글 작성 -->
      <form method="post" action="comment/add.php">
         <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
         <input type="text" name="content" placeholder="댓글 달기">
         <button type="submit">등록</button>
      </form>
   <?php endwhile; ?>
</body>

</html>