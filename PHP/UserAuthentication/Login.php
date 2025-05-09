<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $password = $_POST["password"];

    // Validate email format
    if (!$email) {
        die("Invalid email format.");
    }

    // Check if the user is stored in the session
    if (!isset($_SESSION['user'])) {
        die("No user found. Please sign up first.");
    }

    $stored_user = $_SESSION['user'];

    // Simulate stored hashed password
    // In real apps, passwords are stored in the database
    $stored_email = $stored_user["email"];
    $stored_hashed_password = $_SESSION['hashed_password'] ?? null;

    if ($email !== $stored_email) {
        die("Incorrect email.");
    }

    if (!$stored_hashed_password || !password_verify($password, $stored_hashed_password)) {
        die("Incorrect password.");
    }

    // Set login session
    $_SESSION['logged_in'] = true;

    // Redirect to dashboard or welcome page
    header("Location: ../../PHP/UserAuthentication/Welcome.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
