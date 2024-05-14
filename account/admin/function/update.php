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

<!-- update basic information-->
<!-- Portal; Setting, Update Profile -->
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
} else {
    $_SESSION['failed'] = "Fail Update the Profile " . $conn->error;
}

} ?>
<!-- update Social Media-->
<?php
// Check if form is submitted
if (isset($_POST['update_social'])) {
    // Escape user inputs for security
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $website_name = $conn->real_escape_string($_POST['website_name']);
    $website = $conn->real_escape_string($_POST['website']);
    $facebook = $conn->real_escape_string($_POST['facebook']);

    // Insert data into database
    $sql = "UPDATE `users` SET `website_name`='$website_name', `website`='$website', `facebook`='$facebook' WHERE `user_id`='$user_id'";

    if ($conn->query($sql) === TRUE) {
        // Log the activity to the database
        $action = "Update Profile";
        $activity_description = "Updated social media information";
        $activity_sql = "INSERT INTO activity_logs (action, description, user_id) VALUES ('$action','$activity_description', '$user_id')";
        $conn->query($activity_sql);

        $_SESSION['success'] = "Successfully Updated Information";
        // echo "<script>window.location.href='../profile.php'</script>";
    } else {
        $_SESSION['failed'] = "Fail to Updated Information";
        // echo "<script>window.location.href='../profile.php'</script>";
    }
}
?>
<!-- password_update_check -->
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

<!-- Active for member -->
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
        //echo "<script>window.location.href=document.referrer;</script>";
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
        //echo "<script>window.location.href=document.referrer;</script>";
    } else {
        // Handle missing parameters
        $_SESSION['failed'] = "Failed to Deactivate: Required parameters are missing";
        echo "<script>window.location.href=document.referrer;</script>";
    }
}
?>

<!-- Active for Staff and your Account -->
<!-- Portal; Setting, Update Profile -->
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
    $sql = "INSERT INTO activity_logs (action, description, user_id, timestamp) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $action, $description, $user_id, $timestamp);
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
function updateActivity_user_account($action, $description, $user_id, $conn)
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
    $stmt->bind_param("ssss", $action, $description, $user_id, $timestamp); // Changed "sssss" to "ssss"
    if ($stmt->execute()) {
        echo "Activity logged successfully";
    } else {
        echo "Error logging activity: " . $conn->error;
    }
}

// Update De-Active your account
if (isset($_GET['update_deactivate_staff_yourAccount'])) {
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
                updateActivity_user_account("Cancel Scheduled Activity", "Admin Account: $user_id canceled scheduled activity for user", $user_id, $conn);
            }
        }

        // Prepare and execute query using prepared statements to update member status
        $active_query = "UPDATE users SET status=? WHERE user_id=?";
        $stmt = $conn->prepare($active_query);
        $stmt->bind_param("ss", $status, $user_id);
        $stmt->execute();

        // Check for successful update
        if ($stmt->affected_rows > 0) {
            // Log admin activity
            updateActivity_user_account("Update Deactive", "Admin Account: $user_id successfully deactivated user $user_id", $user_id, $conn);
            // Redirect to logout page
            echo "<script>window.location.href='../../../logout.php';</script>";
            exit(); // Make sure to exit after redirection
        } else {
            // Session for failure
            $_SESSION['failed'] = "Failed to Deactivate";
        }
    } else {
        // Handle missing parameters
        $_SESSION['failed'] = "Failed to Deactivate: Required parameters are missing";
    }
}
?>

<?php
// Redirect back
echo "<script>window.history.back();</script>";
?>