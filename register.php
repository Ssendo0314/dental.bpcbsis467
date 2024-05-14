<?php
//Adding Account
session_start();
include ('./dbcon.php');

if (isset($_POST['submit'])) {
    // Retrieve form data for the main user
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $suffixname = $_POST['suffixname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $job = $_POST['job'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $status = $_POST['status'];

    // Retrieve guardian form data
    $guardian_firstname = $_POST['guardianfirstname'];
    $guardian_middlename = $_POST['guardianmiddlename'];
    $guardian_lastname = $_POST['guardianlastname'];
    $guardian_contact_no = $_POST['guardian_contact_no'];
    $guardian_job = $_POST['guardian_job'];

    // Validate if all fields are filled
    if (empty($firstname) || empty($lastname) || empty($address) || empty($email) || empty($contact_no) || empty($birthday) || empty($age) || empty($gender) || empty($job) || empty($username)) {
        $a = "All fields are required.";
    } elseif ($cpassword != $password) {
        $a = "Password does not match confirm password.";
    } else {
        // Query to check if a record with the given username exists
        $sql = "SELECT * FROM members WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Record with the given username exists
            $existing_record = $result->fetch_assoc();

            // Perform comparison with existing record
            if ($existing_record['password'] == $password) {
                // Password matches existing record
                $a = "Password matches an existing record.";
            } else {
                // Password does not match existing record
                $a = "Password does not match an existing record.";
            }
        } else {
            // No existing record found with the given username
            $a = "";
        }
    }

    // Close prepared statement and database connection
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fill in this form to create an account">
    <meta name="author" content="Your Name">
    <title>DENTAL CARE || Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-image: url('./picture/account-bk.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .guardian-info {
            display: none;
        }
    </style>
</head>

<body>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <br>
                    <div class="card">
                        <!-- Header -->
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Create Account</h3>
                            <p class="text-center">Please fill in this form to create an account.</p>
                        </div>
                        <form method="post">
                            <div class="card-body">
                                <!-- Name -->
                                <div class="row">
                                    <!-- First Name -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname">First Name:</label>
                                            <input class="form-control" type="text" name="firstname" id="firstname"
                                                placeholder="e.g., John" required>
                                        </div>
                                    </div>
                                    <!-- Middle Name -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="middlename">Middle Name:</label>
                                            <input class="form-control" type="text" name="middlename" id="middlename"
                                                placeholder="e.g., Doe" required>
                                        </div>
                                    </div>
                                    <!-- Last Name -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname">Last Name:</label>
                                            <input class="form-control" type="text" name="lastname" id="lastname"
                                                placeholder="e.g., Smith" required>
                                        </div>
                                    </div>
                                    <!-- Suffix Name -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="suffixname">Suffix Name:</label>
                                            <input class="form-control" type="text" name="suffixname" id="suffixname"
                                                placeholder="e.g., Jr.">
                                        </div>
                                    </div>
                                </div>
                                <!-- Personal Information -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label" for="address">Address</label>
                                        <input class="form-control" type="text" name="address" id="address"
                                            placeholder="e.g., 123 Main St, City, Country" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="email">Email:</label>
                                            <input class="form-control" type="email" name="email" id="email"
                                                placeholder="e.g., example@example.com" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="contact_no">Contact Number:</label>
                                            <input class="form-control" type="tel" name="contact_no" id="contact_no"
                                                placeholder="e.g., +1234567890" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="birthday">Birthday:</label>
                                            <input class="form-control" type="date" name="birthday" id="birthday"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="age">Age:</label>
                                            <input class="form-control" name="age" id="age" type="number"
                                                placeholder="Age" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="gender">Gender:</label>
                                            <select class="form-control" name="gender" id="gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="job">Job:</label>
                                            <input class="form-control" type="text" name="job" id="job"
                                                placeholder="e.g., Software Developer">
                                        </div>
                                    </div>
                                </div>
                                <!-- Guardian Information (Initially Hidden) -->
                                <div class="guardian-info">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardianfirstname">Guardian First Name:</label>
                                                <input class="form-control" type="text" name="guardianfirstname"
                                                    id="guardianfirstname" placeholder="Enter Guardian's First Name">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardianmiddlename">Guardian Middle Name:</label>
                                                <input class="form-control" type="text" name="guardianmiddlename"
                                                    id="guardianmiddlename" placeholder="Enter Guardian's Middle Name">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardianlastname">Guardian Last Name:</label>
                                                <input class="form-control" type="text" name="guardianlastname"
                                                    id="guardianlastname" placeholder="Enter Guardian's Last Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="guardian_contact_no">Guardian Contact Number:</label>
                                                <input class="form-control" type="tel" name="guardian_contact_no"
                                                    id="guardian_contact_no"
                                                    placeholder="Enter Guardian's Contact Number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="guardian_job">Guardian Job:</label>
                                                <input class="form-control" type="text" name="guardian_job"
                                                    id="guardian_job" placeholder="Enter Guardian's Job">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Username -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Username -->
                                        <div class="form-group">
                                            <label for="username">Username:</label>
                                            <input class="form-control" type="text" name="username" id="username"
                                                placeholder="Enter your username" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Password -->
                                        <div class="form-group">
                                            <label for="password">Password:</label>
                                            <input class="form-control" type="password" name="password" id="password"
                                                value="<?php if (isset($_POST['submit'])) {
                                                    echo $password;
                                                } ?>" placeholder="Enter your password" required>
                                        </div>
                                    </div>
                                    <!--Account Status-->
                                    <input type="hidden" name="status" id="status" value="active" value="<?php if (isset($_POST['submit'])) {
                                        echo $status;
                                    } ?>">
                                    <br>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="inputEmail"></label>
                                            <div class="controls">
                                                <script type="text/javascript">
                                                    jQuery(document).ready(function () {
                                                        $('#refresh').tooltip('show');
                                                        $('#refresh').tooltip('hide');
                                                    })
                                                </script>
                                                <img src="./generatecaptcha.php?rand=<?php echo rand(); ?>"
                                                    id='captchaimg'>
                                                <a href='javascript: refreshCaptcha();'><i data-placement="right"
                                                        id="refresh" title="Click to Refresh Code"
                                                        class="icon-refresh icon-large icon-spin"></i></a>
                                                <script language='JavaScript' type='text/javascript'>
                                                    function refreshCaptcha() {
                                                        var img = document.images['captchaimg'];
                                                        img.src = img.src.substring(0, img.src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;
                                                    }
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="inputPassword">Enter the Code
                                            Above</label>
                                        <input class="form-control" id="code" name="code" type="text"
                                            placeholder="Enter the Code Above" required></td>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="control-label" for="inputPassword">Confirm Password</label>
                                        <input class="form-control" type="password" name="cpassword" value="<?php if (isset($_POST['submit'])) {
                                            echo $cpassword;
                                        } ?>" placeholder="Confirm Password" required>
                                        <?php if (isset($_POST['submit'])) { ?> <span class="label label-important">
                                                <?php echo $a; ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <br>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid"><input type="submit" class="btn btn-primary btn-block"
                                            value="submit" name="submit"></div>
                                    <p>By creating an account you agree to our <a href="./terms.php"
                                            target="_blank">Terms &amp; Conditions</a> and <a href="./privacy.php"
                                            target="_blank">Privacy Policy</a>.
                                    </p>
                                </div>
                            </div>
                        </form>

                        <?php
                        if (isset($_POST['submit'])) {
                            // Retrieve form data for the main user
                            $firstname = $_POST['firstname'];
                            $middlename = $_POST['middlename'];
                            $lastname = $_POST['lastname'];
                            $suffixname = $_POST['suffixname'];
                            $address = $_POST['address'];
                            $email = $_POST['email'];
                            $contact_no = $_POST['contact_no'];
                            $birthday = $_POST['birthday'];
                            $age = $_POST['age'];
                            $gender = $_POST['gender'];
                            $job = $_POST['job'];
                            $username = $_POST['username'];
                            $password = $_POST['password'];
                            $cpassword = $_POST['cpassword'];
                            $status = $_POST['status'];

                            // Retrieve guardian form data
                            $guardian_firstname = $_POST['guardianfirstname'];
                            $guardian_middlename = $_POST['guardianmiddlename'];
                            $guardian_lastname = $_POST['guardianlastname'];
                            $guardian_contact_no = $_POST['guardian_contact_no'];
                            $guardian_job = $_POST['guardian_job'];

                            // Check if the session code matches the submitted code
                            if ($_SESSION['code'] !== $_POST['code']) {
                                ?>
                                <span class="label label-important">Code Does Not Match</span>
                                <?php
                            } elseif ($_SESSION['code'] === $_POST['code'] && $password === $cpassword) {
                                // Insert data into the database
                                mysqli_query($conn, "INSERT INTO `members`(`firstname`, `lastname`, `middlename`, `suffixname`, `address`, `email`, `contact_no`, `age`, `birthday`, `gender`, `job`, `guardianfirstname`, `guardianmiddlename`, `guardianlastname`, `guardian_contact_no`, `guardian_job`, `minor`, `bio`, `image`, `role`, `username`, `password`, `verification_code`, `facebook`, `website_name`, `website`, `status`, `question_id`)
                                VALUES ('$firstname','$lastname','$middlename','$suffixname','$address','$email','$contact_no','$age','$birthday','$gender','$job','$guardian_firstname','$guardian_middlename','$guardian_lastname','$guardian_contact_no','$guardian_job','','$bio','','$role','$username','$password','','$facebook','$website_name','$website','$status','')") or die(mysqli_error($conn)); ?>

                                <script type="text/javascript">
                                    window.location = './login.php';
                                </script>
                                <?php
                            } else {
                                echo "Passwords do not match.";
                            }
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#birthday').change(function () {
                var dob = new Date($(this).val());
                var today = new Date();
                var age = today.getFullYear() - dob.getFullYear();
                var m = today.getMonth() - dob.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                $('#age').val(age);

                if (age < 6) {
                    alert("You must be at least 6 years old to register.");
                    $(this).val(""); // Clear the birthday input
                } else if (age >= 6 && age < 18) {
                    $('.guardian-info').show();
                    $('#minor').val('yes');
                    alert("You are a minor. Please provide guardian information.");
                } else {
                    $('.guardian-info').hide();
                    $('#minor').val('no');
                }
            });
            $('#age').prop('readonly', true); // Set age field as readonly initially
        });
    </script>
</body>

</html>