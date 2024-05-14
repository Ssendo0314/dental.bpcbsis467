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
if (isset($_SESSION['super_id'])) {
    $id = $_SESSION['super_id'];

    $result = mysqli_query($conn, "Select * from `users` where `user_id`='$id'");
    $row = mysqli_fetch_array($result);
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Add New Service -Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
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
        <form method="post" enctype="multipart/form-data">
            <input type="text" id="user_id" class="form-control" value="<?php echo $row['user_id']; ?>" name="user_id"
                required>
            <!-- <input type="hidden" name="testimony_id" id="testimony_id" value="<?= $edit_row['testimony_id'] ?>"> -->
            <h3>Add Testimony</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="firstname"><strong>First Name</strong></label>
                        <input type="text" class="form-control" id="firstname" placeholder="First Name" name="firstname"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="lastname"><strong>Last Name</strong></label>
                        <input type="text" class="form-control" id="lastname" placeholder="Your Service Offer"
                            name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="testimony"><strong>Testimony</strong></label>
                        <textarea id="testimony" class="form-control" name="testimony"
                            placeholder="Testimony max length is 400 characters" maxlength="400" required></textarea>
                        <small id="testimonyHelp" class="form-text text-muted">You have <span
                                id="remainingCharacters">400</span> characters remaining.</small>
                    </div>
                    <div class="form-group">
                        <!-- Select Location -->
                        <label class="control-label">Select Location</label>
                        <select id="location_id" name="location_id" class="form-select">
                            <?php
                            // Fetch locations from the database
                            $query = mysqli_query($conn, "SELECT * FROM location") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_array($query)) {
                                ?>
                                <option value="<?php echo $row['location_id']; ?>"><?php echo $row['location']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="star">Review Star</label>
                        <select class="form-control" id="star" name="star" placeholder="Select Star" required>
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="media"><strong>Social Media</strong></label>
                        <select class="form-control" id="media" name="media" placeholder="Select Social Media" required>
                            <option value="Facebook">Facebook</option>
                            <option value="Twitter">Twitter</option>
                            <option value="Instagram">Instagram</option>
                            <option value="LinkedIn">LinkedIn</option>
                            <option value="YouTube">YouTube</option>
                            <option value="System">System</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" name="testimony_add" class="btn btn-success">Submit</button>
                        <a class="btn" href="../testimony.php">Back</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
    // Function to log activities
    function testimony_logActivity_admin($action, $description, $user_id, $conn)
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
            //echo "Activity logged successfully";
        } else {
            //echo "Error logging activity: " . $conn->error;
        }
    }

    // Usage:
    if (isset($_POST['testimony_add'])) {
        $user_id = $_POST['user_id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $testimony = $_POST['testimony'];
        $location_id = $_POST['location_id'];
        $star = $_POST['star'];
        $media = $_POST['media'];

        // Establish database connection ($conn assumed to be available)
    
        // Log the beginning of the activity
        testimony_logActivity_admin("Adding testimony", "Adding testimony for $firstname $lastname with location ID $location_id", $user_id, $conn);

        $testimony_query = "INSERT INTO `testimony`(`firstname`, `lastname`, `testimony`, `location_id`, `star`, `media`) 
        VALUES ('$firstname','$lastname','$testimony','$location_id','$star','$media')";
        $testimony_result = mysqli_query($conn, $testimony_query);

        // Log the result of the query
        if ($testimony_result) {
            // Log success message
            testimony_logActivity_admin("Testimony added", "Testimony successfully added for $firstname $lastname", $user_id, $conn);
            $_SESSION['success'] = "Successfully added";
            echo "<script>window.location.href='../testimony.php'</script>";
        } else {
            // Log failure message
            testimony_logActivity_admin("Failed to add testimony", "Failed to add testimony for $firstname $lastname", $user_id, $conn);
            $_SESSION['failed'] = "Fail to Add Service";
            echo "<script>window.location.href='../testimony.php'</script>";
        }
    }

    ?>

    <script>
        // Update remaining characters count as the user types
        document.getElementById("testimony").addEventListener("input", function () {
            var maxLength = 400;
            var currentLength = this.value.length;
            var remaining = maxLength - currentLength;
            document.getElementById("remainingCharacters").innerText = remaining;
        });
    </script>

</body>

</html>