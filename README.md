# Personal Diary Web App

This is a simple web application for maintaining a personal diary. Users can sign up, log in, and manage their daily entries through a calendar interface.

## Features

- **User Authentication**: Users can sign up for a new account or log in with their credentials.
- **Calendar Interface**: Users can view, add, update, and delete diary entries for each day.
- **Motivational Quotes**: The dashboard displays a random motivational quote each time the user logs in.
- **Responsive Design**: The app is designed to work seamlessly on desktop and mobile devices.

## Technologies Used

- HTML
- CSS
- JavaScript
- PHP
- MySQL

## Getting Started

### Prerequisites

- A web server with PHP support (e.g., Apache)
- MySQL database

### Installation

1. **Clone the repository**:
    ```bash
    git clone https://github.com/TheRabbiRifat/personal-diary.git
    ```

2. **Navigate to the project directory**:
    ```bash
    cd personal-diary
    ```

3. **Set up the MySQL database**:
    ```sql
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        phone_number VARCHAR(20) NOT NULL,
        pin_code CHAR(6) NOT NULL
    );

    CREATE TABLE entries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        entry_date DATE NOT NULL,
        entry_text TEXT NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
    ```

4. **Update the `config.php` file** in the `php/` directory with your database credentials:
    ```php
    <?php
    $servername = "your_servername";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>
    ```

5. **Deploy the project** on your web server.

6. **Access the application** through a web browser.

## Directory Structure

personal-diary/
├── css/
│ └── styles.css
├── js/
├── php/
│ ├── add_entry.php
│ ├── config.php
│ ├── delete_entry.php
│ ├── functions.php
│ ├── get_entries.php
│ ├── login.php
│ ├── logout.php
│ ├── signup.php
│ ├── update_entry.php
├── images/
├── index.html
├── dashboard.php
├── calendar.php
├── logout.php



## Usage

1. **Sign Up**: Register a new account with your phone number and a 6-digit PIN code.
2. **Log In**: Log in using your phone number and PIN code.
3. **Dashboard**: View your greeting, the current date and time, a random motivational quote, and a link to the calendar.
4. **Calendar**: View your entries, add new entries, update existing entries, and delete entries.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
