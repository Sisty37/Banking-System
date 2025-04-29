<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if (empty($newPassword) || empty($confirmPassword)) {
        echo "<p style='color:red;'>All fields are required.</p>";
    } elseif (strlen($newPassword) < 6) {
        echo "<p style='color:red;'>Password must be at least 6 characters long.</p>";
    } elseif ($newPassword !== $confirmPassword) {
        echo "<p style='color:red;'>Passwords do not match.</p>";
    } else {
        echo "<p style='color:green;'>Password reset successful!</p>";
        // Store hashed password in DB
    }
}
?>
