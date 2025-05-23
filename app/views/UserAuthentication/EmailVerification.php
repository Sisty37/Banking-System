<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Email Verification</title>
  <link rel="stylesheet" href="../../../public/css/UserAuthentication/EmailVerification.css">
</head>
<body>
  <div class="container">
    <h2>Email Verification</h2>
    <p>Please check your email to verify your account.</p>
    <form action="/resend-verification" method="POST">
      <button type="submit">Resend Verification Email</button>
    </form>
  </div>

  <!-- Link the validation.js file here -->
  <script src="UserAuthentication.js"></script>
</body>

</html>

