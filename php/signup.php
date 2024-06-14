<?php
require_once('config.php');
require_once('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['signup_phone'];
        $pin = $_POST['signup_pin'];

            // Check if user already exists
                $existingUser = isUserExists($phone, $conn);

                    if ($existingUser) {
                            echo "User already exists.";
                                } else {
                                        // Create new user
                                                $result = createUser($phone, $pin, $conn);
                                                        if ($result) {
                                                                    header("Location: ../dashboard.php");
                                                                                exit();
                                                                                        } else {
                                                                                                    echo "Signup failed. Please try again.";
                                                                                                            }
                                                                                                                }
                                                                                                                }
                                                                                                                ?>
                                                                                                                