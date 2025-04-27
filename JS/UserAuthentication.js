function showError(message, event) {
  alert(message);
  event.preventDefault();
}

// Check if email format is valid
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;  // simple valid regex
  return emailRegex.test(email);
}

// Validate Login Form
function validateLoginForm(event) {
  const email = document.getElementById('login-email')?.value.trim();
  const password = document.getElementById('login-password')?.value.trim();

  if (!email || !password) {
      showError('Please fill out all fields.', event);
  } else if (!isValidEmail(email)) {
      showError('Please enter a valid email address.', event);
  }
}

// Validate Signup Form
function validateSignupForm(event) {
  const name = document.getElementById('signup-name')?.value.trim();
  const email = document.getElementById('signup-email')?.value.trim();
  const password = document.getElementById('signup-password')?.value;
  const confirmPassword = document.getElementById('signup-confirm-password')?.value;
  const dob = document.getElementById('signup-dob')?.value;

  // Check if all fields are filled
  if (!name || !email || !password || !confirmPassword || !dob) {
      showError('Please fill out all fields.', event);
  } else if (!isValidEmail(email)) {
      showError('Please enter a valid email address.', event);
  } else if (password.length < 6) {
      showError('Password must be at least 6 characters long.', event);
  } else if (password !== confirmPassword) {
      showError('Passwords do not match.', event);
  }
}

// Validate Forgot Password Form
function validateForgotPasswordForm(event) {
  const email = document.getElementById('forgot-email')?.value.trim();

  if (!email) {
      showError('Please enter your email.', event);
  } else if (!isValidEmail(email)) {
      showError('Please enter a valid email address.', event);
  }
}

// Validate Reset Password Form
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
