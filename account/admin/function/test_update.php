<?php
session_start();

// Include your database connection file
require_once('../../../dbcon.php'); ?>

<?php
function logActivity_Admin($action, $description, $user_id, $conn)
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
        echo "Activity logged successfully";
    } else {
        echo "Error logging activity: " . $conn->error;
    }
} ?>
?>

<!-- update Image profile -->
<?php
if (isset($_POST['image_upload'])) {
    // Check if user_id is set
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        // Check if image is set and not empty
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "../../../picture/profile/";

            // Check if the directory exists, if not, create it
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir . basename($_FILES["image"]["name"]);

            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $_SESSION['message'] = "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";

                // Display the uploaded image with a maximum width of 110 pixels
                $_SESSION['image'] = $target_file;
                // Redirect to the previous page
                echo "<script>window.history.back();</script>";
            } else {
                $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                // Debugging: Output the file upload error
                $_SESSION['error'] .= "Error code: " . $_FILES["image"]["error"];
                // Redirect to the previous page
                echo "<script>window.history.back();</script>";
            }
        } else {
            $_SESSION['error'] = "Image not received or uploaded.";
            // Redirect to the previous page
            echo "<script>window.history.back();</script>";
        }
    } else {
        $_SESSION['error'] = "Member ID not received.";
        // Redirect to the previous page
        echo "<script>window.history.back();</script>";
    }
} else {
    $_SESSION['error'] = "Form submission failed.";
    // Redirect to the previous page
    echo "<script>window.history.back();</script>";
}

if (isset($_POST['image_upload'])) {
    $user_id = $_POST['user_id'];
    $image = basename($_FILES["image"]["name"]);

    $sql = "UPDATE users SET image = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $image, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Image name saved in the database.";
        // Log activity
        logActivity_Admin("Updated Profile", "Upload Profile of User Id: You", $user_id, $conn);
        // Redirect to the previous page
        echo "<script>window.history.back();</script>";
    } else {
        $_SESSION['error'] = "Error updating database: " . $conn->error;
        // Redirect to the previous page
        echo "<script>window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();

    // Redirect to the previous page
    echo "<script>window.history.back();</script>";
}
?>

<!-- update basic information-->
<?php if (isset($_POST['basicinformation'])) {

    $user_id = $_POST['user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $bio = $_POST['bio'];


    $query = "UPDATE `users` SET `firstname`='$firstname',`lastname`='$lastname',`middlename`='$middlename',
    `address`='$address',`email`='$email',`contact_no`='$contact_no', `bio`='$bio' WHERE `user_id`='$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['success'] = "Update the Profile.";
        // Log activity
        logActivity_Admin("Updated Profile", "Upload Profile Information of User Id: You", $user_id, $conn);
        // Redirect to the previous page
        echo "<script>window.history.back();</script>";

    } else {
        $_SESSION['failed'] = "Fail Update the Profile " . $conn->error;
        // Redirect to the previous page
        echo "<script>window.history.back();</script>";
    }

} ?>


<?php
// Update Active
if (isset($_GET['update_active'])) {
    // Check if all necessary parameters are set
    if (isset($_GET['user_id'], $_GET['member_id'], $_GET['status'])) {

        // Sanitize input
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        $member_id = mysqli_real_escape_string($conn, $_GET['member_id']);
        $status = mysqli_real_escape_string($conn, $_GET['status']);

        // Prepare and execute query using prepared statements
        $active_query = "UPDATE members SET status=? WHERE member_id=?";
        $stmt = $conn->prepare($active_query);
        $stmt->bind_param("si", $status, $member_id);
        $stmt->execute();

        // Check for successful update
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Successfully Activated";
            // Log admin activity
            updateActivity_admin("Update Active", "Admin Account: $user_id successfully activated member $member_id", $user_id, $member_id, $conn);
        } else {
            // Session for failure
            $_SESSION['failed'] = "Failed to Activate";
        }
        // Redirect back
        echo "<script>window.location.href=document.referrer;</script>";
    } else {
        // Handle missing parameters
        $_SESSION['failed'] = "Failed to Activate: Required parameters are missing";
        echo "<script>window.location.href=document.referrer;</script>";
    }
}

