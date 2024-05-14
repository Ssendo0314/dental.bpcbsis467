<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session to access session variables

// Include database connection script
include ('../../../dbcon.php');

// Profile show
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $result = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id`='$id'");
    $row = mysqli_fetch_array($result);
}

// Check if the form was submitted with the name "check_treatment"
if (isset($_POST['check_treatment'])) {
    // Get the value of 'member_id', 'schedule_id' from POST data - Sanitize inputs to prevent SQL injection
    $service_id = isset($_POST['service_id']) ? intval($_POST['service_id']) : null;
    $schedule_id = isset($_POST['schedule_id']) ? intval($_POST['schedule_id']) : null;
    $sale_id = isset($_POST['sale_id']) ? intval($_POST['sale_id']) : null;
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;
    $member_id = isset($_POST['member_id']) ? intval($_POST['member_id']) : null;

    // Echo 'member_id' for debugging
    // echo "Member ID: $member_id<br>";
    // echo "SCHEDULE ID: $schedule_id<br>";

    // Check if 'member_id' is set and is a valid integer
    // Record does not exist, create a new record in the 'record' table
    $insert_record_query = mysqli_query($conn, "INSERT INTO record (service_id, id, sale_id, user_id, member_id) VALUES ('$service_id', '$schedule_id', '$sale_id', '$user_id', '$member_id')");
    if ($insert_record_query) {
        // Get the newly inserted record ID
        $record_id = mysqli_insert_id($conn);
        // echo "New Record ID generated: $record_id<br>"; // Debugging output

        $update_schedule_sql = "UPDATE schedule SET record_id = $record_id WHERE id = $schedule_id";
        if ($conn->query($update_schedule_sql) === TRUE) {
            // The 'record_id' has been successfully updated in the 'schedule' table
        } else {
            echo "Error: Failed to update record in schedule - " . $conn->error;
            // exit;
        }
        // Redirect to another page
        echo "<script>window.location = '../treatment_add.php?record_id=$record_id';</script>";
    } else {
        echo "Error inserting record: " . mysqli_error($conn);
    }

}
?>