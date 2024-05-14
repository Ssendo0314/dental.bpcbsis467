<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Service -Admin</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/mystyle.css">
    <link rel="stylesheet" type="text/css" href="./css/table_design.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <style>
        /* CSS */
        .modal-dialog {
            max-width: 800px;
            width: 80%;
            margin: auto;
        }

        /* Added CSS for dividing into two columns */
        .modal-body {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .modal-body>div {
            flex: 1;
        }
    </style>
</head>

<body>
    <!-- The form -->
    <div class="modal" id="popupForm">
        <div class="modal-dialog">
            <form class="formContainer" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Please Add New Account</h4>
                        <button type="button" class="close" onclick="closeForm()">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div>
                            <label for="firstname">
                                <strong>First Name</strong>
                            </label>
                            <input type="text" class="form-control" id="firstname" placeholder="First Name"
                                name="firstname" required>

                            <label for="lastname">
                                <strong>Last Name</strong>
                            </label>
                            <input type="text" class="form-control" id="lastname" placeholder="Last Name"
                                name="lastname" required>

                            <label for="middlename">
                                <strong>Middle Name</strong>
                            </label>
                            <input type="text" class="form-control" id="middlename" placeholder="Middle Name"
                                name="middlename">

                            <label for="suffixname">
                                <strong>Suffix Name</strong>
                            </label>
                            <select class="form-control" id="suffixname" name="suffixname">
                                <option value="">None</option>
                                <option value="Jr.">Jr.</option>
                                <option value="Sr.">Sr.</option>
                                <option value="II">II (the second)</option>
                                <option value="III">III (the third)</option>
                                <option value="IV">IV (the fourth)</option>
                            </select>

                            <label for="address">
                                <strong>Address</strong>
                            </label>
                            <input type="text" class="form-control" id="address" placeholder="Address" name="address"
                                required>

                            <label for="email">
                                <strong>Email</strong>
                            </label>
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email"
                                required>

                            <label for="contact_no">
                                <strong>Contact Number</strong>
                            </label>
                            <input type="text" class="form-control" id="contact_no" placeholder="Contact Number"
                                name="contact_no" required>

                            <label for="birthday">
                                <strong>Birthday</strong>
                            </label>
                            <input type="date" class="form-control" id="birthday" name="birthday"
                                onchange="calculateAge()" required max="<?php echo date('Y-m-d'); ?>">

                            <label for="age">
                                <strong>Age</strong>
                            </label>
                            <input type="number" class="form-control" id="age" placeholder="Age" name="age">

                            <label for="gender">
                                <strong>Gender</strong>
                            </label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>

                            <div id="guardian_section" style="display: none;">
                                <label for="guardianfirstname">
                                    <strong>Guardian's First Name</strong>
                                </label>
                                <input type="text" class="form-control" id="guardianfirstname"
                                    placeholder="Guardian's First Name" name="guardianfirstname">

                                <label for="guardianmiddlename">
                                    <strong>Guardian's Middle Name</strong>
                                </label>
                                <input type="text" class="form-control" id="guardianmiddlename"
                                    placeholder="Guardian's Middle Name" name="guardianmiddlename">

                                <label for="guardianlastname">
                                    <strong>Guardian's Last Name</strong>
                                </label>
                                <input type="text" class="form-control" id="guardianlastname"
                                    placeholder="Guardian's Last Name" name="guardianlastname">

                                <label for="guardian_contact_no">
                                    <strong>Guardian's Contact Number</strong>
                                </label>
                                <input type="text" class="form-control" id="guardian_contact_no"
                                    placeholder="Guardian's Contact Number" name="guardian_contact_no">

                                <label for="guardian_contact_job">
                                    <strong>Guardian's Contact Job</strong>
                                </label>
                                <input type="text" class="form-control" id="guardian_contact_job"
                                    placeholder="Guardian's Contact Job" name="guardian_contact_job">
                            </div>

                            <input type="hidden" class="form-control" id="role" value="member" name="role" required>
                            <input type="hidden" class="form-control" id="status" value="active" name="status" required>
                            <input type="hidden" class="form-control" id="user_id"
                                value="<?php echo $row['user_id']; ?>" name="user_id" required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" name="client_add" class="btn btn-success">Add Client</button>
                        <button type="button" class="btn btn-danger" onclick="closeForm()">Close</button>

                        <!--code Add Service-->
                        <?php
                        if (isset($_POST['client_add'])) {
                            // Extracting member data from the form
                            $firstname = $_POST['firstname'];
                            $lastname = $_POST['lastname'];
                            $middlename = $_POST['middlename'];
                            $suffixname = $_POST['suffixname'];
                            $address = $_POST['address'];
                            $email = $_POST['email'];
                            $contact_no = $_POST['contact_no'];
                            $age = $_POST['age'];
                            $birthday = $_POST['birthday'];
                            $gender = $_POST['gender'];
                            $guardianfirstname = $_POST['guardianfirstname'];
                            $guardianmiddlename = $_POST['guardianmiddlename'];
                            $guardianlastname = $_POST['guardianlastname'];
                            $guardian_contact_no = $_POST['guardian_contact_no'];
                            $guardian_contact_job = isset($_POST['guardian_contact_job']) ? $_POST['guardian_contact_job'] : ""; // Initialize $guardian_contact_job
                            $role = $_POST['role'];
                            $status = $_POST['status'];
                            $user_id = $_POST['user_id'];

                            // Check if guardian information is provided
                            $minor = !empty($guardianfirstname) || !empty($guardianmiddlename) || !empty($guardianlastname) || !empty($guardian_contact_no) ? 'yes' : 'no';

                            // Prepared statement to prevent SQL injection
                            $insert_member_query = $conn->prepare("INSERT INTO `members` 
                            (`member_id`, `firstname`, `lastname`, `middlename`, `suffixname`, `address`, `email`, `contact_no`, `age`, `birthday`, `gender`, `guardianfirstname`, `guardianmiddlename`, `guardianlastname`, `guardian_contact_no`, `guardian_job`, `minor`, `role`, `username`, `password`, `status`) 
                            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                            // Generating username
                            $username = strtolower($firstname[0] . $lastname); // Example: johndoe
                        
                            // Generating a temporary password (can be changed later)
                            $temp_password = uniqid(); // Example: 60f6f56d1f0d4
                        
                            // Bind parameters and execute
                            $insert_member_query->bind_param("sssssssissssssssssss", $firstname, $lastname, $middlename, $suffixname, $address, $email, $contact_no, $age, $birthday, $gender, $guardianfirstname, $guardianmiddlename, $guardianlastname, $guardian_contact_no, $guardian_contact_job, $minor, $role, $username, $temp_password, $status);

                            // Execute the query
                            if ($insert_member_query->execute()) {
                                // Get the last inserted ID
                                $last_inserted_id = $insert_member_query->insert_id;

                                // Constructing the alert message
                                $alert_message = "Member added successfully!\n";
                                $alert_message .= "Username: $username\n";
                                $alert_message .= "Temporary Password: $temp_password";

                                // Set success message
                                $_SESSION['success'] = "Successfully added Username:$username and Temporary Password:$temp_password";
                                // Log admin activity
                                addActivity_dentist("Add Account", "Admin Account: $user_id successfully added member $username", $user_id, $last_inserted_id, $conn);

                            } else {
                                // Set failure message
                                $_SESSION['failed'] = "Failed to add member";
                            }

                            // Close prepared statement
                            $insert_member_query->close();

                            // Displaying the alert using JavaScript
                            $alert_message = $_SESSION['success'] ?? $_SESSION['failed'] ?? ""; // Display success or failure message
                            echo "<script>alert('$alert_message');</script>";

                            // Close connection
                            mysqli_close($conn);

                            // Redirect back
                            echo "<script>window.location.href=document.referrer;</script>";
                        }

                        function addActivity_dentist($action, $description, $user_id, $member_id, $conn)
                        {
                            // Sanitize input
                            $action = mysqli_real_escape_string($conn, $action);
                            $description = mysqli_real_escape_string($conn, $description);
                            $user_id = mysqli_real_escape_string($conn, $user_id);
                            $member_id = mysqli_real_escape_string($conn, $member_id);

                            // Get timestamp
                            $timestamp = date("Y-m-d H:i:s");

                            // Prepare and execute query using prepared statements
                            $sql = "INSERT INTO activity_logs (action, description, user_id, member_id, timestamp) VALUES (?, ?, ?, ?, ?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("sssss", $action, $description, $user_id, $member_id, $timestamp);
                            if ($stmt->execute()) {
                                echo "Activity logged successfully";
                            } else {
                                echo "Error logging activity: " . $conn->error;
                            }
                        }
                        ?>

                        <script>
                            function calculateAge() {
                                var birthdayInput = document.getElementById("birthday").value;
                                var birthday = new Date(birthdayInput);
                                var today = new Date();
                                var age = today.getFullYear() - birthday.getFullYear();
                                var monthDiff = today.getMonth() - birthday.getMonth();
                                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthday.getDate())) {
                                    age--;
                                }
                                document.getElementById("age").value = age;

                                // Show or hide guardian information based on age
                                var guardianSection = document.getElementById("guardian_section");
                                if (age <= 18) {
                                    guardianSection.style.display = "block"; // Show guardian information
                                } else {
                                    guardianSection.style.display = "none"; // Hide guardian information
                                }

                                // Set age range based on age
                                var ageRangeInput = document.getElementById("age_range");
                                if (age <= 12) {
                                    ageRangeInput.value = "Child";
                                } else if (age >= 13 && age <= 18) {
                                    ageRangeInput.value = "Teenager";
                                } else {
                                    ageRangeInput.value = "Adult";
                                }
                            }
                        </script>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>