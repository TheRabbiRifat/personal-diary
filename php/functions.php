<?php
function isUserExists($phone, $conn) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE phone = :phone");
        $stmt->bindParam(':phone', $phone);
            $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
                }

                function createUser($phone, $pin, $conn) {
                    $hashed_pin = password_hash($pin, PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("INSERT INTO users (phone, pin) VALUES (:phone, :pin)");
                            $stmt->bindParam(':phone', $phone);
                                $stmt->bindParam(':pin', $hashed_pin);
                                    return $stmt->execute();
                                    }

                                    function verifyUser($phone, $pin, $conn) {
                                        $stmt = $conn->prepare("SELECT * FROM users WHERE phone = :phone");
                                            $stmt->bindParam(':phone', $phone);
                                                $stmt->execute();
                                                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                                                        if ($user && password_verify($pin, $user['pin'])) {
                                                                return $user;
                                                                    } else {
                                                                            return false;
                                                                                }
                                                                                }

                                                                                function addEntry($user_id, $entry_date, $entry_text, $conn) {
                                                                                    $stmt = $conn->prepare("INSERT INTO entries (user_id, entry_date, entry_text) VALUES (:user_id, :entry_date, :entry_text)");
                                                                                        $stmt->bindParam(':user_id', $user_id);
                                                                                            $stmt->bindParam(':entry_date', $entry_date);
                                                                                                $stmt->bindParam(':entry_text', $entry_text);
                                                                                                    return $stmt->execute();
                                                                                                    }

                                                                                                    function updateEntry($entry_id, $entry_text, $conn) {
                                                                                                        $stmt = $conn->prepare("UPDATE entries SET entry_text = :entry_text WHERE id = :entry_id");
                                                                                                            $stmt->bindParam(':entry_text', $entry_text);
                                                                                                                $stmt->bindParam(':entry_id', $entry_id);
                                                                                                                    return $stmt->execute();
                                                                                                                    }

                                                                                                                    function deleteEntry($entry_id, $conn) {
                                                                                                                        $stmt = $conn->prepare("DELETE FROM entries WHERE id = :entry_id");
                                                                                                                            $stmt->bindParam(':entry_id', $entry_id);
                                                                                                                                return $stmt->execute();
                                                                                                                                }

                                                                                                                                function getEntries($user_id, $conn) {
                                                                                                                                    $stmt = $conn->prepare("SELECT * FROM entries WHERE user_id = :user_id");
                                                                                                                                        $stmt->bindParam(':user_id', $user_id);
                                                                                                                                            $stmt->execute();
                                                                                                                                                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                                                                                                                }
                                                                                                                                                ?>
                                                                                                                                                