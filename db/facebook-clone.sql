-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 25-08-13 00:02
-- 서버 버전: 10.4.32-MariaDB
-- PHP 버전: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `facebook-clone`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(1, 1, 1, '맛있겠다 :)', '2025-07-28 20:35:18'),
(3, 1, 2, '맛있어보여요', '2025-07-28 22:17:36'),
(4, 1, 2, '배고프다', '2025-07-28 22:26:57'),
(5, 3, 1, '김치찌개 어때요?', '2025-07-28 22:31:29'),
(14, 4, 1, '손맛이 중요해요', '2025-07-28 22:36:28'),
(15, 4, 1, '맛집 추천이요', '2025-07-28 22:40:29'),
(18, 1, 2, 'dadsasdadsa', '2025-08-01 20:41:26'),
(19, 11, 4, 'https://www.facebook.com/share/p/1E294Uate8/', '2025-08-10 06:17:42'),
(20, 14, 4, 'https://www.facebook.com/share/p/1B5py38m1V/', '2025-08-10 06:27:27');

-- --------------------------------------------------------

--
-- 테이블 구조 `comment_likes`
--

CREATE TABLE `comment_likes` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `comment_likes`
--

INSERT INTO `comment_likes` (`id`, `comment_id`, `user_id`, `created_at`) VALUES
(5, 15, 2, '2025-07-28 23:10:50'),
(6, 14, 2, '2025-08-01 12:56:20'),
(7, 5, 2, '2025-08-09 07:22:05'),
(8, 1, 2, '2025-08-09 07:22:08');

-- --------------------------------------------------------

--
-- 테이블 구조 `follows`
--

CREATE TABLE `follows` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `followee_id` int(11) NOT NULL,
  `created_id` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `follows`
--

INSERT INTO `follows` (`id`, `follower_id`, `followee_id`, `created_id`) VALUES
(7, 3, 2, '2025-07-29 22:02:44');

-- --------------------------------------------------------

--
-- 테이블 구조 `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, 2, '홍길동님이 댓글을 남겼습니다.', 0, '2025-07-28 22:31:29'),
(2, 2, '홍길동님이 댓글을 남겼습니다.', 0, '2025-07-28 22:36:28'),
(3, 2, '홍길동님이 댓글을 남겼습니다.', 0, '2025-07-28 22:40:29'),
(4, 2, '홍길동님이 당신의 게시글에 좋아요를 눌렀습니다.', 0, '2025-07-28 23:10:21'),
(5, 1, 'test님이 당신의 댓글에 좋아요를 눌렀습니다.', 1, '2025-07-28 23:10:50'),
(6, 1, 'test님이 당신의 댓글에 좋아요를 눌렀습니다.', 1, '2025-07-28 23:10:50'),
(7, 1, 'test님이 당신의 댓글에 좋아요를 눌렀습니다.', 1, '2025-08-01 12:56:20'),
(8, 1, 'test님이 댓글을 남겼습니다.', 1, '2025-08-01 15:54:32'),
(9, 1, 'test님이 댓글을 남겼습니다.', 1, '2025-08-01 20:41:26'),
(10, 1, 'test님이 당신의 댓글에 좋아요를 눌렀습니다.', 1, '2025-08-09 07:22:05'),
(11, 1, 'test님이 당신의 댓글에 좋아요를 눌렀습니다.', 1, '2025-08-09 07:22:08'),
(12, 3, '김영희님이 댓글을 남겼습니다.', 0, '2025-08-10 06:17:42');

-- --------------------------------------------------------

--
-- 테이블 구조 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `image`, `created_at`) VALUES
(1, 1, '오늘 저녁은 김치찌개', '1753702398_다운로드.jpg', '2025-07-28 20:33:18'),
(3, 2, '저녁 메뉴 추천해주세요', NULL, '2025-07-28 22:31:03'),
(4, 2, '김치찌개 맛집 알려주세요', NULL, '2025-07-28 22:32:58'),
(9, 1, '날씨가 시원해요', NULL, '2025-08-09 23:28:49'),
(11, 3, '손흥민 하이라이트 내용 보기 - https://leting.co.kr/0iYG4o5', '1754773222_526883355_1317105613120877_1597197864915446379_n.jpg', '2025-08-10 06:00:22'),
(13, 4, 'https://www.facebook.com/share/p/16UKGsNnDn/', '1754774544_529157535_1288559282677891_8276226536099157720_n.jpg', '2025-08-10 06:22:24'),
(14, 4, '현대로템이 혹한기 운행 설계를 적용한 트램을 캐나다에 최초로 공급했습니다자세히 보기 ▶ vo.la/Jpsw7d', '1754774837_528444937_1248482510410378_2832185548879441997_n.jpg', '2025-08-10 06:27:17'),
(15, 2, '일상을 공유해요', NULL, '2025-08-10 06:45:36');

-- --------------------------------------------------------

--
-- 테이블 구조 `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `post_likes`
--

