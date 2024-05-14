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
include('../../../dbcon.php');

// Function to log activities
function logActivity($action, $description, $userId, $conn)
{
    $timestamp = date('Y-m-d H:i:s');
    $sql = "INSERT INTO activity_logs ( action, description, user_id, timestamp) VALUES ('$action','$description', '$userId', '$timestamp')";
    mysqli_query($conn, $sql);
}

//Profile show
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $result = mysqli_query($conn, "Select * from `users` where `user_id`='$id'");
    $row = mysqli_fetch_array($result);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Icon Link-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--CSS-->
    <link rel="stylesheet" type="text/css" href="../css/mystyle.css">
    <!--Chart-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <title>Edit Testimony - Admin </title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <style>
        body {
            background: -webkit-linear-gradient(left, #0072ff, #00c6ff);
        }

        .contact-form {
            background: #fff;
            margin-top: 10%;
            margin-bottom: 5%;
            width: 70%;
        }

        .contact-form .form-control {
            border-radius: 1rem;
        }

        .contact-image {
            text-align: center;
        }

        .contact-image img {
            border-radius: 6rem;
            width: 11%;
            margin-top: -3%;
            transform: rotate(29deg);
        }

        .contact-form form {
            padding: 14%;
        }

        .contact-form form .row {
            margin-bottom: -7%;
        }

        .contact-form h3 {
            margin-bottom: 8%;
            margin-top: -10%;
            text-align: center;
            color: #0062cc;
        }

        .contact-form .btnContact {
            width: 50%;
            border: none;
            border-radius: 1rem;
            padding: 1.5%;
            background: #dc3545;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
        }

        .btnContactSubmit {
            width: 50%;
            border-radius: 1rem;
            padding: 1.5%;
            color: #fff;
            background-color: #0062cc;
            border: none;
            cursor: pointer;
        }
    </style>

</head>

<body>

    <?php
    //Profile show
    $id = $_GET['testimony_id'];
    $query = "SELECT * FROM `testimony` WHERE testimony_id ='$id'";
    $edit_result = mysqli_query($conn, $query);
    $edit_row = mysqli_fetch_array($edit_result);
    ?>

    <div class="container contact-form">
        <div class="contact-image">
            <img src="https://image.ibb.co/kUagtU/rocket_contact.png" alt="rocket_contact" />
        </div>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="user_id" class="form-control" value="<?php echo $row['user_id']; ?>" name="user_id"
                required>
            <input type="hidden" name="testimony_id" id="testimony_id" value="<?= $edit_row['testimony_id'] ?>">
            <h3>Edit Testimony</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="firstname">
                            <strong>First Name</strong>
                        </label>
                        <input type="text" id="firstname" class="form-control"
                            value="<?php echo $edit_row['firstname']; ?>" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">
                            <strong>Last Name</strong>
                        </label>
                        <input type="text" id="lastname" class="form-control"
                            value="<?php echo $edit_row['lastname']; ?>" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="testimony">
                            <strong>Testimony</strong>
                        </label>
                        <textarea type="text" id="testimony" class="form-control" name="testimony"
                            required><?php echo $edit_row['testimony']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="media">
                            <strong>Media</strong>
                        </label>
                        <input type="text" id="media" class="form-control" value="<?php echo $edit_row['media']; ?>"
                            name="media" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="testimony_edit" class="btnContact">Edit Testimony</button>
                    </div>
                    <div class="form-group">
                        <a class="small-link" href="../testimony.php">Back</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php
    // Edit Testimony
    if (isset($_POST['testimony_edit'])) {
        $user_id = $_POST['user_id'];
        $testimonyId = $_POST['testimony_id'];
        $firstName = $_POST['firstname'];
        $lastName = $_POST['lastname'];
        $testimony = $_POST['testimony'];
        $media = $_POST['media'];

        $updateQuery = "UPDATE testimony SET firstname='$firstName', lastname='$lastName', testimony='$testimony', media='$media' WHERE testimony_id='$testimonyId'";
        $result = mysqli_query($conn, $updateQuery);

        if ($result) {
            // Log activity
            logActivity("Update Testimony", "Update testimony with ID: $testimonyId", $user_id, $conn, );
            $_SESSION['success'] = "Testimony edited successfully.";
            // Redirect back
            echo "<script>window.location.href='../testimony.php'</script>";
        } else {
            $_SESSION['failed'] = "Failed to edit testimony. Please try again.";
            // Redirect back
            echo "<script>window.location.href='../testimony.php'</script>";
        }
    }
    ?>
</body>

</html>