<<<<<<< HEAD:app/views/UserAuthentication/ForgotPassword.php
﻿<!-- ForgotPassword.html -->
=======
<?php
session_start();
$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
// Clear messages after displaying them
unset($_SESSION['error']);
unset($_SESSION['success']);
?>
>>>>>>> 17f8b2b5b3b5f897c35e69fbe6b2c898d44ab548:View/UserAuthentication/ForgotPassword.php
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
<<<<<<< HEAD:app/views/UserAuthentication/ForgotPassword.php
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

=======
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../../Styles/UserAuthentication/ForgotPassword.css">
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
  <div class="forgot-password-container">
    <h2>Forgot Password</h2>
    
    <?php if (!empty($error)): ?>
      <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
      <div class="success-message"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form action="../../PHP/UserAuthentication/ForgotPassword.php" method="POST">
      <input type="email" id="forgot-email" name="email" placeholder="Email" required><br><br>
      <button type="submit">Reset Password</button>
    </form>
    
    <p><a href="../../View/UserAuthentication/Login.php">Back to Login</a></p>
  </div>
</body>
</html> 
>>>>>>> 17f8b2b5b3b5f897c35e69fbe6b2c898d44ab548:View/UserAuthentication/ForgotPassword.php
