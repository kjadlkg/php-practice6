# php-practice6

### Facebook 초기 버전 클론 코딩

이 프로젝트는 세계 최대 소셜 미디어 플랫폼 중 하나인 **Facebook**의 핵심 기능을 PHP로 구현하는 것을 목표로 하고 있습니다.
Facebook의 개발 역사를 학습하며, 신규 기능 구현에 중점을 두었습니다.
초기 PHP 기반 Facebook의 기능 구현을 목표로 하되, 최신 Facebook UI 참고하여 구성했습니다.

## 📦개발 환경

- XAMPP v.3.3.0 (Apr 6th 2021)

## ✨구현된 주요 기능

| 주요 기능         | 내용                                      |
| ----------------- | ----------------------------------------- |
| **사용자 관리**   | 회원가입, 로그인, 로그아웃, 비밀번호 찾기 |
| **마이페이지**    | 프로필 정보 조회, 배경·프로필 이미지 변경 |
| **게시물 기능**   | 게시물 작성·조회·삭제, 사진 업로드 지원   |
| **댓글 기능**     | 댓글 작성·삭제                            |
| **상호작용 기능** | 팔로우, 좋아요                            |
| **친구 기능**     | 사용자 검색                               |
| **알림 시스템**   | 게시물 댓글·좋아요 알림, 알림 읽음 처리   |

## 🚀실행 & 테스트 방법

### 1. 빠른 테스트

- **호스팅 사이트**: InfinityFree
- 🔗 [테스트 바로가기](https://kjadlkg.infinityfreeapp.com/php-practice6/member/login.php)

### 2. 로컬 설치 (XAMPP)

1. **XAMPP 설치**

   ```
   https://www.apachefriends.org/download.html
   ```

2. **프로젝트 다운로드**

   ```bash
   git clone https://github.com/kjadlkg/php-practice6.git
   ```

   또는 ZIP 다운로드 후 `htdocs` 폴더에 복사

3. **htdocs에 배치**

   ```
   C:\xampp\htdocs
   ```

   또는 위 위치에서 `git clone` 실행

4. **MySQL 서버 실행 & phpMyAdmin 접속**

   ```
   http://localhost/phpmyadmin
   ```

5. **새 데이터베이스 생성 (예: facebook-clone)**

   - 다른 DB 이름을 사용하려면 `resource/db.php`에서 `database` 값 변경

6. **db/facebook-clone.sql 파일 Import**

   - 생성한 DB에 `db/test3.sql` 파일을 Import

7. **브라우저 접속**
   ```
   http://localhost/php-practice6/index.php
   ```

## 🔧추가 업데이트 예정

- [ ] 게시글 수정
- [ ] 프로필 정보 변경
- [ ] 친구 요청, 수락, 취소
- [ ] 팔로우/친구 요청 알림
- [ ] 알림 부가 기능
