<?php
/**
 * Validation Helper Functions
 */

/**
 * Validate email format
 * @param string $email
 * @return bool
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate name (letters, spaces, hyphens, apostrophes)
 * @param string $name
 * @return bool
 */
function isValidName($name) {
    return preg_match('/^[a-zA-Z\s\'-]+$/', $name) === 1;
}

/**
 * Validate date of birth (must be at least 18 years old)
 * @param string $dob
 * @return bool
 */
function isValidDateOfBirth($dob) {
    $dobDate = date_create($dob);
    if (!$dobDate) {
        return false;
    }
    
    // Calculate age
    $now = new DateTime();
    $age = $now->diff($dobDate)->y;
    
    return $age >= 18;
}

/**
 * Check if password is strong enough
 * @param string $password
 * @return bool
 */
function hasStrongPassword($password) {
    // At least 8 characters
    if (strlen($password) < 8) {
        return false;
    }
    
    // Check for uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }
    
    // Check for lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }
    
    // Check for digit
    if (!preg_match('/[0-9]/', $password)) {
        return false;
    }
    
    // Check for special character
    if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        return false;
    }
    
    return true;
}

/**
 * Sanitize input data
 * @param string $data
 * @return string
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Validate amount (positive number with up to 2 decimal places)
 * @param mixed $amount
 * @return bool
 */
function isValidAmount($amount) {
    return is_numeric($amount) && $amount > 0 && preg_match('/^\d+(\.\d{1,2})?$/', $amount);
}

/**
 * Validate account number (10 digits)
 * @param string $accountNumber
 * @return bool
 */
function isValidAccountNumber($accountNumber) {
    return preg_match('/^\d{10}$/', $accountNumber) === 1;
}

/**
 * Validate date format (YYYY-MM-DD)
 * @param string $date
 * @return bool
 */
function isValidDate($date) {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        return false;
    }
    
    $dateArray = explode('-', $date);
    return checkdate($dateArray[1], $dateArray[2], $dateArray[0]);
}

/**
 * Validate phone number
 * @param string $phone
 * @return bool
 */
function isValidPhone($phone) {
    // Allow various formats with optional country code
    return preg_match('/^\+?[0-9]{10,15}$/', $phone) === 1;
}
