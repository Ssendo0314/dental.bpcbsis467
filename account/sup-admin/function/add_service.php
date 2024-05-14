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
if (isset ($_SESSION['id'])) {
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
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="user_id" class="form-control" value="<?php echo $row['user_id']; ?>" name="user_id"
                required>
            <input type="hidden" name="service_id" id="service_id" value="<?= $edit_row['service_id'] ?>">
            <h3>Add Service</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="service_offer">
                            <strong>Service Offer</strong>
                        </label>
                        <input type="text" id="service_offer" placeholder="Please input your Service Offer"
                            class="form-control" name="service_offer" required>
                    </div>
                    <div class="form-group">
                        <label for="description">
                            <strong>Description</strong>
                        </label>
                        <textarea id="description" class="form-control" name="description"
                            placeholder="Please input your description. 500 words only" required
                            maxlength="500"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="original_price">
                            <strong>Original Price</strong>
                        </label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₱</span>
                            </div>
                            <input type="text" id="original_price" class="form-control" name="original_price" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="owner_fee">
                            <strong>Owner's Fee</strong>
                        </label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₱</span>
                            </div>
                            <input type="text" id="owner_fee" class="form-control" name="owner_fee" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price">
                            <strong>Total Price</strong>
                        </label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₱</span>
                            </div>
                            <input type="text" id="price" class="form-control" name="price" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <p>The following <strong>Requirements</strong> are:</p>
                        <br>
                        <div class="form-group">
                            <label for="x_ray">
                                <strong>Dental Examination:</strong> X-rays
                            </label>
                            <select id="x_ray" name="x_ray" class="form-control">
                                <option value="yes">yes</option>
                                <option value="no">no</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="imaging_tests">
                                <strong>Dental Examination:</strong> imaging tests
                            </label>
                            <select id="imaging_tests" name="imaging_tests" class="form-control">
                                <option value="yes">yes</option>
                                <option value="no">no</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="consent">
                                <strong>Consent</strong>
                            </label>
                            <select id="consent" name="consent" class="form-control">
                                <option value="yes">yes</option>
                                <option value="no">no</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="status" value="Available" name="status" required>
                    <input type="hidden" id="highlight" value="yes" name="highlight" required>
                    <input type="hidden" id="user_id" value="<?php echo $row['user_id']; ?>" name="user_id" required>
                    <div class="form-group">
                        <button type="submit" name="service_add" class="btn btn-success">Submit</button>
                    </div>
                    <div class="form-group">
                        <a class="small-link" href="../service.php">Back</a>
                    </div>
                    <hr>
                </div>
            </div>
        </form>
    </div>


    <?php
    //add_service.php
    if (isset($_POST['service_add'])) {
        $user_id = $_POST['user_id'];
        $service_id = $_POST['service_id'];
        $service_offer = $_POST['service_offer'];
        $description = $_POST['description'];
        $original_price = $_POST['original_price'];
        $owner_fee = $_POST['owner_fee'];
        $x_ray = $_POST['x_ray'];
        $imaging_tests = $_POST['imaging_tests'];
        $consent = $_POST['consent'];
        $status = $_POST['status'];
        $highlight = $_POST['highlight'];

        // Calculate total price
        $price = $original_price + $owner_fee;

        // Fetch all existing location_id values from the location table
        $location_query = "SELECT location_id FROM `location`";
        $location_result = mysqli_query($conn, $location_query);
        $location_ids = [];
        while ($row = mysqli_fetch_assoc($location_result)) {
            $location_ids[] = $row['location_id'];
        }

        // Assuming you want to use the first location_id obtained from the query
        // Modify this logic as per your requirements
        $location_id = isset($location_ids[0]) ? $location_ids[0] : ''; 

        // Perform your insertion with $location_id
        $service_query = "INSERT INTO `service` ( `service_offer`, `description`, `original_price`, `owner_fee`, `price`, `x_ray`, `imaging_tests`, `consent`, `status`, `highlight`, `location_id`) 
        VALUES ( '$service_offer', '$description', '$original_price', '$owner_fee', '$price', '$x_ray', '$imaging_tests', '$consent', '$status', '$highlight', '$location_id')";
        $service_result = mysqli_query($conn, $service_query);

        // For displaying success or failure messages
        if ($service_result) {
            $_SESSION['success'] = "Successfully added";
            echo "<script>window.location.href='../service.php'</script>";
            // For activity log
            $action = "Added New Service by Owner";
            $log_message = "Added service: $service_offer";
            // Assuming $conn is your database connection, adjust this query according to your database structure
            $activity_query = "INSERT INTO `activity_logs` (`action`,`description`,`user_id`, `timestamp`) VALUES ('$action','$log_message','$user_id', NOW())";
            mysqli_query($conn, $activity_query);
        } else {
            $_SESSION['failed'] = "Fail to Add Service";
            echo "<script>window.location.href='../service.php'</script>";
        }

        // Close connection
        mysqli_close($conn);
    }    
?>



    <script>
        // Get the elements
        var originalPriceInput = document.getElementById('original_price');
        var ownerFeeInput = document.getElementById('owner_fee');
        var totalPriceInput = document.getElementById('price');

        // Function to calculate and update the total price
        function updateTotalPrice() {
            var originalPrice = parseFloat(originalPriceInput.value.replace(/,/g, ''));
            var ownerFee = parseFloat(ownerFeeInput.value.replace(/,/g, ''));
            var totalPrice = originalPrice + ownerFee;
            totalPriceInput.value = totalPrice.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Format with commas
        }

        // Listen for changes in original price and owner fee inputs
        originalPriceInput.addEventListener('input', updateTotalPrice);
        ownerFeeInput.addEventListener('input', updateTotalPrice);

        // Initial call to update total price
        updateTotalPrice();
    </script>
</body>

</html>