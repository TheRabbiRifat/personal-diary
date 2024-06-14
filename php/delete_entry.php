<?php
session_start();
require_once('config.php');
require_once('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entry_id = $_POST['entry_id'];

        $result = deleteEntry($entry_id, $conn);

            if ($result) {
                    echo "Entry deleted successfully.";
                        } else {
                                echo "Failed to delete entry. Please try again.";
                                    }
                                    }
                                    ?>
                                    