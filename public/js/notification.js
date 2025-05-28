document.addEventListener("DOMContentLoaded", () => {
<<<<<<< HEAD
    handleNotificationSettings();
    handleNotificationCenter();
    initializeNotificationDropdown();
  });
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
  function initializeNotificationDropdown() {
    const notificationIcon = document.querySelector('.notification-icon');
    if (!notificationIcon) return;
    notificationIcon.addEventListener('click', function(e) {
      e.stopPropagation();
      const dropdown = document.querySelector('.notification-dropdown-content');
      dropdown.classList.toggle('show');
      if (dropdown.classList.contains('show') && dropdown.querySelector('.notification-item') === null) {
        fetchNotifications();
      }
    });
    document.addEventListener('click', function() {
      const dropdown = document.querySelector('.notification-dropdown-content');
      if (dropdown && dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
      }
    });
    const dropdownContent = document.querySelector('.notification-dropdown-content');
    if (dropdownContent) {
      dropdownContent.addEventListener('click', function(e) {
        e.stopPropagation();
      });
    }
  }
  function fetchNotifications() {
    const notificationList = document.querySelector('.notification-list');
    if (!notificationList) return;
    const notifications = [
      { id: 1, content: 'New transaction processed', time: '5 minutes ago', unread: true },
      { id: 2, content: 'Your account statement is ready', time: '1 hour ago', unread: true },
      { id: 3, content: 'Security alert: New login detected', time: '3 hours ago', unread: true },
      { id: 4, content: 'Monthly interest applied to your account', time: 'Yesterday', unread: false },
      { id: 5, content: 'Welcome to our banking system!', time: '1 week ago', unread: false }
    ];
    const unreadCount = notifications.filter(n => n.unread).length;
    const badge = document.querySelector('.notification-badge');
    badge.textContent = unreadCount;
    notificationList.innerHTML = '';
    notifications.forEach(notification => {
      const notificationItem = document.createElement('li');
      notificationItem.className = `notification-item${notification.unread ? ' unread' : ''}`;
      notificationItem.setAttribute('data-id', notification.id);
      notificationItem.innerHTML = `
        <div class="notification-content">${notification.content}</div>
        <div class="notification-time">${notification.time}</div>
      `;
      notificationItem.addEventListener('click', function() {
        if (this.classList.contains('unread')) {
          this.classList.remove('unread');
          const currentCount = parseInt(badge.textContent);
          badge.textContent = currentCount - 1;
          if (currentCount - 1 <= 0) {
            badge.style.display = 'none';
          }
        }
      });
      notificationList.appendChild(notificationItem);
    });
  }
  
=======
  handleNotificationSettings();
  handleNotificationCenter();
  initializeNotificationDropdown();
  });
  
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
  
  function initializeNotificationDropdown() {
  const notificationIcon = document.querySelector('.notification-icon');
  if (!notificationIcon) return;
  
  notificationIcon.addEventListener('click', function(e) {
    e.stopPropagation();
    const dropdown = document.querySelector('.notification-dropdown-content');
    dropdown.classList.toggle('show');
    
    if (dropdown.classList.contains('show') && dropdown.querySelector('.notification-item') === null) {
    fetchNotifications();
    }
  });
  
  document.addEventListener('click', function() {
    const dropdown = document.querySelector('.notification-dropdown-content');
    if (dropdown && dropdown.classList.contains('show')) {
    dropdown.classList.remove('show');
    }
  });
  
  const dropdownContent = document.querySelector('.notification-dropdown-content');
  if (dropdownContent) {
    dropdownContent.addEventListener('click', function(e) {
    e.stopPropagation();
    });
  }
  }
  
  function fetchNotifications() {
  const notificationList = document.querySelector('.notification-list');
  if (!notificationList) return;
  
  const notifications = [
    { id: 1, content: 'New transaction processed', time: '5 minutes ago', unread: true },
    { id: 2, content: 'Your account statement is ready', time: '1 hour ago', unread: true },
    { id: 3, content: 'Security alert: New login detected', time: '3 hours ago', unread: true },
    { id: 4, content: 'Monthly interest applied to your account', time: 'Yesterday', unread: false },
    { id: 5, content: 'Welcome to our banking system!', time: '1 week ago', unread: false }
  ];
  
  const unreadCount = notifications.filter(n => n.unread).length;
  const badge = document.querySelector('.notification-badge');
  badge.textContent = unreadCount;
  
  notificationList.innerHTML = '';
  notifications.forEach(notification => {
    const notificationItem = document.createElement('li');
    notificationItem.className = `notification-item${notification.unread ? ' unread' : ''}`;
    notificationItem.setAttribute('data-id', notification.id);
    
    notificationItem.innerHTML = `
    <div class="notification-content">${notification.content}</div>
    <div class="notification-time">${notification.time}</div>
    `;
    
    notificationItem.addEventListener('click', function() {
    if (this.classList.contains('unread')) {
      this.classList.remove('unread');
      const currentCount = parseInt(badge.textContent);
      badge.textContent = currentCount - 1;
      if (currentCount - 1 <= 0) {
      badge.style.display = 'none';
      }
    }
    });
    
    notificationList.appendChild(notificationItem);
  });
  }
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
