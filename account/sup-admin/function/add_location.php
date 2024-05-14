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
    <!--Icon Link-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--CSS-->
    <link rel="stylesheet" type="text/css" href="../css/mystyle.css">
    <!--Chart-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <title>Add Sevrice - Admin </title>

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

    <div class="container contact-form">
        <div class="contact-image">
            <img src="https://image.ibb.co/kUagtU/rocket_contact.png" alt="rocket_contact" />
        </div>
        <form method="post">
            <!-- <input type="text" id="location_id" name="location_id"><br><br> -->
            <input type="hidden" id="user_id" class="form-control" value="<?php echo $row['user_id']; ?>" name="user_id"
                required>
            <h3>Add Location</h3>
            <label for="location">Location:</label><br>
            <input class="form-control" type="text" id="location" name="location" placeholder="Enter location"><br>
            <label for="about">About:</label><br>
            <textarea class="form-control" id="about" name="about" rows="4" cols="50"
                placeholder="Enter about"></textarea><br>
            <label for="map">Map:</label><br>
            <input class="form-control" type="text" id="map" name="map" placeholder="Enter map URL"><br>
            <label for="map_link">Map Link:</label><br>
            <input class="form-control" type="link" id="map_link" name="map_link" placeholder="Enter map link"><br>
            <label for="email">Email:</label><br>
            <input class="form-control" type="email" id="email" name="email" placeholder="Enter email"><br>
            <label for="contact_no">Contact No:</label><br>
            <div class="input-group mb-3">
                <!-- <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">09</span>
                </div> -->
                <input class="form-control" type="number" id="contact_no" name="contact_no"
                    placeholder="Enter contact number" maxlength="12">
            </div>
            <br>
            <div class="form-group">
                <button type="submit" name="location_add" class="btn btn-success">Submit</button>
            </div>
            <div class="form-group">
                <a class="small-link" href="../service.php">Back</a>
            </div>
            <hr>
        </form>
    </div>


    <?php
    if (isset($_POST['location_add'])) {
        // Handle form submission here
        $user_id = $_POST['user_id'];
        $location = $_POST['location'];
        $about = $_POST['about'];
        $map = $_POST['map'];
        $map_link = $_POST['map_link'];
        $email = $_POST['email'];
        $contact_no = $_POST['contact_no'];

        // Validate and sanitize input data as needed
    
        // // Automatically add "09" in the beginning of contact_no if not already added
        // if (!startsWith($contact_no, "09")) {
        //     $contact_no = "09" . $contact_no;
        // }

        // Perform database insertion or any other necessary operations
        // For example:
        $query = "INSERT INTO location (location, about, map, map_link, email, contact_no) 
    VALUES ('$location', '$about', '$map', '$map_link', '$email', '$contact_no')";
        $result = mysqli_query($conn, $query);

        // Example validation
        if ($result) {
            $_SESSION['success'] = "Successfully added";
            echo "<script>window.location.href='../shop.php'</script>";
            // For activity log
            $action = "Added New location by Owner";
            $log_message = "Added location: $location";
            // Assuming $conn is your database connection, adjust this query according to your database structure
            $activity_query = "INSERT INTO `activity_logs` (`action`,`description`,`user_id`, `timestamp`) VALUES ('$action','$log_message','$user_id', NOW())";
            mysqli_query($conn, $activity_query);
        } else {
            $_SESSION['failed'] = "Fail to Add location";
            echo "<script>window.location.href='../shop.php'</script>";
        }

        // Close connection
        mysqli_close($conn);
    }

    // Function to check if a string starts with a specific prefix
    function startsWith($string, $prefix)
    {
        return strncmp($string, $prefix, strlen($prefix)) === 0;
    }
    ?>




</body>

</html>