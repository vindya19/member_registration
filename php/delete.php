<?php

include 'connect.php';

if(isset($_GET['deleteid'])){
    $member_id = $_GET['deleteid'];

    // Validate input (optional but recommended)
    if(!ctype_alnum($member_id)) {
        die("Invalid member ID");
    }

    // Prepare the delete query
    $sql = "DELETE FROM member WHERE member_id=?";

    // Prepare the statement
    $stmt = mysqli_prepare($con, $sql);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "s", $member_id);
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Check if the deletion was successful
    if(mysqli_stmt_affected_rows($stmt) > 0){
        // Redirect to index.php after successful deletion
        header('Location: index.php');
        exit(); // Stop further execution
    } else {
        die("Error deleting member: " . mysqli_error($con));
    }
}

?>
