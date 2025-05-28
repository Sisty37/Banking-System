<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    if (empty($email)) {
        echo "<p style='color:red;'>Email is required.</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color:red;'>Invalid email address.</p>";
    } else {
        echo "<p style='color:green;'>If this email exists, a reset link has been sent.</p>";
<<<<<<< HEAD
=======
       
>>>>>>> 07df6103b61152c961a82ee25b5e7fdec8a5cadc
    }
}
?>
