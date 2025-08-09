// 모달 열기
function openModal(url) {
  fetch(url)
    .then((response) => response.text())
    .then((html) => {
      const modal = document.getElementById("modal");
      const modalContent = document.getElementById("modal_content");

      modalContent.innerHTML = html;
      modal.classList.add("show");
      modal.style.display = "block";

      bindPasteClean();

      if (url.includes("search/search.php")) {
        bindSearchFormEvents();
      } else if (url.includes("notification/notifications.php")) {
        bindNotificationEvents();
      }
    });
}

// 모달 닫기
function closeModal() {
  const modal = document.getElementById("modal");
  const modalContent = document.getElementById("modal_content");

  modal.classList.remove("show");
  modal.style.display = "none";
  modalContent.innerHTML = "";
}

// 알림 이벤트 바인딩
function bindNotificationEvents() {
  const btnAllRead = document.getElementById("noti_all_read");

  if (btnAllRead) {
    btnAllRead.addEventListener("click", () => {
      fetch("/php-practice6/notification/all_read.php", {
        method: "POST",
        credentials: "same-origin",
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            loadNotifications();
          } else {
            alert(data.message || "모두 읽음 처리 실패");
          }
        })
        .catch(() => alert("서버 오류"));
    });
  }

  document.querySelectorAll(".noti_read").forEach((button) => {
    button.onclick = function () {
      const notificationId = this.closest(".notification_item").dataset.id;

      fetch(`/php-practice6/notification/read.php?id=${encodeURIComponent(notificationId)}`, {
        credentials: "same-origin",
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            this.remove();
          } else {
            alert(data.message || "읽음 처리 실패");
          }
        })
        .catch(() => alert("서버 오류"));
    };
  });
}

// 알림 목록 불러오기
function loadNotifications() {
  fetch("/php-practice6/notification/notifications.php")
    .then((res) => res.text())
    .then((html) => {
      document.getElementById("modal_content").innerHTML = html;
      bindNotificationEvents();
    })
    .catch(() => alert("알림 불러오기 실패"));
}

// 검색 이벤트 바인딩
function bindSearchFormEvents() {
  const form = document.getElementById("searchForm");
  if (!form) return;

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const params = new URLSearchParams(new FormData(form));

    fetch("search/search.php?" + params.toString())
      .then((res) => res.text())
      .then((html) => {
        document.getElementById("modal_content").innerHTML = html;
        bindSearchFormEvents();
      })
      .catch(() => alert("검색 중 오류가 발생했습니다."));
  });
}

// 붙여넣기 이벤트 바인딩
function bindPasteClean() {
  const postInput = document.querySelector(".post_input");
  if (!postInput) return;

  postInput.removeEventListener("paste", handlePaste);
  postInput.addEventListener("paste", handlePaste);
}

function handlePaste(e) {
  e.preventDefault();

  const clipboardData = e.clipboardData || window.clipboardData;
  let text = clipboardData.getData("text/plain");

  if (!text) {
    const html = clipboardData.getData("text/html");
    if (html) {
      const temp = document.createElement("div");
      temp.innerHTML = html;
      text = temp.innnerContent || temp.innerText || "";
    }
  }

  const selection = window.getSelection();
  if (!selection.rangeCount) return;

  const range = selection.getRangeAt(0);
  range.deleteContents();

  const textNode = document.createTextNode(text);
  range.insertNode(textNode);

  range.setStartAfter(textNode);
  range.collapse(true);

  selection.removeAllRanges();
  selection.addRange(range);
}

document.getElementById("modal").addEventListener("keydown", function (e) {
  if (e.target.classList.contains("post_input") && e.key === "Enter") {
    e.preventDefault();

    const selection = window.getSelection();
    if (!selection.rangeCount) return;
    const range = selection.getRangeAt(0);

    const br = document.createElement("br");
    range.deleteContents();
    range.insertNode(br);

    range.setStartAfter(br);
    range.setEndAfter(br);
    selection.removeAllRanges();
    selection.addRange(range);
  }
});

function setPost(form) {
  const postInput = form.querySelector(".post_input");
  const postContent = form.querySelector('input[name="content"]');

  postContent.value = postInput.textContent.trim();

  if (!postContent.value && form.image.value === "") {
    alert("내용을 입력해주세요.");
    return false;
  }
  return true;
}
