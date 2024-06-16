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
   



CREATE TABLE `entries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `entry_date` date NOT NULL,
  `entry_text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `pin_code` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);
  
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;



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
