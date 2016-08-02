<?php
// 1. Create a database connection
$connection = mysqli_connect("localhost", "root", "", "sessiondb");
// Test if connection succeeded
if (mysqli_connect_errno()) {
    die("Database connection failed: " .
            mysqli_connect_error() .
            " (" . mysqli_connect_errno() . ")"
    );
}
?>



