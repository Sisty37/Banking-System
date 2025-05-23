<?php
session_start();
$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
// Clear messages after displaying them
unset($_SESSION['error']);
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../../../public/css/UserAuthentication/Login.css">
</head>
<body>

  <div class="login-container">
    <h2>Login</h2>
    
    <?php if (!empty($error)): ?>
      <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
      <div class="success-message"><?php echo $success; ?></div>
    <?php endif; ?>

    <!-- <form action="../../../app/controllers/UserAuthentication/Login.php" method="POST" onsubmit="validateLoginForm(event)"></form> -->
    <form action="../../../app/controllers/UserAuthentication/Login.php" method="POST">
      <input type="email" id="login-email" name="email" placeholder="Email" required><br><br>
      <input type="password" id="login-password" name="password" placeholder="Password" required><br><br>
      <div class="remember-me">
        <input type="checkbox" id="remember-me" name="remember_me">
        <label for="remember-me">Remember me</label>
      </div>
      <p><a href="../../../app/views/UserAuthentication/ForgotPassword.php">Forgot Password?</a></p>
      <button type="submit">Login</button>
    </form>

    <p><a href="../../../app/views/UserAuthentication/SignUp.php">Don't have an account? Signup</a></p>
  </div>

  <!-- <script src="UserAuthentication.js"></script> -->
</body>
</html>