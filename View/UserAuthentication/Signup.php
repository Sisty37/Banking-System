<?php
session_start();
$error = $_SESSION['error'] ?? '';
// Clear error message after displaying it
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link rel="stylesheet" href="../../Styles/UserAuthentication/SignUp.css">
  <style>
    .error-message {
      color: red;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Signup</h2>
    
    <?php if (!empty($error)): ?>
      <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form action="../../PHP/UserAuthentication/SignUp.php" method="POST">
      <input type="text" id="signup-first-name" name="first_name" placeholder="First Name" required><br>
      <input type="text" id="signup-last-name" name="last_name" placeholder="Last Name" required><br>
      <input type="email" id="signup-email" name="email" placeholder="Email" required><br>
      <input type="date" id="signup-dob" name="dob" required><br>
      <input type="password" id="signup-password" name="password" placeholder="Password" required><br>
      <input type="password" id="signup-confirm-password" name="confirm_password" placeholder="Confirm Password" required><br>

      <button type="submit">Signup</button>
    </form>
    <p><a href="../../View/UserAuthentication/Login.php">Already have an account? Login</a></p>
  </div>
</body>
</html> 