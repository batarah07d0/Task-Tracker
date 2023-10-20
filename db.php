<?php

define('DSN','mysql:host=localhost;dbname=todolist');
define('DBUSER','root');
define('DBPASS','');


$pdo = new PDO(DSN,DBUSER,DBPASS);
?>