// Function to update admin activity
function updateActivity_admin($action, $description, $user_id, $member_id, $conn)
{
    // Sanitize input
    $action = mysqli_real_escape_string($conn, $action);
    $description = mysqli_real_escape_string($conn, $description);
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $member_id = mysqli_real_escape_string($conn, $member_id);

    // Get timestamp
    $timestamp = date("Y-m-d H:i:s");

    // Prepare and execute query using prepared statements
    $sql = "INSERT INTO activity_logs (action, description, user_id, member_id, timestamp) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $action, $description, $user_id, $member_id, $timestamp);
    if ($stmt->execute()) {
        echo "Activity logged successfully";
    } else {
        echo "Error logging activity: " . $conn->error;
    }
}

// Update De-Active 
if (isset($_GET['update_deactivate'])) {
    // Check if all necessary parameters are set
    if (isset($_GET['user_id'], $_GET['member_id'], $_GET['status'])) {
        // Sanitize input
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        $member_id = mysqli_real_escape_string($conn, $_GET['member_id']);
        $status = mysqli_real_escape_string($conn, $_GET['status']);

        // Check if there's a scheduled activity for this member with status 'Waiting for the schedule'
        // Assume there's a table named 'schedule' with columns 'member_id', 'status', and 'note'
        $check_query = "SELECT id FROM schedule WHERE member_id = ? AND status = 'Waiting'";
        $stmt_check = $conn->prepare($check_query);
        $stmt_check->bind_param("i", $member_id);
        $stmt_check->execute();
        $stmt_check->store_result();

        // If there's a scheduled activity with status 'Waiting for the schedule', cancel it
        if ($stmt_check->num_rows > 0) {
            // Cancel scheduled activity
            $cancel_query = "UPDATE schedule SET status = 'Cancelled', note = 'Canceled scheduled activity due to deactivation' WHERE member_id = ? AND status = 'Waiting'";
            $stmt_cancel = $conn->prepare($cancel_query);
            $stmt_cancel->bind_param("i", $member_id);
            $stmt_cancel->execute();
            // Check for successful cancellation
            if ($stmt_cancel->affected_rows > 0) {
                // Log admin activity
                updateActivity_admin("Cancel Scheduled Activity", "Admin Account: $user_id canceled scheduled activity for member $member_id", $user_id, $member_id, $conn);
            }
        }

        // Prepare and execute query using prepared statements to update member status
        $active_query = "UPDATE members SET status=? WHERE member_id=?";
        $stmt = $conn->prepare($active_query);
        $stmt->bind_param("si", $status, $member_id);
        $stmt->execute();

        // Check for successful update
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Successfully Deactivated";
            // Log admin activity
            updateActivity_admin("Update Deactive", "Admin Account: $username successfully deactivated member $member_id", $user_id, $member_id, $conn);
        } else {
            // Session for failure
            $_SESSION['failed'] = "Failed to Deactivate";
        }
        // Redirect back
        echo "<script>window.location.href=document.referrer;</script>";
    } else {
        // Handle missing parameters
        $_SESSION['failed'] = "Failed to Deactivate: Required parameters are missing";
        echo "<script>window.location.href=document.referrer;</script>";
    }
}

?>

<?php
// Update Active
if (isset($_GET['update_active_staff'])) {
    // Check if all necessary parameters are set
    if (isset($_GET['user_id'], $_GET['status'])) {

        // Sanitize input
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        $status = mysqli_real_escape_string($conn, $_GET['status']);

        // Prepare and execute query using prepared statements
        $active_query = "UPDATE users SET status=? WHERE user_id=?";
        $stmt = $conn->prepare($active_query);
        $stmt->bind_param("ss", $status, $user_id);
        $stmt->execute();

        // Check for successful update
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Successfully Activated";
            // Log admin activity
            updateActivity_user_admin("Update Active", "Admin Account: $user_id successfully activated $user_id", $user_id, $conn);
        } else {
            // Session for failure
            $_SESSION['failed'] = "Failed to Activate";
        }
        // Redirect back
        //echo "<script>window.location.href=document.referrer;</script>";
    } else {
        // Handle missing parameters
        $_SESSION['failed'] = "Failed to Activate: Required parameters are missing";
        echo "<script>window.location.href=document.referrer;</script>";
    }
}

