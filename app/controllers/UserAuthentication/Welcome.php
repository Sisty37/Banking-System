<?php
session_start();
$user = $_SESSION['user'];
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
