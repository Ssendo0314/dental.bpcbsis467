<?php include ('./function/alert.php');

//update Password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password_change'])) {
    //try {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    //$currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    //$confirmPassword = $_POST['confirmPassword'];

    // Sanitize inputs and escape SQL injection
    $user_id = $conn->real_escape_string($user_id);

    // Query to fetch user's current password from the database
    $sql = "UPDATE `users` SET `password`='$newPassword' WHERE `user_id`='$user_id'";
    mysqli_query($conn, $sql);

    if ($result) {
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Update Information - Admin</title>

    <link href="../../css/styles.css" rel="stylesheet" />
    <!--Links -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        h1 {
            text-align: center;
        }

        input {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            font-family: Raleway;
            border: 1px solid #aaaaaa;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        button {
            background-color: #04AA6D;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        #prevBtn {
            background-color: #bbbbbb;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #04AA6D;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <!--Datebase-->
    <?php include ('../../dbcon.php'); ?>
    <?php
    //Profile show
    $list_query = "SELECT * FROM `users` WHERE user_id='$id'";
    $result = mysqli_query($conn, $list_query);
    while ($user_row = mysqli_fetch_array($result)) {
        ?>
        <!--DATABASE-->
        <input type="hidden" name="id" id="user_id" value="<?php echo $user_row['user_id']; ?>">
        <hr>
        <div class="container bootstrap snippet">
            <div class="row">
                <div class="col-sm-10">
                    <h1><i class='bx bx-add-to-queue'></i> Update Information</h1>
                </div>
                <!--Logo-->
                <div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class=" img-responsive"
                            src="../../picture/Dental_Logo_Dashboard.png"></a></div>
            </div>
            <div class="row">
                <div class="col-sm-3"><!--left col-->
                    <div class="text-center">
                        <!--Upload Images-->
                        <form class="form" action="./function/update.php" method="post" enctype="multipart/form-data">
                            <?php
                            if (!empty($user_row['image'])) { ?>
                                <img src="../../picture/profile/<?php echo $user_row['image']; ?>" alt="avatar"
                                    class="avatar img-circle img-thumbnail">
                                <h6>Upload a different photo...</h6>
                            <?php } else { ?>
                                <img src="../../picture/profile/human.png" alt="avatar" class="avatar img-circle img-thumbnail">
                                <h6>Upload a New Profile...</h6>
                            <?php } ?>
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_row['user_id']; ?>">
                            <label for="image">Select image to upload:</label>
                            <input type="file" name="image">
                            <br>
                            <input class="btn btn-success" type="submit" value="Upload Image" name="image_upload">
                            <br>
                        </form>
                    </div>
                    </hr><br>

                    <div class="panel panel-default">
                        <div class="panel-heading">Clinic<i class="fa fa-link fa-1x"></i></div>
                        <div class="panel-body"><a href="https://www.facebook.com/profile.php?id=100091879197852">Dr L B
                                de
                                Guzman Dental</a></div>
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item text-muted">action count<i class="fa fa-dashboard fa-1x"></i></li>
                        <?php
                        // SQL query to get distinct actions and their counts
                        $action_count_sql = "SELECT action, COUNT(*) AS log_count FROM activity_logs WHERE user_id = $id GROUP BY action";
                        $action_count_result = $conn->query($action_count_sql);

                        // Process the data
                        $action_counts = array();
                        if ($action_count_result && $action_count_result->num_rows > 0) {
                            while ($row = $action_count_result->fetch_assoc()) {
                                $action_counts[$row['action']] = $row['log_count'];
                            }
                        }
                        ?>
                        <?php foreach ($action_counts as $action => $count): ?>
                            <?php if ($action !== 'Update Active' && $action !== 'Update Deactive'): ?>
                                <li class="list-group-item text-right">
                                    <span class="pull-left"><strong>
                                            <?php echo $action ?>
                                        </strong></span>
                                    <?php echo $count ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>

                </div><!--/col-3-->
                <div class="col-sm-9">
                    <br>
                    <?php if (isset($_SESSION['success'])) { ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                onclick="window.location.href ='./update_profile.php?user_id=<?php echo $user_row['user_id']; ?>'"><span
                                    aria-hidden="true"><i class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['success']; ?>
                        </div>
                        <?php
                        unset($_SESSION['success']);
                    } ?>
                    <!--space-->
                    <?php if (isset($_SESSION['failed'])) { ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                onclick="window.location.href ='./update_profile.php?user_id=<?php echo $user_row['user_id']; ?>'"><span
                                    aria-hidden="true"><i class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['failed']; ?>
                        </div>
                        <?php
                        unset($_SESSION['failed']);
                    } ?>
                    <?php if (isset($_SESSION['message'])) { ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                onclick="window.location.href ='./update_profile.php?user_id=<?php echo $user_row['user_id']; ?>'"><span
                                    aria-hidden="true"><i class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['message']; ?>
                        </div>
                        <?php
                        unset($_SESSION['message']);
                    } ?>
                    <br>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <hr>
                            <form class="form" action="./function/update.php" method="post">
                                <input type="hidden" class="form-control" name="user_id" id="user_id"
                                    value="<?php echo $user_row['user_id']; ?>">
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label class="control-label" for="firstname">
                                            <h4>First Name</h4>
                                        </label>
                                        <input type="text" class="form-control" name="firstname" id="firstname"
                                            value="<?php echo $user_row['firstname']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label class="control-label" for="middlename">
                                            <h4>Middle Name</h4>
                                        </label>
                                        <input type="text" class="form-control" name="middlename" id="middlename"
                                            value="<?php echo $user_row['middlename']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label class="control-label" for="lastname">
                                            <h4>Last Name</h4>
                                        </label>
                                        <input type="text" class="form-control" name="lastname" id="lastname"
                                            value="<?php echo $user_row['lastname']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label class="control-label" for="address">
                                            <h4>Address</h4>
                                        </label>
                                        <input type="text" class="form-control" name="address" id="address"
                                            value="<?php echo $user_row['address']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label class="control-label" for="email">
                                            <h4>Email</h4>
                                        </label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="<?php echo $user_row['email']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label class="control-label" for="contact_no">
                                            <h4>Contact Number</h4>
                                        </label>
                                        <input type="text" class="form-control" name="contact_no" id="contact_no"
                                            value="<?php echo $user_row['contact_no']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label class="control-label" for="age">
                                            <h4>Age</h4>
                                        </label>
                                        <input type="text" class="form-control" name="age" id="age"
                                            value="<?php echo $user_row['age']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label class="control-label" for="birthday">
                                            <h4>Birthday</h4>
                                        </label>
                                        <input type="text" class="form-control" name="birthday" id="birthday"
                                            value="<?php echo $user_row['birthday']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label class="control-label" for="gender">
                                            <h4>Gender</h4>
                                        </label>
                                        <input type="text" class="form-control" name="gender" id="gender"
                                            value="<?php echo $user_row['gender']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label class="control-label" for="bio">
                                            <h4>Bio</h4>
                                        </label>
                                        <?php if (!empty($user_row['bio'])) { ?>
                                            <textarea class="form-control" name="bio" id="bio" placeholder="500 characters only"
                                                value="<?php echo $user_row['bio']; ?>" maxlength="500"></textarea>
                                        <?php } else { ?>
                                            <textarea class="form-control" name="bio" id="bio" placeholder="500 characters only"
                                                maxlength="500"></textarea>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <br>
                                        <button class="btn btn-success" type="submit" name="basicinformation"><i
                                                class="glyphicon glyphicon-ok-sign"></i> Submit</button>
                                        <br><br>
                                    </div>
                                </div>
                            </form>
                            <div>
                                <div>
                                    <h3><strong>Social Media</strong></h3>
                                    <form class="form" action="./function/update.php" method="post">
                                        <input type="hidden" class="form-control" name="user_id" id="user_id"
                                            value="<?php echo $user_row['user_id']; ?>">
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label for="website_name">Website Name:</label>
                                                <input type="text" class="form-control" id="website_name"
                                                    name="website_name" placeholder="Enter Website Name"
                                                    value="<?php echo $user_row['website_name']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label for="website">Website:</label>
                                                <input type="text" class="form-control" id="website" name="website"
                                                    placeholder="Enter Website URL"
                                                    value="<?php echo $user_row['website']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label for="facebook">Facebook:</label>
                                                <input type="text" class="form-control" id="facebook" name="facebook"
                                                    placeholder="Enter Facebook URL"
                                                    value="<?php echo $user_row['facebook']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <br>
                                                <button type="submit" class="btn btn-success"
                                                    name="update_social">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <h3><strong>Change Password</strong></h3>
                                    </div>
                                </div>
                                <!-- One "tab" for each step in the form: -->
                                <div class="tab">
                                    <form class="form" action="./function/update.php" method="post" accept-charset="UTF-8">
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input type="hidden" name="user_id" id="user_id"
                                                    value="<?php echo $user_row['user_id']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label class="control-label" for="currentPassword">
                                                    <h4>Current Password</h4>
                                                </label>
                                                <?php if (isset($_SESSION['success_user'])) { ?>
                                                    <input type="text" class="form-control" name="currentPassword"
                                                        id="currentPassword" value="<?php echo $user_row['password']; ?>"
                                                        disabled>
                                                    <p class="text-success">
                                                        <?php echo $_SESSION['success_user']; ?>
                                                        <a type="button" id="nextBtn" class="link" onclick="nextPrev(1)">Please
                                                            press continue</a>
                                                    </p>
                                                    <?php unset($_SESSION['success_user']); ?>
                                                <?php } else { ?>
                                                    <input type="text" class="form-control" name="currentPassword"
                                                        id="currentPassword" placeholder="Enter your current password">
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <br>
                                                <button class="btn btn-success" type="submit" name="password_update_check">
                                                    Next</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab">
                                    <form class="form" action="#" method="post" accept-charset="UTF-8">
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input type="hidden" name="user_id" id="user_id"
                                                    value="<?php echo $user_row['user_id']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label class="control-label" for="newPassword">
                                                    <h4>New Password</h4>
                                                </label>
                                                <input type="text" class="form-control" name="newPassword" id="newPassword"
                                                    placeholder="Enter your new password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <br>
                                                <button class="btn btn-success" type="submit" name="password_change"><i
                                                        class="glyphicon glyphicon-ok-sign"></i>
                                                    Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                    <span class="step"></span>
                                    <span class="step"></span>
                                </div>
                                <a class="btn btn-lg"
                                    href="./profile.php?user_id=<?php echo $user_row['user_id']; ?>">Back</a>
                                <hr>
                            </div>
                        </div><!--/tab-pane-->
                    </div><!--/tab-content-->

                </div><!--/col-9-->
            </div><!--/row-->
        </div>
    <?php } ?>
    <br>
    <?php include ('./function/footer.php'); ?>
    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n === 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n === x.length - 1) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n);
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n === 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab += n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value.trim() === "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }

    </script>
</body>

</html>