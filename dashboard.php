<?php
session_start();

// Include the database connection and functions
require_once 'php/config.php'; // Replace with your actual config file
require_once 'php/functions.php'; // Replace with your actual functions file

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details including name
$stmt_user = $conn->prepare("SELECT name FROM users WHERE id = :user_id");
$stmt_user->bindParam(':user_id', $user_id);
$stmt_user->execute();
$user_details = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Get the user's name
$name = $user_details['name'];

// Greeting based on time of day with user's name
$now = new DateTime();
$greeting = '';
if ($now->format('H') < 12) {
    $greeting = "Hey $name , Good Morning ";
} elseif ($now->format('H') < 18) {
    $greeting = "Hey $name , Good Afternoon";
} else {
    $greeting = "Hey $name , Good Evening";
}

// Fetch number of diary entries for the user
$stmt_entries = $conn->prepare("SELECT COUNT(*) AS num_entries FROM entries WHERE user_id = :user_id");
$stmt_entries->bindParam(':user_id', $user_id);
$stmt_entries->execute();
$num_entries = $stmt_entries->fetch(PDO::FETCH_ASSOC)['num_entries'];

// Array of motivational quotes
$quotes = [
    "The best and most beautiful things in the world cannot be seen or even touched - they must be felt with the heart. - Helen Keller",
    "You know you're in love when you can't fall asleep because reality is finally better than your dreams. - Dr. Seuss",
    "Love yourself first and everything else falls into line. - Lucille Ball",
    "The greatest thing you'll ever learn is just to love and be loved in return. - Moulin Rouge",
    "In dreams and in love there are no impossibilities. - Janos Arnay",
    "Keep love in your heart. A life without it is like a sunless garden when the flowers are dead. - Oscar Wilde",
    "Love is composed of a single soul inhabiting two bodies. - Aristotle",
    "You are my heart, my life, my entire existence. - Julie Kagawa"
];

// Select a random quote
$random_quote = $quotes[array_rand($quotes)];

// Handle PIN change form submission
$pin_change_message = $pin_change_error = '';
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
    <title>Dashboard</title>
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
        .welcome-text {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .quote {
            font-style: italic;
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .info {
            margin-top: 20px;
            text-align: left;
        }
        .info p {
            margin: 10px 0;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Personal Diary Dashboard</h2>
        </div>
        <?php if (isset($pin_change_message)): ?>
            <div class="success-message"><?php echo $pin_change_message; ?></div>
        <?php endif; ?>
        <?php if (isset($pin_change_error)): ?>
            <div class="error-message"><?php echo $pin_change_error; ?></div>
        <?php endif; ?>
        <div class="welcome-text">
            <p><?php echo $greeting; ?>!</p>
            <p>Welcome to your diary. Here you can manage your daily entries.</p>
        </div>
        <div class="quote">
            <p><?php echo $random_quote; ?></p>
        </div>
        <div class="info">
            <p><strong>Today's Date:</strong> <?php echo $now->format('l, F j, Y'); ?></p>
            <p><strong>Current Time:</strong> <span id="localTime"></span></p>
            <p><strong>Number of Entries:</strong> <?php echo $num_entries; ?></p>
        </div>
        <div class="button-container">
            <a href="calendar.php">Go to Diary</a>
            <a href="changepassword.php">Change Pin </a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <script>
        // Display local time based on user's timezone
        function updateTime() {
            var now = new Date();
            var options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: false,
                timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone
            };
            document.getElementById('localTime').textContent = now.toLocaleString('en-US', options);
        }

        // Update time initially and then every second
        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>
</html>
