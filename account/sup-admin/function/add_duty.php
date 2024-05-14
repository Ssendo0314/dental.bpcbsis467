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
    <title>Edit Sevrice - Admin </title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->


    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
        href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">

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
    $location_id = $_GET['location_id'];
    $location_query = "SELECT * FROM `location` WHERE location_id='$location_id'";
    $result = mysqli_query($conn, $location_query);
    while ($location_row = mysqli_fetch_array($result)) {
        ?>
        <div class="container contact-form">
            <div class="contact-image">
                <img src="https://image.ibb.co/kUagtU/rocket_contact.png" alt="rocket_contact" />
            </div>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" id="user_id" class="form-control" value="<?php echo $row['user_id']; ?>" name="user_id"
                    required>
                <h3>Add Duty</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Select User</label>
                            <select name="user" class="form-control" required>
                                <?php
                                // Fetch users who have no duty associated
                                $query = mysqli_query($conn, "SELECT * FROM users WHERE `status` = 'active' AND `location_id` = {$location_row['location_id']} AND user_id NOT IN (SELECT user_id FROM duty)") or die(mysqli_error($conn));
                                while ($row1 = mysqli_fetch_array($query)) {
                                    ?>
                                    <option value="<?php echo $row1['user_id']; ?>">
                                        <?php echo $row1['firstname']; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="duty_day">
                                <strong>Day Schedule</strong>
                            </label>
                            <select class="form-control" id="duty_day" name="duty_day" required>
                                <option value="Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday">Monday -
                                    Sunday</option>
                                <option value="Monday, Wednesday, Friday">Monday, Wednesday, Friday</option>
                                <option value=" Tuesday, Thursday"> Tuesday, Thursday</option>
                                <option value="Saturday, Sunday">Saturday, Sunday</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Select Time Start</label>
                            <div class="input-group">
                                <input type="time" id="duty_start_time" name="duty_start_time" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Select Time End</label>
                            <div class="input-group">
                                <input type="time" id="duty_end_time" name="duty_end_time" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p>All the User Account are From this location
                                <?php echo $location_row['location']; ?>
                            </p>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="location_id" class="form-control"
                                value="<?php echo $location_row['location_id']; ?>" name="location_id" required>
                            <button type="submit" name="duty_edit" class="btn btn-success">Submit</button>
                            <a class="small-link" href="../duty.php?location_id=<?php echo $location_row['location_id']; ?>">Back</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php } ?>

    <!--code Edit Service-->
    <?php
    //Edit_service.php
    if (isset($_POST['duty_edit'])) {
        $user_id = $_POST['user_id'];
        $user = $_POST['user'];
        $duty_day = $_POST['duty_day'];
        $duty_start_time = $_POST['duty_start_time'];
        $duty_end_time = $_POST['duty_end_time'];
        $location_id = $_POST['location_id'];

        $duty_query = "INSERT INTO `duty`(`user_id`, `duty_day`, `duty_start_time`, `duty_end_time`, `location_id`) 
        VALUES ('$user','$duty_day','$duty_start_time','$duty_end_time','$location_id')";

        $duty_result = mysqli_query($conn, $duty_query);

        if ($duty_result) {
            $_SESSION['success'] = "Successfully updated";
            // Add activity log
            seviceActivity_admin("Add Duty", "Add the Duty of User ID $user", $user_id, $conn);
            echo "<script>window.location.href='../duty.php'</script>";
        } else {
            $_SESSION['failed'] = "Failed to update duty";
            echo "<script>window.location.href='../duty.php'</script>";
        }
    }

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
    } ?>

    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
        src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
        </script>
    <script type="text/javascript"
        src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
        </script>
    <script type="text/javascript">
        // Get current date
        var currentDate = new Date();

        // Set working hours
        var workingHoursStart = 9; // 9 AM
        var workingHoursEnd = 17; // 5 PM

        // Set minimum and maximum time for duty start time
        var dutyStartTimeInput = document.getElementById('duty_start_time');
        dutyStartTimeInput.min = formatTime(workingHoursStart, 0);
        dutyStartTimeInput.max = formatTime(workingHoursEnd - 1, 59);

        // Set minimum and maximum time for duty end time
        var dutyEndTimeInput = document.getElementById('duty_end_time');
        dutyEndTimeInput.min = formatTime(workingHoursStart, 0);
        dutyEndTimeInput.max = formatTime(workingHoursEnd - 1, 59);

        // Function to format time
        function formatTime(hours, minutes) {
            return (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;
        }
    </script>
</body>

</html>