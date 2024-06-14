   <?php
   // Database configuration
   $db_host = 'YOUR_SQL_HOST_SERVER'; // Your database host, usually 'localhost'
   $db_username = 'YOUR_DATABASE_USERNAME'; // Your database username
   $db_password = 'YOUR_DATABASE_PASSWORD'; // Your database password
   $db_name = 'YOUR_DATABASE_NAME'; // Your database name

   // Establish database connection
   try {
       $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
           $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           } catch(PDOException $e) {
               die("Connection failed: " . $e->getMessage());
               }
               ?>
