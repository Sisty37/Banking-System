<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $first_name = htmlspecialchars(trim($_POST["first_name"]));
    $last_name = htmlspecialchars(trim($_POST["last_name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $dob = htmlspecialchars(trim($_POST["dob"]));
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Email validation
    if (!$email) {
        die("Invalid email format.");
    }

    // Password match validation
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Password hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Simulate user creation by storing in session (not for production use)
    $_SESSION['user'] = [
        "first_name" => $first_name,
        "last_name" => $last_name,
        "email" => $email,
        "dob" => $dob
    ];

    // Store hashed password separately in session
    $_SESSION['hashed_password'] = $hashed_password;

    // Set welcome cookie for 1 hour
    setcookie("welcome_user", $first_name, time() + 3600, "/");

    // Redirect to welcome page
    header("Location: ../../PHP/UserAuthentication/Welcome.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
