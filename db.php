<?php

// DB Credential
define('DSN', 'mysql:host=localhost;dbname=tasktracker');
define('DBUSER', 'root');
define('DBPASS', '');

try {
    // 1. Connect to DB
    $pdo = new PDO(DSN, DBUSER, DBPASS);

    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the database connection is successful
    if (!$pdo) {
        echo "Failed to connect to the database.";
    } 

} catch (PDOException $e) {
    echo "Failed to connect to the database: " . $e->getMessage();
}
=======

define('DSN','mysql:host=localhost;dbname=todolist');
define('DBUSER','root');
define('DBPASS','');


$pdo = new PDO(DSN,DBUSER,DBPASS);
?>

