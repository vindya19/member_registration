<?php
    // Connect to the database
    $con = new mysqli('localhost', 'root', '', 'library_test');

    // Check if the connection was successful
    if($con->connect_error) {
        // Display error message and terminate the script
        die("Connection failed: " . $con->connect_error);
    }
?>
