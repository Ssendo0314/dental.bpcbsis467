<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Icon Link-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--CSS-->
    <link rel="stylesheet" type="text/css" href="./css/mystyle.css">
    <link rel="stylesheet" type="text/css" href="./css/table_design.css">
    <!--Chart-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <title>Add New Service -Admin</title>
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
        }

        .modal-body>div {
            flex: 1;
        }
    </style>
</head>

<body>
    <!-- The Modal -->
    <div class="modal" id="popupForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Stuff</h4>
                    <button type="button" class="btn-close" onclick="closeForm()"></button>
                </div>

                <!-- Modal body -->
                <form class="formContainer" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <label for="firstname">
                            <strong>First Name</strong>
                        </label>
                        <input type="text" class="form-control" id="firstname" placeholder="Your First Name"
                            name="firstname" required>
                        <label for="middlename">
                            <strong>Middle Name</strong>
                        </label>
                        <input type="text" class="form-control" id="middlename" placeholder="Your Middle Name"
                            name="middlename" required>
                        <label for="lastname">
                            <strong>Last Name</strong>
                        </label>
                        <input type="text" class="form-control" id="lastname" placeholder="Your Last Name"
                            name="lastname" required>
                        <label for="age">
                            <strong>Age</strong>
                        </label>
                        <input type="number" class="form-control" id="age" placeholder="Your Age must be at least 16 "
                            name="age" required>
                        <label for="birthday">
                            <strong>Birthday</strong>
                        </label>
                        <input type="date" class="form-control" id="birthday" name="birthday" onchange="calculateAge()"
                            required max="<?php echo date('Y-m-d'); ?>">
                        <div id="ageError" style="color: red; display: none;">You must be at least 16 years old to
                            register.</div>
                        <label for="gender">
                            <strong>Gender</strong>
                        </label>
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="Female">Famale</option>
                            <option value="Male">Male</option>
                        </select>
                        <label for="role">
                            <strong>Role</strong>
                        </label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="dentist">Dentist</option>
                        </select>
                        <input type="hidden" id="bio" value="" name="bio" required>
                        <input type="hidden" id="status" value="active" name="status" required>
                        <input type="hidden" id="user_id" value="<?php echo $row['user_id']; ?>" name="user_id"
                            required>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" name="user_add" class="btn btn-success">Add Stuff</button>
                        <button type="button" class="btn btn-danger" onclick="closeForm()">Close</button>
                    </div>

                    <!--code Add Stuff-->
                    <?php
                    if (isset($_POST['user_add'])) {
                        $firstname = $_POST['firstname'];
                        $middlename = $_POST['middlename'];
                        $lastname = $_POST['lastname'];
                        $age = $_POST['age'];
                        $gender = $_POST['gender'];
                        $role = $_POST['role'];
                        $birthday = $_POST['birthday']; // New birthday field
                        $user_id = $_POST['user_id'];

                        // Check if age is below 16
                        if ($age < 16) {
                            $_SESSION['failed'] = "You must be at least 16 years old to register.";
                            echo "<script>window.location.href=document.referrer;</script>";
                            exit; // Stop further execution
                        }

                        // Generate a unique username (e.g., using the first name and last name)
                        $username = strtolower($firstname . '.' . $lastname);
                        // Generate a random password (you may use a more secure method)
                        $password = generateRandomPassword();
                        $status = $_POST['status'];

                        // Database insertion
                        $user_query = "INSERT INTO `users` (`username`, `firstname`, `middlename`, `lastname`, `age`, `gender`, `role`, `password`, `birthday`, `status`) 
                        VALUES ('$username', '$firstname', '$middlename', '$lastname','$age', '$gender', '$role', '$password', '$birthday', '$status')";
                        $user_result = mysqli_query($conn, $user_query);

                        // Activity logging
                        if ($user_result) {
                            $action = 'User Registered';
                            $description = 'New user registered with username: ' . $username;
                            $user_id = $_POST['user_id']; // You can set the user ID here if applicable
                            $member_id = ''; // You can set the member ID here if applicable
                            addActivity_admin($action, $description, $user_id, $member_id, $conn);
                            $_SESSION['success'] = "User added successfully!";
                            echo "<script>window.location.href=document.referrer;</script>";
                        } else {
                            $_SESSION['failed'] = "Failed to add new account";
                            echo "<script>window.location.href=document.referrer;</script>";
                        }
                    }

                    // Function to generate a random password
                    function generateRandomPassword($length = 8)
                    {
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $password = '';
                        for ($i = 0; $i < $length; $i++) {
                            $password .= $characters[rand(0, strlen($characters) - 1)];
                        }
                        return $password;
                    }

                    // Function addActivity_dentist for activity logging
                    function addActivity_admin($action, $description, $user_id, $member_id, $conn)
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

                        document.addEventListener('DOMContentLoaded', function () {
                            document.getElementById('age').addEventListener('input', function () {
                                var ageInput = this.value;
                                var ageError = document.getElementById('ageError');
                                if (ageInput < 16) {
                                    ageError.style.display = 'block';
                                } else {
                                    ageError.style.display = 'none';
                                }
                            });
                        });

                        function openForm() {
                            document.getElementById("popupForm").style.display = "block";
                        }

                        function closeForm() {
                            document.getElementById("popupForm").style.display = "none";
                        }
                    </script>

                </form>

            </div>
        </div>
    </div>
</body>

</html>