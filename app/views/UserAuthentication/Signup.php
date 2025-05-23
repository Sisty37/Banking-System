<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Signup</title>
  <link rel="stylesheet" href="../../../public/css/UserAuthentication/SignUp.css">
</head>
<body>
  <div class="form-container">
    <h2>Signup</h2>
    <form action="../../../app/controllers/UserAuthentication/SignUp.php" method="POST">

      <input type="text" id="signup-first-name" name="first_name" placeholder="First Name" required><br>
      <input type="text" id="signup-last-name" name="last_name" placeholder="Last Name" required><br>
      <input type="email" id="signup-email" name="email" placeholder="Email" required><br>
      <input type="date" id="signup-dob" name="dob" required><br>
      <input type="password" id="signup-password" name="password" placeholder="Password" required><br>
      <input type="password" id="signup-confirm-password" name="confirm_password" placeholder="Confirm Password" required><br>

      <button type="submit">Signup</button>
    </form>
    <p><a href="../../../app/views/UserAuthentication/Login.php">Already have an account? Login</a></p>
  </div>

  <!-- <script src="UserAuthentication.js"></script>  -->
</body>
</html>

