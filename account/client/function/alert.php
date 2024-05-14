<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session to access session variables

// Debug: Print session variables
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

// database
include('../../dbcon.php');

//Profile show
if (isset($_SESSION['member_id'])) {
	$id = $_SESSION['member_id'];

	$result = mysqli_query ($conn,"Select * from `members` where `member_id`='$id'");
	$row = mysqli_fetch_array ($result);
	
}

?>