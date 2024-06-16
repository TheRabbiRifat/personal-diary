<?php
// Include necessary files
require_once 'functions.php';
require_once 'config.php';

// Initialize variables to hold input data
$name = $_POST['signup_name'] ?? '';
$phone = $_POST['signup_phone'] ?? '';
$pin = $_POST['signup_pin'] ?? '';

// Validate inputs (example validation, adjust as per your requirements)
if (empty($name) || empty($phone) || empty($pin)) {
    echo "All fields are required.";
    exit();
}

// Check if the user already exists
$existingUser = isUserExists($phone, $conn);

if ($existingUser) {
    echo "User already exists.";
    exit();
}

// Attempt to create a new user
$result = createUser($name, $phone, $pin, $conn);

if ($result) {
    // Redirect to success page or dashboard upon successful signup
    header("Location: ../dashboard.php");
    exit();
} else {
    echo "Signup failed. Please try again.";
}
?>
