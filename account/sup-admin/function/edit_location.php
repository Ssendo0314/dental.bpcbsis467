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
include ('../../../dbcon.php');

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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="../css/mystyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <title>Add Service - Admin </title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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

    <div class="container contact-form">
        <div class="contact-image">
            <img src="https://image.ibb.co/kUagtU/rocket_contact.png" alt="rocket_contact" />
        </div>
        <form method="post">
            <input type="hidden" id="user_id" class="form-control" value="<?php echo $row['user_id']; ?>" name="user_id"
                required>
            <h3>Edit Location</h3>
            <?php
            $location_id = $_GET['location_id'];
            $location_query = "SELECT * FROM `location` WHERE location_id='$location_id'";
            $location_result = mysqli_query($conn, $location_query);

            //while statement
            while ($location_row = mysqli_fetch_array($location_result)) {
                ?>
                <input type="hidden" id="location_id" value="<?php echo $location_row['location_id']; ?>"
                    name="location_id">
                <label for="location">Location:</label><br>
                <input class="form-control" type="text" id="location" name="location"
                    value="<?php echo $location_row['location']; ?>" placeholder="Enter location" required><br>
                <label for="about">About:</label><br>
                <textarea class="form-control" id="about" name="about" rows="4" cols="50"
                    value="<?php echo $location_row['about']; ?>" placeholder="Enter about" required></textarea><br>
                <label for="map">Map:</label><br>
                <input class="form-control" type="text" id="map" name="map" value="<?php echo $location_row['map']; ?>"
                    placeholder="Enter map URL" required><br>
                <label for="map_link">Map Link:</label><br>
                <input class="form-control" type="text" id="map_link" name="map_link" placeholder="Enter map link"
                    required><br>
                <label for="email">Email:</label><br>
                <input class="form-control" type="email" id="email" name="email" placeholder="Enter email" required><br>
                <label for="contact_no">Contact No:</label><br>
                <div class="input-group mb-3">
                    <!-- <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">09</span>
                    </div> -->
                    <input class="form-control" type="number" id="contact_no" name="contact_no"
                        placeholder="Enter contact number" maxlength="12" required>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" name="location_edit" class="btn btn-success">Submit</button>
                </div>
                <div class="form-group">
                    <a class="small-link" href="../shop.php">Back</a>
                </div>
                <hr>
            <?php } ?>
        </form>
    </div>

    <?php

    if (isset($_POST['location_edit'])) {
        $location_id = $_POST['location_id'];
        $user_id = $_POST['user_id'];
        $location = $_POST['location'];
        $about = $_POST['about'];
        $map = $_POST['map'];
        $map_link = $_POST['map_link'];
        $email = $_POST['email'];
        $contact_no = $_POST['contact_no'];

        if (!startsWith($contact_no, "09")) {
            $contact_no = "09" . $contact_no;
        }

        // Assuming $conn is your database connection object
        $query = "UPDATE location SET location='$location', about='$about', map='$map', map_link='$map_link', email='$email', contact_no='$contact_no' WHERE location_id='$location_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $_SESSION['success'] = "Location updated successfully";
            $action = "Updated location by Owner";
            $log_message = "Updated location: $location";
            $activity_query = "INSERT INTO `activity_logs` (`action`, `description`, `user_id`, `timestamp`) VALUES ('$action', '$log_message', '$user_id', NOW())";
            mysqli_query($conn, $activity_query);
            echo '<script>window.location.href = "../shop.php";</script>';
            exit();
        } else {
            $_SESSION['failed'] = "Failed to update location";
            echo '<script>window.location.href = "../shop.php";</script>';
            exit();
        }
    }

    function startsWith($string, $prefix)
    {
        return strncmp($string, $prefix, strlen($prefix)) === 0;
    }
    ?>
</body>

</html>