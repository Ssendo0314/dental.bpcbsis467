<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session to access session variables

// Database connection
include ('../../dbcon.php');

// Set the default timezone to Philippines (Asia/Manila)
date_default_timezone_set('Asia/Manila');

// Function to execute update query and return the number of rows affected
function execute_update_cancelled($conn, $current_date)
{
    // $update_sql = "UPDATE `schedule` AS s JOIN `timeslot` AS t ON s.`timeslot` = t.`timeslot`
    //               SET s.`status` = 'Cancelled', s.`note` = 'Canceled Scheduled due to Time Slot Ended'
    //               WHERE (s.`status` = 'Waiting' AND s.`date` < ?)
    //               OR (s.`status` = 'Waiting' AND s.`date` = ? AND t.`time_end` < ?)";

    // No Time Slot
    $update_sql = "UPDATE `schedule` AS s JOIN `timeslot` AS t ON s.`timeslot` = t.`timeslot`
    SET s.`status` = 'Cancelled', s.`note` = 'Canceled Scheduled due to Time Slot Ended'
    WHERE s.`status` = 'Waiting' AND s.`date` < ?";

    $stmt = $conn->prepare($update_sql);
    if (!$stmt) {
        throw new Exception("Error preparing update statement: " . $conn->error);
    }

    // $stmt->bind_param('sss', $current_date, $current_date, $current_time);
    $stmt->bind_param('s', $current_date);

    try {
        $stmt->execute();
        return $stmt->affected_rows;
    } finally {
        $stmt->close();
    }
}

// function execute_update_process($conn, $current_date, $current_time_start)
// {
//     $update_sql = "UPDATE `schedule` AS s JOIN `timeslot` AS t ON s.`timeslot` = t.`timeslot`
//                   SET s.`status` = 'Process', s.`note` = 'The Scheduled is now on Process'
//                   WHERE (s.`status` = 'Waiting' AND s.`date` < ?)
//                   OR (s.`status` = 'Waiting' AND s.`date` = ? AND t.`time_start` < ?)";

//     $stmt = $conn->prepare($update_sql);
//     if (!$stmt) {
//         throw new Exception("Error preparing update statement: " . $conn->error);
//     }

//     $stmt->bind_param('sss', $current_date, $current_date, $current_time_start);

//     try {
//         $stmt->execute();
//         return $stmt->affected_rows;
//     } finally {
//         $stmt->close();
//     }
// }

// Function to insert a notification into the database
function insert_notification($conn, $title, $message, $type, $timestamp)
{
    $notification_sql = "INSERT INTO `notifications` (`title`, `message`, `type`, `timestamp`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($notification_sql);
    if (!$stmt) {
        throw new Exception("Error preparing notification statement: " . $conn->error);
    }

    $stmt->bind_param('ssss', $title, $message, $type, $timestamp);

    try {
        $stmt->execute();
    } finally {
        $stmt->close();
    }
}

// Function to log activity
function log_activity($conn, $action, $description, $schedule_id) {
    // Sanitize input
    $action = $conn->real_escape_string($action);
    $description = $conn->real_escape_string($description);
    $schedule_id = $conn->real_escape_string($schedule_id);

    // Get timestamp
    $timestamp = date("Y-m-d H:i:s");

    // Prepare and execute query using prepared statements
    $sql = "INSERT INTO `activity_logs` (`action`, `description`, `id`, `timestamp`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparing activity log statement: " . $conn->error);
    }

    $stmt->bind_param("ssss", $action, $description, $schedule_id, $timestamp);

    try {
        $stmt->execute();
        echo "Activity logged successfully.";
    } catch (Exception $e) {
        echo "Error logging activity: " . $stmt->error;
    } finally {
        $stmt->close();
    }
}

try {
    // Ensure the user is logged in
    if (isset($_SESSION['dentist_id'])) {
        $id = $_SESSION['dentist_id'];

        // Get user information from the database
        $result = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id` = '$id'");
        $row = mysqli_fetch_array($result);
    }

    // Get current date and time
    $current_date_time = date('Y-m-d H:i:s');
    $current_date = date('Y-m-d', strtotime($current_date_time));
    $current_time_start = date('H:i:s', strtotime($current_date_time));
    $current_time_end = date('H:i:s', strtotime($current_date_time));

    // Perform the update query
    // $cancelled_count = execute_update_cancelled($conn, $current_date, $current_time_end);
    $cancelled_count = execute_update_cancelled($conn, $current_date);

    // If update was successful, insert a notification message and log activity
    if ($cancelled_count > 0) {
        //Get all cancelled id and make it as schedule_id
  
        $title = "System Update";
        $notification_message = "Number of schedules cancelled today due Date ended: $cancelled_count";
        // $notification_message = "Number of schedules cancelled today due to time slot ended: $cancelled_count";
        $type = "schedule";
        insert_notification($conn, $title, $notification_message, $type, $current_date_time);

        // Log activity
        log_activity($conn, "Updated schedules", $notification_message, null);  // Specify the correct schedule_id if available
    } else {
        // echo "No records updated.";
        // Log activity
        // log_activity("No records updated.");
    }

    // Perform the update query
    // $process_count = execute_update_process($conn, $current_date, $current_time_start);

        // If update was successful, insert a notification message and log activity
        // if ($process_count > 0) {
        //     //Get all cancelled id and make it as schedule_id
      
        //     $title = "System Update";
        //     $notification_message = "Number of schedules process today due to time slot ended: $cancelled_count";
        //     $type = "schedule";
        //     insert_notification($conn, $title, $notification_message, $type, $current_date_time);
    
        //     // Log activity
        //     log_activity($conn, "Updated schedules", $notification_message, null);  // Specify the correct schedule_id if available
        // } else {
        //     // echo "No records updated.";
        //     // Log activity
        //     // log_activity("No records updated.");
        // }
    
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
    // Log activity
    // log_activity("Error occurred: " . $e->getMessage());
}

// Close the database connection if necessary
// if ($conn) {
//     $conn->close();
// }
?>