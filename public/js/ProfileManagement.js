document.addEventListener("DOMContentLoaded", function () {
<<<<<<< HEAD
    validateViewProfile();
    validateEditProfile();
    validateChangeAvatar();
    validateUpdatePassword();
  });
  function validateViewProfile() {
    console.log("View Profile loaded");
  }
  function validateEditProfile() {
    const form = document.querySelector("form");
    if (form && document.title.includes("Edit Profile")) {
      form.addEventListener("submit", function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          alert("Please fill out all required fields.");
        }
        form.classList.add("was-validated");
      });
    }
  }
  function validateChangeAvatar() {
    const form = document.querySelector("form");
    const avatarInput = document.getElementById("avatarUpload");
    if (form && avatarInput && document.title.includes("Change Avatar")) {
      form.addEventListener("submit", function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          alert("Please select a valid image file.");
        }
        form.classList.add("was-validated");
      });
      avatarInput.addEventListener("change", function () {
        const file = avatarInput.files[0];
        if (file) {
          const allowedTypes = ["image/jpeg", "image/png"];
          const maxSizeMB = 2;
          if (!allowedTypes.includes(file.type)) {
            alert("Only JPG and PNG formats are allowed.");
            avatarInput.value = "";
          } else if (file.size > maxSizeMB * 1024 * 1024) {
            alert("File size must be less than 2MB.");
            avatarInput.value = "";
          }
        }
      });
    }
  }
  function validateUpdatePassword() {
    const form = document.querySelector("form");
    const newPassword = document.getElementById("newPassword");
    const confirmPassword = document.getElementById("confirmPassword");
    if (
      form &&
      newPassword &&
      confirmPassword &&
      document.title.includes("Update Password")
    ) {
      form.addEventListener("submit", function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          alert("Please complete all fields and fix errors.");
        }
        form.classList.add("was-validated");
      });
      confirmPassword.addEventListener("input", function () {
        if (newPassword.value !== confirmPassword.value) {
          confirmPassword.setCustomValidity("Passwords do not match.");
        } else {
          confirmPassword.setCustomValidity("");
        }
      });
    }
  }
  
=======
  validateViewProfile();
  validateEditProfile();
  validateChangeAvatar();
  validateUpdatePassword();
  });

  function validateViewProfile() {
  console.log("View Profile loaded");
  }

  function validateEditProfile() {
  const form = document.querySelector("form");
  if (form && document.title.includes("Edit Profile")) {
    form.addEventListener("submit", function (event) {
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
      alert("Please fill out all required fields.");
    }
    form.classList.add("was-validated");
    });
  }
  }

  function validateChangeAvatar() {
  const form = document.querySelector("form");
  const avatarInput = document.getElementById("avatarUpload");

  if (form && avatarInput && document.title.includes("Change Avatar")) {
    form.addEventListener("submit", function (event) {
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
      alert("Please select a valid image file.");
    }
    form.classList.add("was-validated");
    });

    avatarInput.addEventListener("change", function () {
    const file = avatarInput.files[0];
    if (file) {
      const allowedTypes = ["image/jpeg", "image/png"];
      const maxSizeMB = 2;

      if (!allowedTypes.includes(file.type)) {
      alert("Only JPG and PNG formats are allowed.");
      avatarInput.value = "";
      } else if (file.size > maxSizeMB * 1024 * 1024) {
      alert("File size must be less than 2MB.");
      avatarInput.value = "";
      }
    }
    });
  }
  }

  function validateUpdatePassword() {
  const form = document.querySelector("form");
  const newPassword = document.getElementById("newPassword");
  const confirmPassword = document.getElementById("confirmPassword");

  if (
    form &&
    newPassword &&
    confirmPassword &&
    document.title.includes("Update Password")
  ) {
    form.addEventListener("submit", function (event) {
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
      alert("Please complete all fields and fix errors.");
    }
    form.classList.add("was-validated");
    });

    confirmPassword.addEventListener("input", function () {
    if (newPassword.value !== confirmPassword.value) {
      confirmPassword.setCustomValidity("Passwords do not match.");
    } else {
      confirmPassword.setCustomValidity("");
    }
    });
  }
  }
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
