<?php
// update_ex_date.php

// Include essentials and perform admin login
require('inc/essentials.php');
adminLogin();

// Database connection details
$hname = 'localhost:3307';
$uname = 'root';
$pass = '';
$db = 'makii';

// Establish a database connection
$con = mysqli_connect($hname, $uname, $pass, $db);
if (!$con) {
    die("Cannot connect to Database " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $product_id = isset($_POST['product_id']) ? mysqli_real_escape_string($con, $_POST['product_id']) : '';
    $newExDate = isset($_POST['newExDate']) ? mysqli_real_escape_string($con, $_POST['newExDate']) : '';

    // Perform the database update
    $updateQuery = "UPDATE product SET ex_date = '$newExDate' WHERE product_id = '$product_id'";
    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        // Update successful
        header("Location: dashboard.php"); // Redirect to the dashboard or wherever you want
        exit();
    } else {
        // Update failed
        echo "Error updating ex_date: " . mysqli_error($con);
    }
} else {
    // Redirect if accessed directly without form submission
    header("Location: dashboard.php");
    exit();
}
?>
