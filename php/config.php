   <?php
   // Database configuration
   $db_host = 'sql206.cpanelfree.com'; // Your database host, usually 'localhost'
   $db_username = 'cpfr_36718239'; // Your database username
   $db_password = 'Puffin017'; // Your database password
   $db_name = 'cpfr_36718239_diary_app'; // Your database name

   // Establish database connection
   try {
       $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
           $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           } catch(PDOException $e) {
               die("Connection failed: " . $e->getMessage());
               }
               ?>