// Function to update admin activity
function updateActivity_user_admin($action, $description, $user_id, $conn)
{
    // Sanitize input
    $action = mysqli_real_escape_string($conn, $action);
    $description = mysqli_real_escape_string($conn, $description);
    $user_id = mysqli_real_escape_string($conn, $user_id);

    // Get timestamp
    $timestamp = date("Y-m-d H:i:s");

    // Prepare and execute query using prepared statements
    $sql = "INSERT INTO activity_logs (action, description, user_id, timestamp) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $action, $description, $user_id, $timestamp);
    if ($stmt->execute()) {
        echo "Activity logged successfully";
    } else {
        echo "Error logging activity: " . $conn->error;
    }
}

// Update De-Active 
if (isset($_GET['update_deactivate_staff'])) {
    // Check if all necessary parameters are set
    if (isset($_GET['user_id'], $_GET['status'])) {
        // Sanitize input
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        $status = mysqli_real_escape_string($conn, $_GET['status']);

        // Check if there's a scheduled activity for this member with status 'Waiting for the schedule'
        // Assume there's a table named 'schedule' with columns 'user_id', 'status', and 'note'
        $check_query = "SELECT id FROM schedule WHERE user_id = ? AND status = 'Waiting'";
        $stmt_check = $conn->prepare($check_query);
        $stmt_check->bind_param("s", $user_id);
        $stmt_check->execute();
        $stmt_check->store_result();

        // If there's a scheduled activity with status 'Waiting for the schedule', cancel it
        if ($stmt_check->num_rows > 0) {
            // Cancel scheduled activity
            $cancel_query = "UPDATE schedule SET status = 'Cancelled', note = 'Canceled scheduled activity due to deactivation' WHERE user_id = ? AND status = 'Waiting'";
            $stmt_cancel = $conn->prepare($cancel_query);
            $stmt_cancel->bind_param("s", $user_id);
            $stmt_cancel->execute();
            // Check for successful cancellation
            if ($stmt_cancel->affected_rows > 0) {
                // Log admin activity
                updateActivity_user_admin("Cancel Scheduled Activity", "Admin Account: $user_id canceled scheduled activity for user", $user_id, $conn);
            }
        }

        // Prepare and execute query using prepared statements to update member status
        $active_query = "UPDATE users SET status=? WHERE user_id=?";
        $stmt = $conn->prepare($active_query);
        $stmt->bind_param("ss", $status, $user_id);
        $stmt->execute();

        // Check for successful update
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Successfully Deactivated";
            // Log admin activity
            updateActivity_user_admin("Update Deactive", "Admin Account: $user_id successfully deactivated user $user_id", $user_id, $conn);
        } else {
            // Session for failure
            $_SESSION['failed'] = "Failed to Deactivate";
        }
        // Redirect back
        //echo "<script>window.location.href=document.referrer;</script>";
    } else {
        // Handle missing parameters
        $_SESSION['failed'] = "Failed to Deactivate: Required parameters are missing";
        echo "<script>window.location.href=document.referrer;</script>";
    }
}
?>

<?php
//services
//update Available  
if (isset($_GET['update_Available'])) {
    $user_id = $_GET['user_id'];
    $id = $_GET['service_id']; // URL example: ?id=12 = param
    $status = $_GET['status'];

    $active_query = "UPDATE `service` SET `status`='$status' WHERE `service_id`='$id'";

    //connection
    $active_result = mysqli_query($conn, $active_query);

    //For successfully added message
    if ($active_result) {
        $_SESSION['success'] = "Successfully Available";
        // Add activity log
        seviceActivity_admin("Updated Available", "Updated availability for service ID $id to $status", $user_id, $conn);
        // Redirect back
        echo "<script>window.location.href=document.referrer;</script>";
    } else {
        $_SESSION['failed'] = "Failed to change availability";
        // Redirect back
        echo "<script>window.location.href=document.referrer;</script>";
    }
}

// Function to log activities
function seviceActivity_admin($action, $description, $user_id, $conn)
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
        echo "Activity logged successfully";
    } else {
        echo "Error logging activity: " . $conn->error;
    }
}

