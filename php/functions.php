<?php
// Include the database connection
require_once 'config.php';

// Function to check if a user exists by phone number
function isUserExists($phone, $conn) {
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE phone_number = :phone");
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Return user data if found, false otherwise
    } catch(PDOException $e) {
        error_log("Error checking user existence: " . $e->getMessage());
        return false;
    }
}

// Function to create a new user
function createUser($name, $phone, $pin, $conn) {
    try {
        $hashed_pin = password_hash($pin, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, phone_number, pin_code) VALUES (:name, :phone, :pin)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':pin', $hashed_pin);
        return $stmt->execute(); // Return true on success, false on failure
    } catch(PDOException $e) {
        error_log("Error creating user: " . $e->getMessage());
        return false;
    }
}

// Function to update PIN for a user
function updatePin($user_id, $new_pin, $conn) {
    try {
        $hashed_pin = password_hash($new_pin, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET pin_code = :pin_code WHERE id = :user_id");
        $stmt->bindParam(':pin_code', $hashed_pin);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute(); // Return true on success, false on failure
    } catch(PDOException $e) {
        error_log("Error updating PIN: " . $e->getMessage());
        return false;
    }
}

// Function to verify a user by ID and PIN
function verifyUserById($user_id, $pin, $conn) {
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($pin, $user['pin_code'])) {
            return $user; // Return user data if PIN matches, false otherwise
        } else {
            return false;
        }
    } catch(PDOException $e) {
        error_log("Error verifying user by ID: " . $e->getMessage());
        return false;
    }
}

// Function to verify a user by phone number and PIN
function verifyUser($phone, $pin, $conn) {
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE phone_number = :phone");
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($pin, $user['pin_code'])) {
            return $user; // Return user data if PIN matches, false otherwise
        } else {
            return false;
        }
    } catch(PDOException $e) {
        error_log("Error verifying user by phone number: " . $e->getMessage());
        return false;
    }
}

// Function to add an entry to the user's diary
function addEntry($user_id, $entry_date, $entry_text, $conn) {
    try {
        $stmt = $conn->prepare("INSERT INTO entries (user_id, entry_date, entry_text) VALUES (:user_id, :entry_date, :entry_text)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':entry_date', $entry_date);
        $stmt->bindParam(':entry_text', $entry_text);
        return $stmt->execute(); // Return true on success, false on failure
    } catch(PDOException $e) {
        error_log("Error adding diary entry: " . $e->getMessage());
        return false;
    }
}

// Function to update an entry in the user's diary
function updateEntry($entry_id, $entry_text, $conn) {
    try {
        $stmt = $conn->prepare("UPDATE entries SET entry_text = :entry_text WHERE id = :entry_id");
        $stmt->bindParam(':entry_text', $entry_text);
        $stmt->bindParam(':entry_id', $entry_id);
        return $stmt->execute(); // Return true on success, false on failure
    } catch(PDOException $e) {
        error_log("Error updating diary entry: " . $e->getMessage());
        return false;
    }
}

// Function to delete an entry from the user's diary
function deleteEntry($entry_id, $conn) {
    try {
        $stmt = $conn->prepare("DELETE FROM entries WHERE id = :entry_id");
        $stmt->bindParam(':entry_id', $entry_id);
        return $stmt->execute(); // Return true on success, false on failure
    } catch(PDOException $e) {
        error_log("Error deleting diary entry: " . $e->getMessage());
        return false;
    }
}

// Function to get all diary entries of a user
function getEntries($user_id, $conn) {
    try {
        $stmt = $conn->prepare("SELECT * FROM entries WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return array of entries
    } catch(PDOException $e) {
        error_log("Error fetching diary entries: " . $e->getMessage());
        return [];
    }
}

?>
