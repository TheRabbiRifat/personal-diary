<?php
session_start();

// Include the database connection and functions
require_once 'php/config.php';
require_once 'php/functions.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle PIN change form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_pin'])) {
    $current_pin = $_POST['current_pin'];
    $new_pin = $_POST['new_pin'];
    $confirm_pin = $_POST['confirm_pin'];

    // Verify current PIN
    $user = verifyUserById($user_id, $current_pin, $conn);

    if ($user) {
        // Check if new PIN and confirm PIN match
        if ($new_pin === $confirm_pin) {
            // Update PIN
            if (updatePin($user_id, $new_pin, $conn)) {
                $pin_change_message = "PIN changed successfully.";
            } else {
                $pin_change_error = "Failed to change PIN. Please try again.";
            }
        } else {
            $pin_change_error = "New PIN and confirm PIN do not match.";
        }
    } else {
        $pin_change_error = "Current PIN is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change PIN</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fce4ec; /* Pink background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff; /* White background for forms */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        .header {
            background-color: #e91e63; /* Pinkish color for headers */
            color: white;
            padding: 10px 0;
            margin-bottom: 20px;
            border-radius: 8px 8px 0 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .form-group .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            text-align: left;
        }
        .success-message {
            color: green;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
        .button-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .button-container a {
            text-decoration: none;
            color: #ffffff;
            background-color: #e91e63;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button-container a:hover {
            background-color: #d81b60; /* Darker pink on hover */
        }
        .button-container a.logout-btn {
            background-color: #333;
        }
        .button-container a.logout-btn:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Change PIN</h2>
        </div>
        <?php if (isset($pin_change_message)): ?>
            <div class="success-message"><?php echo $pin_change_message; ?></div>
        <?php endif; ?>
        <?php if (isset($pin_change_error)): ?>
            <div class="error-message"><?php echo $pin_change_error; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="current_pin">Current PIN</label>
                <input type="password" id="current_pin" name="current_pin" required>
            </div>
            <div class="form-group">
                <label for="new_pin">New PIN</label>
                <input type="password" id="new_pin" name="new_pin" required>
            </div>
            <div class="form-group">
                <label for="confirm_pin">Confirm New PIN</label>
                <input type="password" id="confirm_pin" name="confirm_pin" required>
            </div>
            <div class="form-group">
                <button type="submit" name="change_pin">Change PIN</button>
            </div>
        </form>
        <div class="button-container">
            <a href="dashboard.php">Back to Dashboard</a>
            <a href="calendar.php">Go to Diary</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>
