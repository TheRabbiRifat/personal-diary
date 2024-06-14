<?php
session_start();
require_once('config.php');
require_once('functions.php');

$user_id = $_POST['user_id'];

$entries = getEntries($user_id, $conn);

$events = [];
foreach ($entries as $entry) {
    $events[] = [
            'id' => $entry['id'],
                    'title' => 'Diary Entry',
                            'start' => $entry['entry_date'],
                                    'entry_text' => $entry['entry_text']
                                        ];
                                        }

                                        echo json_encode($events);
                                        ?>
                                        