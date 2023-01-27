<?php 
    include('config.php');

    $database = new mysqli($host, $username, $password, $dbname);
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }
?>