//update Not Available 
if (isset($_GET['update_NotAvailable'])) {
    $user_id = $_GET['user_id'];
    $id = $_GET['service_id']; // URL example: ?id=12 = param
    $status = $_GET['status'];

    $active_query = "UPDATE `service` SET `status`='$status' WHERE `service_id`='$id'";

    //connection
    $active_result = mysqli_query($conn, $active_query);

    //For successfully added message
    if ($active_result) {
        $_SESSION['success'] = "Successfully Not Available";
        // Add activity log
        seviceActivity_admin("Updated Not Available", "Updated Not Available for service ID $id to $status", $user_id, $conn);
        // Redirect back
        echo "<script>window.location.href=document.referrer;</script>";
    } else {
        $_SESSION['failed'] = "Failed to change availability";
        // Redirect back
        echo "<script>window.location.href=document.referrer;</script>";
    }
}
?>

<?php
//services
//update Available  
if (isset($_GET['update_highlight_yes'])) {
    $user_id = $_GET['user_id'];
    $id = $_GET['service_id']; // URL example: ?id=12 = param
    $status = $_GET['status'];
    $highlight = $_GET['highlight'];

    // Check if status is available
    if ($status != 'Not Available') {
        $_SESSION['failed'] = "Service status is not available. Cannot update highlight.";
        echo "<script>window.location.href=document.referrer;</script>";
        exit; // Stop further execution
    }

    $active_query = "UPDATE `service` SET `highlight` = '$highlight' WHERE `service_id`='$id' and `status`= 'Available'";

    //connection
    $active_result = mysqli_query($conn, $active_query);

    //For successfully added message
    if ($active_result) {
        $_SESSION['success'] = "Successfully Highlight";
        // Add activity log
        seviceActivity_admin("Updated Highlight", "Updated Highlight for service ID $id to $status", $user_id, $conn);
        // Redirect back
        echo "<script>window.location.href=document.referrer;</script>";
    } else {
        $_SESSION['failed'] = "Failed to change Highlight";
        // Redirect back
        echo "<script>window.location.href=document.referrer;</script>";
    }
}

//update Not Available 
if (isset($_GET['update_highlight_no'])) {
    $user_id = $_GET['user_id'];
    $id = $_GET['service_id']; // URL example: ?id=12 = param
    $status = $_GET['status'];
    $highlight = $_GET['highlight'];

    // Check if status is available
    if ($status != 'Not Available') {
        $_SESSION['failed'] = "Service status is not available. Cannot update highlight.";
        echo "<script>window.location.href=document.referrer;</script>";
        exit; // Stop further execution
    }

    $active_query = "UPDATE `service` SET `highlight` = '$highlight' WHERE `service_id`='$id' and `status`= 'Available'";

    //connection
    $active_result = mysqli_query($conn, $active_query);

    //For successfully added message
    if ($active_result) {
        $_SESSION['success'] = "Successfully Not Highligh";
        // Add activity log
        seviceActivity_admin("Updated Not Highlight", "Updated Not Highlight for service ID $id to $status", $user_id, $conn);
        // Redirect back
        echo "<script>window.location.href=document.referrer;</script>";
    } else {
        $_SESSION['failed'] = "Failed to change Highlight";
        // Redirect back
        echo "<script>window.location.href=document.referrer;</script>";
    }
}
?>

<?php
// password_update_check
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password_update_check'])) {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $currentPassword = $_POST['currentPassword'];

    // Sanitize inputs and escape SQL injection
    $user_id = $conn->real_escape_string($user_id);

    // Query to fetch user's current password from the database
    $sql = "SELECT * FROM users WHERE user_id = '$user_id' AND password = '$currentPassword'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $_SESSION['success_user'] = "User found.";
        } else {
            // Passwords do not match
            $_SESSION['failed'] = "Failed to update information. Incorrect password.";
        }
    } else {
        // Query execution error
        $_SESSION['failed'] = "Failed to update information. Database error.";
        // Redirect to profile page or perform any necessary action
        // header("Location: ../profile.php");
        // exit();
    }
}
?>