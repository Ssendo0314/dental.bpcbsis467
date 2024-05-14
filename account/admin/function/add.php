<?php
session_start();

// Include your database connection file
require_once('../../../dbcon.php');

if (isset($_POST['update_service_location_yes'])) { // Check if the form is submitted

    // Assuming you have sanitized your inputs for security (not shown here)
    $user_id = $_POST['user_id']; // Change from $_GET to $_POST
    $service_id = $_POST['service_id']; // Change from $_GET to $_POST
    $new_location_id = $_POST['location_id']; // Change from $_GET to $_POST

    // Retrieve the existing location IDs from the database or any other source
    $sql_select = "SELECT `location_id` FROM `service` WHERE `service_id`='$service_id'";
    $result = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_assoc($result);
    $existing_location_ids = $row['location_id'];

    // Concatenate the new location ID to the existing list, if it's not already present
    if ($existing_location_ids !== null) {
        $location_ids_array = explode(',', $existing_location_ids);
        if (!in_array($new_location_id, $location_ids_array)) {
            $location_ids_array[] = $new_location_id;
        }
        $updated_location_ids = implode(',', $location_ids_array);
    } else {
        $updated_location_ids = $new_location_id;
    }

    // Perform the database update
    $sql_update = "UPDATE `service` SET `location_id`='$updated_location_ids' WHERE `service_id`='$service_id'";

    if (mysqli_query($conn, $sql_update)) {
        // Add activity log
        serviceActivity_admin("Updated Available", "Updated availability for service ID $service_id", $user_id, $conn);

        // Set success message
        $_SESSION['success_message'] = "Service location updated successfully";
    } else {
        // Log error
        $failed = "Error updating service location: " . mysqli_error($conn);
        $_SESSION['failed'] = $failed;
    }
}

if (isset($_POST['remove_service_location'])) { // Check if the form is submitted

    // Assuming you have sanitized your inputs for security (not shown here)
    $user_id = $_POST['user_id']; // Change from $_GET to $_POST
    $service_id = $_POST['service_id']; // Change from $_GET to $_POST
    $remove_location_id = $_POST['location_id']; // Change from $_GET to $_POST

    // Retrieve the existing location IDs from the database or any other source
    $sql_select = "SELECT `location_id` FROM `service` WHERE `service_id`='$service_id'";
    $result = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_assoc($result);
    $existing_location_ids = $row['location_id'];

    // Remove the specified location ID from the existing list, if it exists
    if ($existing_location_ids !== null) {
        $location_ids_array = explode(',', $existing_location_ids);
        $updated_location_ids = array_diff($location_ids_array, array($remove_location_id));
        $updated_location_ids = implode(',', $updated_location_ids);

        // Perform the database update
        $sql_update = "UPDATE `service` SET `location_id`='$updated_location_ids' WHERE `service_id`='$service_id'";

        if (mysqli_query($conn, $sql_update)) {
            // Add activity log
            serviceActivity_admin("Updated Available", "Updated availability for service ID $service_id", $user_id, $conn);

            // Set success message
            $_SESSION['success'] = "Service location removed successfully";
        } else {
            // Log error
            $failed = "Error removing service location: " . mysqli_error($conn);
            $_SESSION['failed'] = $failed;
        }
    } else {
        // If the location ID list is empty or null, nothing to remove
        $_SESSION['failed'] = "No location IDs found for the service.";
    }
}

// Function to log activities
function serviceActivity_admin($action, $description, $user_id, $conn)
{
    // Sanitize input
    $action = mysqli_real_escape_string($conn, $action);
    $description = mysqli_real_escape_string($conn, $description);
    $user_id = mysqli_real_escape_string($conn, $user_id);

    // Get timestamp
    $timestamp = date("Y-m-d H:i:s");

    // Prepare and execute query using prepared statements
    $sql = "INSERT INTO activity_logs (action, description, user_id, timestamp) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $action, $description, $user_id, $timestamp);
    if ($stmt->execute()) {
        // Success message
        echo "Activity logged successfully";
    } else {
        // Error message
        echo "Error logging activity: " . $conn->error;
    }
}

// Redirect back
echo "<script>window.location.href=document.referrer;</script>";
?>
