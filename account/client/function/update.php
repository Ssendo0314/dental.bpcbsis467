<?php
session_start();
require('../../../dbcon.php'); ?>

<!-- update Image profile -->
<?php
if (isset($_POST['image_upload'])) {
    // Check if member_id is set
    if (isset($_POST['member_id'])) {
        $member_id = $_POST['member_id'];

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
    $member_id = $_POST['member_id'];
    $image = basename($_FILES["image"]["name"]);

    $sql = "UPDATE members SET image = ? WHERE member_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $image, $member_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Image name saved in the database.";
        // Log activity
        logActivity_member("Updated Profile", "Upload Profile of User Id: $member_id", $member_id, $conn);
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

<?php
// Function to log activity
function logActivity_member($action, $description, $member_id, $conn)
{
    // Sanitize input
    $action = mysqli_real_escape_string($conn, $action);
    $description = mysqli_real_escape_string($conn, $description);
    $member_id = mysqli_real_escape_string($conn, $member_id);

    // Get timestamp
    $timestamp = date("Y-m-d H:i:s");

    // Prepare and execute query using prepared statements
    $sql = "INSERT INTO activity_logs (action, description, member_id, timestamp) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $action, $description, $member_id, $timestamp);
    if ($stmt->execute()) {
        echo "Activity logged successfully";
    } else {
        echo "Error logging activity: " . $conn->error;
    }
} ?>

<!-- Upload treatment -->
<?php
// Check if form submitted and file uploaded
if (isset($_POST['image_upload_treatment']) && isset($_FILES['image'])) {
    // Check if member_id is set
    if (isset($_POST['member_id'])) {
        $member_id = $_POST['member_id'];

        // Check if image is set and not empty
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "../../../picture/treatment/";

            // Check if the directory exists, if not, create it
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_name = $_FILES['image']['name'];
            $target_file = $target_dir . basename($_FILES["image"]["name"]);

            // Check if file already exists
            if (file_exists($target_file)) {
                $_SESSION['failed'] = "Sorry, file already exists.";
                echo "<script>window.history.back();</script>";
                exit; // Stop further execution
            }

            // Check file size
            if ($_FILES["image"]["size"] > 500000) { // Adjust the size limit as needed
                $_SESSION['failed'] = "Sorry, your file is too large.";
                echo "<script>window.history.back();</script>";
                exit; // Stop further execution
            }

            // Allow only specific file formats (you can adjust as needed)
            $allowed_formats = array("jpg", "jpeg", "png", "gif");
            $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_formats)) {
                $_SESSION['failed'] = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
                echo "<script>window.history.back();</script>";
                exit; // Stop further execution
            }

            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // File uploaded successfully, now insert file path into database

                // Assuming you have a database connection already established

                // Prepare SQL statement to insert file path into database
                $stmt = $conn->prepare("INSERT INTO images (member_id, image) VALUES (?, ?)");
                $stmt->bind_param("ss", $member_id, $file_name);

                // Execute SQL statement
                if ($stmt->execute()) {
                    $_SESSION['message'] = "The file " . basename($_FILES["image"]["name"]) . " has been uploaded and saved to the database.";
                    $_SESSION['image'] = $target_file;
                    echo "<script>window.history.back();</script>";
                } else {
                    $_SESSION['failed'] = "Sorry, there was an error saving file path to the database.";
                    echo "<script>window.history.back();</script>";
                }

                // Close statement
                $stmt->close();
            } else {
                $_SESSION['failed'] = "Sorry, there was an error uploading your file.";
                echo "<script>window.history.back();</script>";
            }
        } else {
            $_SESSION['failed'] = "Image not received or uploaded.";
            echo "<script>window.history.back();</script>";
        }
    } else {
        $_SESSION['failed'] = "Member ID not received.";
        echo "<script>window.history.back();</script>";
    }
} else {
    $_SESSION['failed'] = "Form submission failed or file not uploaded.";
    echo "<script>window.history.back();</script>";
}
?>


