 

document.addEventListener("DOMContentLoaded", () => {
    handleNotificationSettings();
    handleNotificationCenter();
  });
  
  // 1. Notification Settings Validation
  function handleNotificationSettings() {
    if (!document.title.includes("Notification Settings")) return;
  
    const form = document.querySelector("form");
    const emailToggle = document.getElementById("emailToggle");
    const pushToggle = document.getElementById("pushToggle");
  
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      if (!emailToggle.checked && !pushToggle.checked) {
        alert("Please enable at least one notification type (email or push).");
      } else {
        alert("Your preferences have been saved.");
      }
    });
  }
  
  // 2. Notification Center Mark-as-Read
  function handleNotificationCenter() {
    if (!document.title.includes("Notification Center")) return;
  
    const readButtons = document.querySelectorAll(".mark-read");
    const unreadCount = document.getElementById("unreadCount");
  
    readButtons.forEach(button => {
      button.addEventListener("click", () => {
        button.closest("li").remove();
        const current = parseInt(unreadCount.textContent);
        if (current > 1) {
          unreadCount.textContent = current - 1;
        } else {
          unreadCount.remove();
        }
      });
    });
  }
  