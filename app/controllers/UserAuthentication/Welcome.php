<?php
session_start();
<<<<<<< HEAD
$user = $_SESSION['user'];
=======

<<<<<<< HEAD:app/controllers/UserAuthentication/Welcome.php
=======
// Check if the user is logged in
// if (!isset($_SESSION['user'])) {
//     header("Location: ../../View/UserAuthentication/Login.php");
//     exit();
// }

// Retrieve user data from the session
>>>>>>> 17f8b2b5b3b5f897c35e69fbe6b2c898d44ab548:PHP/UserAuthentication/Welcome.php
$user = $_SESSION['user'];

>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
$welcome_message = isset($_COOKIE['welcome_user']) ? $_COOKIE['welcome_user'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
</head>
<body>
  <h2>Welcome, <?= htmlspecialchars($welcome_message) ?>!</h2>
  <p>You have signed up successfully.</p>
</body>
</html>
