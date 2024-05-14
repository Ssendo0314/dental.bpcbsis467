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
        //echo "<script>window.history.back();</script>";
    } else {
        $_SESSION['error'] = "Error updating database: " . $conn->error;
        // Redirect to the previous page
        echo "<script>window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();

    // Redirect to the previous page
    // echo "<script>window.history.back();</script>";
}
?>