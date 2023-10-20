<?php
// DB Credential
define('DSN', 'mysql:host=localhost;dbname=tasktracker');
define('DBUSER', 'root');
define('DBPASS', '');

// 1. Connect to DB
$pdo = new PDO(DSN, DBUSER, DBPASS);