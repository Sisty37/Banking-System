<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to avoid XSS attacks
    $first_name = htmlspecialchars(trim($_POST["first_name"]));
    $last_name = htmlspecialchars(trim($_POST["last_name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $dob = $_POST["dob"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validate email
    if (!$email) {
        die("Invalid email format.");
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Simulate user creation (You should replace this with actual database logic)
    // For now, save the user's data in session for demonstration purposes
    $_SESSION['user'] = [
        "first_name" => $first_name,
        "last_name" => $last_name,
        "email" => $email,
        "dob" => $dob
    ];

    // Set a welcome cookie for the user, expires in 1 hour
    setcookie("welcome_user", $first_name, time() + 3600, "/");

    // Redirect the user to a welcome page after signup
    header("Location: ../../View/UserAuthentication/Welcome.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
