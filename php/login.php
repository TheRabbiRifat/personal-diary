<?php
session_start();
require_once('config.php');
require_once('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
        $pin = $_POST['pin'];

            // Verify user credentials
                $user = verifyUser($phone, $pin, $conn);

                    if ($user) {
                            $_SESSION['user_id'] = $user['id']; // Store user ID in session
                                    header("Location: ../dashboard.php");
                                            exit();
                                                } else {
                                                        echo "Invalid phone number or pin code.";
                                                            }
                                                            }
                                                            ?>
                                                            