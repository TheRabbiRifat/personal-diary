<?php
session_start();
require_once('config.php');
require_once('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entry_id = $_POST['entry_id'];
        $entry_text = $_POST['entry_text'];

            $result = updateEntry($entry_id, $entry_text, $conn);

                if ($result) {
                        echo "Entry updated successfully.";
                            } else {
                                    echo "Update failed. Please try again.";
                                        }
                                        }
                                        ?>
                                        