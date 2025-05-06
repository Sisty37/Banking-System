<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../../View/UserAuthentication/Login.html");
    exit();
}

// Retrieve user data from the session
$user = $_SESSION['user'];

// Check if the cookie is set
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
