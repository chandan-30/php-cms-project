<?php 
    $connection = mysqli_connect("localhost","root");
    if(!$connection){
        die("Database connection failed");
    }
    $db = mysqli_select_db($connection,"test");
    if(!$db){
        die("Database sekection failed");
    }
?>
