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
    <title>Edit Sevrice - Admin </title>

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
    $id = $_GET['service_id'];
    $query = "SELECT * FROM `service` WHERE service_id='$id'";
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
            <input type="hidden" name="service_id" id="service_id" value="<?= $edit_row['service_id'] ?>">
            <h3>Add Service</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="service_offer">
                            <strong>Service Offer</strong>
                        </label>
                        <input type="text" id="service_offer" class="form-control"
                            value="<?php echo $edit_row['service_offer']; ?>" name="service_offer" required>
                    </div>
                    <div class="form-group">
                        <label for="description">
                            <strong>Description</strong>
                        </label>
                        <textarea id="description" class="form-control" name="description"
                            placeholder="Please input your description. 500 words only" required
                            maxlength="500"><?php echo $edit_row['description']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="original_price">
                            <strong>Original Price</strong>
                        </label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₱</span>
                            </div>
                            <input type="text" id="original_price" class="form-control"
                                value="<?php echo number_format($edit_row['original_price'], 2); ?>"
                                name="original_price" required>
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
                            <input type="text" id="owner_fee" class="form-control"
                                value="<?php echo number_format($edit_row['owner_fee'], 2); ?>" name="owner_fee"
                                required>
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
                            <input type="text" id="price" class="form-control"
                                value="<?php echo number_format($edit_row['price'], 2); ?>" name="price" disabled>
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
                    <div class="form-group">
                        <label for="status">
                            <strong>Status</strong>
                        </label>
                        <select name="status" id="status" class="form-control">
                            <option value="Available">Available</option>
                            <option value="Not Available">Not Available</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="highlight">
                            <strong>Highlight in Home Page</strong>
                        </label>
                        <select name="highlight" id="highlight" class="form-control">
                            <option value="yes">yes</option>
                            <option value="no">no</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="service_edit" class="btn btn-success">Submit</button>
                    </div>
                    <div class="form-group">
                        <a class="small-link" href="../service.php">Back</a>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="my_highlight">Your <strong>highlight</strong> is
                            <?php if ($edit_row['highlight'] == "yes") { ?>
                                <span class="btn btn-success">yes</span>
                            <?php } else { ?>
                                <span class="btn btn-danger">no</span>
                            <?php } ?>
                        </label>
                        <label for="my_status">Your Service <strong>Status</strong> is
                            <?php if ($edit_row['status'] == "Available") { ?>
                                <span class="btn btn-success">Available</span>
                            <?php } else { ?>
                                <span class="btn btn-danger">Not Available</span>
                            <?php } ?>
                        </label>
                        <label for="my_x_ray">Do you need <strong>x_ray</strong>
                            <?php if ($edit_row['x_ray'] == "yes") { ?>
                                <span class="btn btn-success">yes</span>
                            <?php } else { ?>
                                <span class="btn btn-danger">no</span>
                            <?php } ?>
                        </label>
                        <label for="my_imaging_tests">Do you need <strong>Imaging Tests</strong>
                            <?php if ($edit_row['imaging_tests'] == "yes") { ?>
                                <span class="btn btn-success">yes</span>
                            <?php } else { ?>
                                <span class="btn btn-danger">no</span>
                            <?php } ?>
                        </label>
                        <label for="my_consent">Do you need <strong>Consent</strong>
                            <?php if ($edit_row['consent'] == "yes") { ?>
                                <span class="btn btn-success">yes</span>
                            <?php } else { ?>
                                <span class="btn btn-danger">no</span>
                            <?php } ?>
                        </label>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--code Edit Service-->
    <?php
    //Edit_service.php
    if (isset ($_POST['service_edit'])) {
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

        //Query
        $service_query = "UPDATE `service` SET `service_offer`= '$service_offer', `description` = '$description',
        `original_price`='$original_price',`owner_fee`='$owner_fee', `price`= '$price', 
        `x_ray` = '$x_ray', `imaging_tests` = '$imaging_tests', `consent` = '$consent', `status`= '$status', `highlight`= '$highlight' WHERE `service_id`= '$service_id'";
        //connection
        $service_result = mysqli_query($conn, $service_query);
        //For successfully Edit message
        if ($service_result) {
            $_SESSION['success'] = "Successfully Updated The Service";
            // Add activity log
            seviceActivity_admin("Updated Service", "Updated Service ID $id to $highlight by Owner", $user_id, $conn);
            // Redirect back
            echo "<script>window.location.href='../service.php'</script>";
        } else {
            $_SESSION['failed'] = "Fail to to Updated The Service";
            echo "<script>window.location.href='../service.php'</script>";
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