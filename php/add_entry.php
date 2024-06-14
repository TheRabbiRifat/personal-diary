<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
        exit();
        }

        require_once('config.php');
        require_once('functions.php');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user_id'];
                $entry_date = $_POST['entry_date'];
                    $entry_text = $_POST['entry_text'];

                        $stmt = $conn->prepare("INSERT INTO entries (user_id, entry_date, entry_text) VALUES (:user_id, :entry_date, :entry_text)");
                            $stmt->bindParam(':user_id', $user_id);
                                $stmt->bindParam(':entry_date', $entry_date);
                                    $stmt->bindParam(':entry_text', $entry_text);
                                        if ($stmt->execute()) {
                                                header("Location: ../calendar.php");
                                                    } else {
                                                            echo "Error: " . $stmt->errorInfo()[2];
                                                                }
                                                                }
                                                                ?>
                                                                
