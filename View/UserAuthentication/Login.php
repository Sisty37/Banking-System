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
  <link rel="stylesheet" href="../../Styles/UserAuthentication/Login.css">
  <style>
    .error-message {
      color: red;
      margin-bottom: 15px;
    }
    .success-message {
      color: green;
      margin-bottom: 15px;
    }
  </style>
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

    <form action="../../PHP/UserAuthentication/Login.php" method="POST">
      <input type="email" id="login-email" name="email" placeholder="Email" required><br><br>
      <input type="password" id="login-password" name="password" placeholder="Password" required><br><br>
      <p><a href="../../View/UserAuthentication/ForgotPassword.php">Forgot Password?</a></p>
      <button type="submit">Login</button>
    </form>

    <p><a href="../../View/UserAuthentication/Signup.php">Don't have an account? Signup</a></p>
  </div>

</body>
</html> 