INSERT INTO `post_likes` (`id`, `post_id`, `user_id`, `created_at`) VALUES
(2, 4, 2, '2025-07-28 22:58:44'),
(3, 4, 1, '2025-07-28 23:10:21');

-- --------------------------------------------------------

--
-- 테이블 구조 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `background` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_image`, `background`, `created_at`) VALUES
(1, '홍길동', 'hong@hong', '$2y$10$WG0P7DCOJm8RMjz2GqdrA.k310OH9OXksLdSjF3QWA3.WL.asgEtC', '1754215715_a1461fb5.jpg', '1754215748_933ccacd.jpg', '2025-07-28 20:24:09'),
(2, 'test', 'test@test', '$2y$10$MlWQ92riKPSncSP5Uz.1p.Xv54w8ua3p85.QxBL5XJ7THMWRemzDq', '1754215890_aa8b0ce8.png', NULL, '2025-07-28 22:17:19'),
(3, '김철수', 'kim@naver.com', '$2y$10$2NhLz4GAJJnw78j3H3LTTeB.AQ3S2e57HNaAOt/WjrkPqWndiLTOa', '1754774178_2856842e.jpg', NULL, '2025-07-29 21:51:53'),
(4, '김영희', 'young@naver.com', '$2y$10$5DVwCxxMWZzuSq/wyyIi9u3prVlovL99L0r0iAxJW5FNLwThYBqPa', '1754774239_0c5c716a.jpg', NULL, '2025-07-31 17:06:32'),
(5, '홍길동전', 'hongz@hongz', '$2y$10$hi9/7LqkkvGWMChZ6eVtMuM2Uq64ZFINs0mEUmUK2cbFBdrHFmnR.', NULL, NULL, '2025-08-03 22:57:19');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comments_post` (`post_id`),
  ADD KEY `fk_comments_user` (`user_id`);

--
-- 테이블의 인덱스 `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `comment_id` (`comment_id`,`user_id`);

--
-- 테이블의 인덱스 `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follower_id` (`follower_id`),
  ADD KEY `followee_id` (`followee_id`);

--
-- 테이블의 인덱스 `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifications_user` (`user_id`);

--
-- 테이블의 인덱스 `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_posts_user` (`user_id`);

--
-- 테이블의 인덱스 `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_id` (`post_id`,`user_id`);

--
-- 테이블의 인덱스 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 테이블의 AUTO_INCREMENT `comment_likes`
--
ALTER TABLE `comment_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 테이블의 AUTO_INCREMENT `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 테이블의 AUTO_INCREMENT `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 테이블의 AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 테이블의 AUTO_INCREMENT `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD CONSTRAINT `fk_likes_comment` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `followee_id` FOREIGN KEY (`followee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follower_id` FOREIGN KEY (`follower_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `fk_likes_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_likes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
