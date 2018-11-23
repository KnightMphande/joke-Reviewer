<?php 
    require "config.php";
?>


<?php
    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // Create database
    $sql = "CREATE DATABASE db2";
    if ($conn->query($sql) === TRUE) {
        echo "a database created successfully";
    } else {
        echo "Error creating a fresh database: " . $conn->error;
    }

    $conn->close();
?>
