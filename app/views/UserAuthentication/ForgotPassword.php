<!-- ForgotPassword.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../../../public/css/UserAuthentication/ForgotPassword.css">
</head>
<body>
  <div class="forgot-password-container">
    <h2>Forgot Password</h2>
    <form action="../../../app/controllers/UserAuthentication/ForgotPassword.php" method="POST" onsubmit="validateForgotPasswordForm(event)">
      <input type="email" name="email" placeholder="Enter your email" required><br><br>
      <button type="submit">Request Password Reset</button>
    </form>
    <p><a href="../../../app/views/UserAuthentication/Login.php">Back to Login</a></p>
  </div>
  <script src="UserAuthentication.js"></script>
</body>
</html>
