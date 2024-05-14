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
}

function logpasword_Admin($action, $description, $userId, $conn)
{
    // Sanitize input
    $action = mysqli_real_escape_string($conn, $action);
    $description = mysqli_real_escape_string($conn, $description);
    $userId= mysqli_real_escape_string($conn, $userId);

    // Get timestamp
    $timestamp = date("Y-m-d H:i:s");

    // Prepare and execute query using prepared statements
    $sql = "INSERT INTO activity_logs (action, description, user_id, timestamp) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $action, $description, $userId, $timestamp);
    if ($stmt->execute()) {
        echo "Activity logged successfully";
    } else {
        echo "Error logging activity: " . $conn->error;
    }
}
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

<!-- Cancelled -->
<?php
if (isset($_GET['schedule_Cancelled'])) {
    // Ensure all required parameters are set
    if (isset($_GET['user_id'], $_GET['id'], $_GET['member_id'], $_GET['status'])) {
        // Retrieve parameters
        $user_id = $_GET['user_id'];
        $id = $_GET['id'];
        $member_id = $_GET['member_id'];
        $newStatus = $_GET['status'];

        // Prepare the update query using prepared statements to prevent SQL injection
        $cancelled_query = "UPDATE `schedule` SET `status`=?, `note`='Canceled scheduled activity due to Dentist' WHERE `id`=?";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $cancelled_query);

        if ($stmt === false) {
            // Handle prepare error
            exit("Prepare failed: " . htmlspecialchars(mysqli_error($conn)));
        }

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "si", $newStatus, $id);

        // Execute the statement
        $cancelled_result = mysqli_stmt_execute($stmt);

        // Check if update was successful
        if ($cancelled_result) {
            // Log activity
            $timestamp = date("Y-m-d H:i:s");
            $log_entry = "Schedule ID: $id | New Status: $newStatus | Timestamp: $timestamp\n";
            // Log the entry to a file or database table
            file_put_contents('activity.log', $log_entry, FILE_APPEND | LOCK_EX);

            // Log the activity to the database
            $action = "Schedule Update";
            $description = "Schedule ID $id status updated to $newStatus";
            $sql = "INSERT INTO activity_logs (action, description, user_id, member_id, id, timestamp) VALUES ('$action', '$description','$user_id', '$member_id', '$id','$timestamp')";
            mysqli_query($conn, $sql);

            // Redirect to a success page
            $_SESSION['success'] = "Successfully Updated";
            // header("Location: ../dashboard.php");
            exit(); // Stop further execution
        } else {
            // Handle the failure case
            // Log the activity to the database
            $action = "Schedule Update Failed";
            $description = "Failed to update schedule with ID $id";
            $timestamp = date("Y-m-d H:i:s");
            $sql = "INSERT INTO activity_logs (action, description, user_id, member_id, id, timestamp) VALUES ('$action', '$description','$user_id', '$member_id', '$id','$timestamp')";
            mysqli_query($conn, $sql);

            // Redirect to a failure page
            $_SESSION['failed'] = "Failed to update schedule";
            // header("Location: ../dashboard.php");
            exit(); // Stop further execution
        }
    } else {
        // Handle missing parameters
        exit("Missing parameters");
    }
}
?>

<!-- Done -->
<?php
if (isset($_GET['schedule_Done'])) {
    // Ensure all required parameters are set
    if (isset($_GET['user_id'], $_GET['id'], $_GET['member_id'], $_GET['status'])) {
        // Retrieve parameters
        $user_id = $_GET['user_id'];
        $id = $_GET['id'];
        $member_id = $_GET['member_id'];
        $newStatus = $_GET['status'];

        // Prepare the update query using prepared statements to prevent SQL injection
        $done_query = "UPDATE `schedule` SET `status`=? WHERE `id`=?";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $done_query);

        if ($stmt === false) {
            // Handle prepare error
            exit("Prepare failed: " . htmlspecialchars(mysqli_error($conn)));
        }

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "si", $newStatus, $id);

        // Execute the statement
        $done_result = mysqli_stmt_execute($stmt);

        // Check if update was successful
        if ($done_result) {
            // Log activity
            $timestamp = date("Y-m-d H:i:s");
            $log_entry = "Schedule ID: $id | New Status: $newStatus | Timestamp: $timestamp\n";
            // Log the entry to a file or database table
            file_put_contents('activity.log', $log_entry, FILE_APPEND | LOCK_EX);

            // Log the activity to the database
            $action = "Schedule Update";
            $description = "Schedule ID $id status updated to $newStatus";
            $sql = "INSERT INTO activity_logs (action, description, user_id, member_id, id, timestamp) VALUES ('$action', '$description','$user_id', '$member_id', '$id','$timestamp')";
            mysqli_query($conn, $sql);

            // Redirect to a success page
            $_SESSION['success'] = "Successfully Updated";
            // header("Location: ../dashboard.php");
            exit(); // Stop further execution
        } else {
            // Handle the failure case
            // Log the activity to the database
            $action = "Schedule Update Failed";
            $description = "Failed to update schedule with ID $id";
            $timestamp = date("Y-m-d H:i:s");
            $sql = "INSERT INTO activity_logs (action, description, user_id, member_id, id, timestamp) VALUES ('$action', '$description','$user_id', '$member_id', '$id','$timestamp')";
            mysqli_query($conn, $sql);

            // Redirect to a failure page
            $_SESSION['failed'] = "Failed to update schedule";
            // header("Location: ../dashboard.php");
            exit(); // Stop further execution
        }
    } else {
        // Handle missing parameters
        exit("Missing parameters");
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