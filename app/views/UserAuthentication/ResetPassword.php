<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <!-- Link to external CSS file -->
  <link rel="stylesheet" href="../../../public/css/UserAuthentication/ResetPassword.css">
</head>
<body>
  <div class="container">
    <h2>Reset Your Password</h2>
    <form action="../../../app/controllers/UserAuthentication/ResetPassword.php" method="POST" onsubmit="validateResetPasswordForm(event)">
      <div class="form-group">
        <input type="password" name="new_password" placeholder="New Password" required>
      </div>
      <div class="form-group">
        <input type="password" name="confirm_new_password" placeholder="Confirm New Password" required>
      </div>
      <button type="submit">Set New Password</button>
    </form>
  </div>
  <!-- Link to external JavaScript file -->
  <script src="UserAuthentication.js"></script>
</body>
</html>
