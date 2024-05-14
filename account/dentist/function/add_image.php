<?php
session_start();
// Include your database connection file
require_once ('../../../dbcon.php'); ?>

<!-- Upload treatment -->
<?php

// Check if form submitted and file uploaded
if (isset($_POST['image_upload_treatment']) && isset($_FILES['image'])) {
    // Check if all required fields are set
    if (isset($_POST['image_title']) && isset($_POST['description']) && isset($_POST['id']) && isset($_POST['user_id']) && isset($_POST['member_id'])) {
        // Additional variables
        $image_title = $_POST['image_title'];
        $description = $_POST['description'];
        $id = $_POST['id'];
        $user_id = $_POST['user_id'];
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
                exit_with_error();
            }

            // Check file size
            if ($_FILES["image"]["size"] > 500000) { // Adjust the size limit as needed
                $_SESSION['failed'] = "Sorry, your file is too large.";
                exit_with_error();
            }

            // Allow only specific file formats (you can adjust as needed)
            $allowed_formats = array("jpg", "jpeg", "png", "gif");
            $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_formats)) {
                $_SESSION['failed'] = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
                exit_with_error();
            }

            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // File uploaded successfully, now insert file path into database

                // Prepare SQL statement to insert file path into database
                $stmt = $conn->prepare("INSERT INTO images (`image_title`, `image`, `id`, `user_id`, `member_id`, `timestamp`) VALUES ( ?, ?, ?, ?, ?, NOW())");
                $description = ""; // Assuming you have no description field or you want to leave it blank
                $stmt->bind_param("sssss", $image_title, $file_name, $id, $user_id, $member_id);

                // Execute SQL statement
                if ($stmt->execute()) {
                    $_SESSION['message'] = "The file " . basename($_FILES["image"]["name"]) . " has been uploaded and saved to the database.";
                    $_SESSION['image'] = $target_file;
                    exit_with_success();
                } else {
                    $_SESSION['failed'] = "Sorry, there was an error saving file path to the database.";
                    exit_with_error();
                }

                // Close statement
                $stmt->close();
            } else {
                $_SESSION['failed'] = "Sorry, there was an error uploading your file.";
                exit_with_error();
            }
        } else {
            $_SESSION['failed'] = "Image not received or uploaded.";
            exit_with_error();
        }
    } else {
        $_SESSION['failed'] = "Required fields not received.";
        exit_with_error();
    }
} else {
    $_SESSION['failed'] = "Form submission failed or file not uploaded.";
    exit_with_error();
}

// Function to exit with an error message
function exit_with_error()
{
    echo "<script>window.history.back();</script>";
    exit; // Stop further execution
}

// Function to exit with a success message
function exit_with_success()
{
    echo "<script>window.history.back();</script>";
    exit; // Stop further execution
}
?>