<!-- update basic information-->
<?php if (isset($_POST['basicinformation'])) {

    $member_id = $_POST['member_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];


    $query = "UPDATE `members` SET `firstname`='$firstname',`lastname`='$lastname',`middlename`='$middlename',
    `address`='$address',`email`='$email',`contact_no`='$contact_no' WHERE `member_id`='$member_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Log the activity to the database
        $action = "Update Profile";
        $activity_description = "Updated Information";
        $activity_sql = "INSERT INTO activity_logs (action, description, member_id) VALUES ('$action','$activity_description', '$member_id')";
        $conn->query($activity_sql);

        $_SESSION['success'] = "Successfully Updated Information";
        echo "<script>window.location.href='../profile.php'</script>";
    } else {
        $_SESSION['failed'] = "Fail to Updated Information";
        echo "<script>window.location.href='../profile.php'</script>";
    }
} ?>
<!-- update Guardian Information -->
<?php if (isset($_POST['gru_inform'])) {

    $member_id = $_POST['member_id'];
    $guardianfirstname = $_POST['guardianfirstname'];
    $guardianmiddlename = $_POST['guardianmiddlename'];
    $guardianlastname = $_POST['guardianlastname'];
    $guardian_contact_no = $_POST['guardian_contact_no'];

    $query = "UPDATE `members` SET `guardianfirstname`='$guardianfirstname',`guardianmiddlename`='$guardianmiddlename',
`middlename`='$middlename',`guardianlastname`='$guardianlastname',`guardian_contact_no`='$guardian_contact_no' WHERE `member_id`='$member_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Log the activity to the database
        $action = "Update Profile";
        $activity_description = "Updated Information";
        $activity_sql = "INSERT INTO activity_logs (action, description, member_id) VALUES ('$action','$activity_description', '$member_id')";
        $conn->query($activity_sql);

        $_SESSION['success'] = "Successfully Updated Information";
        echo "<script>window.location.href='../profile.php'</script>";
    } else {
        $_SESSION['failed'] = "Fail to Updated Information";
        echo "<script>window.location.href='../profile.php'</script>";
    }
} ?>
<!-- update Social Media-->
<?php
// Check if form is submitted
if (isset($_POST['update_social'])) {
    // Escape user inputs for security
    $member_id = $conn->real_escape_string($_POST['member_id']);
    $facebook = $conn->real_escape_string($_POST['facebook']);
    $website_name = $conn->real_escape_string($_POST['website_name']);
    $website = $conn->real_escape_string($_POST['website']);

    // Insert data into database
    $sql = "UPDATE `members` SET `facebook`='$facebook', `website_name`='$website_name', `website`='$website' WHERE `member_id`='$member_id'";

    if ($conn->query($sql) === TRUE) {
        // Log the activity to the database
        $action = "Update Profile";
        $activity_description = "Updated social media information";
        $activity_sql = "INSERT INTO activity_logs (action, description, member_id) VALUES ('$action','$activity_description', '$member_id')";
        $conn->query($activity_sql);

        $_SESSION['success'] = "Successfully Updated Information";
        echo "<script>window.location.href='../profile.php'</script>";
    } else {
        $_SESSION['failed'] = "Fail to Updated Information";
        echo "<script>window.location.href='../profile.php'</script>";
    }
}
?>

<!-- Cancelled -->
<?php
if (isset($_GET['schedule_Cancelled'])) {
    // Retrieve parameters
    $id = $_GET['id']; // URL example: ?id=12 = param
    $member_id = $_GET['member_id'];
    $newStatus = $_GET['status'];

    // Prepare the update query using prepared statements to prevent SQL injection
    $cancelled_query = "UPDATE `schedule` SET `status`=? WHERE `id`=?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $cancelled_query);

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
        $sql = "INSERT INTO activity_logs (action, description, member_id, timestamp) VALUES ('$action', '$description', '$member_id', '$timestamp')";
        mysqli_query($conn, $sql);

        // Redirect to a success page
        $_SESSION['success'] = "Successfully Updated";
        header("Location: ../dashboard.php");
        exit(); // Stop further execution
    } else {
        // Handle the failure case
        // Log the activity to the database
        $action = "Schedule Update Failed";
        $description = "Failed to update schedule with ID $id";
        $timestamp = date("Y-m-d H:i:s");
        $sql = "INSERT INTO activity_logs (action, description, member_id, timestamp) VALUES ('$action', '$description', '$member_id', '$timestamp')";
        mysqli_query($conn, $sql);

        // Redirect to a failure page
        $_SESSION['failed'] = "Failed to update schedule";
        header("Location: ../dashboard.php");
        exit(); // Stop further execution
    }
}
?>

<?php
// password_update_check
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password_update_check'])) {
    // Retrieve form data
    $memberId = $_POST['member_id'];
    $currentPassword = $_POST['currentPassword'];

    // Sanitize inputs and escape SQL injection
    $memberId = $conn->real_escape_string($memberId);

    // Query to fetch user's current password from the database
    $sql = "SELECT * FROM members WHERE member_id = '$memberId' AND password = '$currentPassword'";
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

//update Password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password_change'])) {
    //try {
    // Retrieve form data
    $memberId = $_POST['member_id'];
    //$currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    //$confirmPassword = $_POST['confirmPassword'];

    // Sanitize inputs and escape SQL injection
    $memberId = $conn->real_escape_string($memberId);

    // Query to fetch user's current password from the database
    $sql = "UPDATE members SET `password`='$newPassword' WHERE `member_id`='$memberId'";
    mysqli_query($conn, $sql);

    if ($result) {
        // Log the activity to the database
        $action = "Update Profile";
        $activity_description = "Updated Information";
        $activity_sql = "INSERT INTO activity_logs (action, description, member_id) VALUES ('$action','$activity_description', '$member_id')";
        $conn->query($activity_sql);
        
        //echo "updated password";
        $_SESSION['success'] = "User change password successfully";
    } else {
        $_SESSION['failed'] = "User did not password";
        //echo "Error: " . $conn->error;
    }
    //} catch (\Throwable $th) {
    //throw $th;
    //}
}
?>