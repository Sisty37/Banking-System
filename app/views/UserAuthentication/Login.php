<<<<<<< HEAD:app/views/UserAuthentication/Login.php
﻿<?php
=======
<?php
>>>>>>> 17f8b2b5b3b5f897c35e69fbe6b2c898d44ab548:View/UserAuthentication/Login.php
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
<<<<<<< HEAD:app/views/UserAuthentication/Login.php
  <link rel="stylesheet" href="../../../public/css/UserAuthentication/Login.css">
=======
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
>>>>>>> 17f8b2b5b3b5f897c35e69fbe6b2c898d44ab548:View/UserAuthentication/Login.php
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

<<<<<<< HEAD:app/views/UserAuthentication/Login.php
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
=======
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
>>>>>>> 17f8b2b5b3b5f897c35e69fbe6b2c898d44ab548:View/UserAuthentication/Login.php
