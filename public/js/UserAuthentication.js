<<<<<<< HEAD

=======
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
function showError(message, event) {
  alert(message);
  event.preventDefault();
}
<<<<<<< HEAD
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;  
  return emailRegex.test(email);
}
=======

function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
function validateLoginForm(event) {
  const email = document.getElementById('login-email')?.value.trim();
  const password = document.getElementById('login-password')?.value.trim();
  if (!email || !password) {
      showError('Please fill out all fields.', event);
  } else if (!isValidEmail(email)) {
      showError('Please enter a valid email address.', event);
  }
}
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
function validateSignupForm(event) {
  const firstName = document.getElementById('signup-first-name')?.value.trim();
  const lastName = document.getElementById('signup-last-name')?.value.trim();
  const email = document.getElementById('signup-email')?.value.trim();
  const password = document.getElementById('signup-password')?.value;
  const confirmPassword = document.getElementById('signup-confirm-password')?.value;
  const dob = document.getElementById('signup-dob')?.value;
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
  if (!firstName || !lastName || !email || !password || !confirmPassword || !dob) {
      showError('Please fill out all fields.', event);
  } else if (!isValidEmail(email)) {
      showError('Please enter a valid email address.', event);
  } else if (password.length < 6) {
      showError('Password must be at least 6 characters long.', event);
  } else if (password !== confirmPassword) {
      showError('Passwords do not match.', event);
  }
}
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
function validateForgotPasswordForm(event) {
  const email = document.getElementById('forgot-email')?.value.trim();
  if (!email) {
      showError('Please enter your email.', event);
  } else if (!isValidEmail(email)) {
      showError('Please enter a valid email address.', event);
  }
}
<<<<<<< HEAD
=======

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
function validateResetPasswordForm(event) {
  const newPassword = document.getElementById('reset-password')?.value;
  const confirmPassword = document.getElementById('reset-confirm-password')?.value;
  if (!newPassword || !confirmPassword) {
      showError('Please fill out all fields.', event);
  } else if (newPassword.length < 6) {
      showError('Password must be at least 6 characters long.', event);
  } else if (newPassword !== confirmPassword) {
      showError('Passwords do not match.', event);
  }
}
