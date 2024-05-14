<?php include ('./function/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- Datatables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- Custom Stylesheets -->
    <link href="../../css/styles.css" rel="stylesheet" />
    <link href="../../css/profile.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- BoxIcons -->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <title>Contact Statt - Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styling */
        .top-image {
            height: 300px;
            /* Adjust height as needed */
            background-image: url('../../picture/Background.png');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Adjust opacity as needed */
        }

        .profile-image {
            width: 110px;
            height: 110px;
            object-fit: cover;
            /* Maintain aspect ratio */
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <!--Top Navbar-->
    <?php include ('./function/navbar.php'); ?>
    <div id="layoutSidenav">
        <!--Nav Sidebar-->
        <?php include ('./function/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <?php
                //Profile show
                $id = $_GET['user_id'];
                $list_query = "SELECT * FROM `users` WHERE user_id='$id'";
                $result = mysqli_query($conn, $list_query);
                while ($user_row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="container-fluid px-4">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="top-image">
                                        <div class="overlay"></div>
                                        <ol class="breadcrumb mb-4">
                                            <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item">Account</li>
                                            <li class="breadcrumb-item"><a href="./contact_dentist.php">Contact Staff</a>
                                            </li>
                                            <li class="breadcrumb-item active">Contact Staff View</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="main-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <?php
                                                    if (!empty($user_row['image'])) {
                                                        echo '<img src="../../picture/profile/' . $user_row['image'] . '" 
                                                        alt="Admin" class="rounded-circle p-1 bg-primary profile-image">';
                                                    } else {
                                                        echo '<img src="../../picture/profile/human.png"
                                                        alt="Admin" class="rounded-circle p-1 bg-primary profile-image" width="110">';
                                                    }
                                                    ?>
                                                    <div class="mt-3">
                                                        <h4>
                                                            <?php echo $user_row['firstname'] . ' ' . $user_row['lastname']; ?>
                                                        </h4>
                                                        <p class="text-secondary mb-1">
                                                            <?php echo $user_row['username']; ?>
                                                        </p>
                                                        <p class="text-muted font-size-sm">
                                                            <strong>
                                                                <?php echo $user_row['role']; ?>
                                                            </strong>
                                                        </p>
                                                        <p class="text-muted font-size-sm">
                                                            <?php
                                                            if (!empty($user_row['bio'])) {
                                                                echo $user_row['bio'];
                                                            } else {
                                                                echo 'No bio available';
                                                            }
                                                            ?>
                                                        </p>
                                                        </p>
                                                        <?php if ($user_row['status'] == "active") { ?>
                                                            <form action="./function/update.php" method="GET">
                                                                <input type="hidden" name="user_id"
                                                                    value="<?php echo $user_row['user_id']; ?>">
                                                                <input type="hidden" name="status" value="not active">
                                                                <button type="submit" class="btn btn-outline-success"
                                                                    name="update_deactivate_staff"
                                                                    onclick="return confirm('Are you sure you want to deactivate the account?')">Active</button>
                                                            </form>
                                                        <?php } else if ($user_row['status'] == "not active") { ?>
                                                                <form action="./function/update.php" method="GET">
                                                                    <input type="hidden" name="user_id"
                                                                        value="<?php echo $user_row['user_id']; ?>">
                                                                    <input type="hidden" name="status" value="active">
                                                                    <button type="submit" class="btn btn-outline-danger"
                                                                        name="update_active_staff"
                                                                        onclick="return confirm('Are you sure you want to activate the account?')">Not
                                                                        Active</button>
                                                                </form>
                                                        <?php } else if ($user_row['status'] == "temporary") { ?>
                                                                    <button type="submit" class="btn btn-outline-primary"
                                                                        disabled>temporary
                                                                        Adden</button>

                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <hr class="my-4">
                                                <ul class="list-group list-group-flush">
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-globe me-2 icon-inline">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                                                <path
                                                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                                                </path>
                                                            </svg>Website</h6>
                                                        <?php if (!empty($user_row['website'])) { ?>
                                                            <span class="text-secondary">
                                                                <a href="<?php echo $user_row['website']; ?>" target="_blank"
                                                                    class="text-secondary">
                                                                    <?php echo $user_row['website_name']; ?>
                                                                </a>
                                                            </span>
                                                        <?php } else { ?>
                                                            <span class="text-secondary">No Website Found</span>
                                                        <?php } ?>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <h6 class="mb-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-facebook me-2 icon-inline text-primary">
                                                                <path
                                                                    d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                                                </path>
                                                            </svg>
                                                            Facebook
                                                        </h6>
                                                        <?php if (!empty($user_row['facebook'])) { ?>
                                                            <span class="text-secondary">
                                                                <a href="<?php echo $user_row['facebook']; ?>" target="_blank"
                                                                    class="text-secondary">
                                                                    <?php echo $user_row['firstname'] . ' ' . $user_row['lastname']; ?>
                                                                </a>
                                                            </span>
                                                        <?php } else { ?>
                                                            <span class="text-secondary">No facebook Found</span>
                                                        <?php } ?>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <h6 class="mb-0">Location</h6>
                                                        <?php
                                                        $location_query = mysqli_query($conn, "SELECT * from location WHERE location_id = '{$user_row['location_id']}'") or die(mysqli_error($conn));
                                                        while ($location_row = mysqli_fetch_array($location_query)) {

                                                            if (!empty($location_row['location_id'])) { ?>
                                                                <span class="text-secondary">
                                                                    <?php echo $location_row['location']; ?>
                                                                </span>
                                                            <?php } else { ?>
                                                                <span class="text-secondary"> No Location Found</span>
                                                            <?php }
                                                        } ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <!-- Content for the right section -->
                                        <button class="btn btn-outline-secondary"
                                            onclick="toggleContentMode('About')">About</button>
                                        <button class="btn btn-outline-secondary"
                                            onclick="toggleContentMode('schedule')">Schedule</button>
                                        <br><br>
                                        <?php if (isset($_SESSION['success'])) { ?>
                                            <div class="alert alert-success">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                                    onclick="window.location.href ='./contact_dentist_view.php?user_id=<?php echo $user_row['user_id']; ?>'"><span
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
                                                    onclick="window.location.href ='./contact_dentist_view.php?user_id=<?php echo $user_row['user_id']; ?>'"><span
                                                        aria-hidden="true"><i class='bx bx-x-circle'></i></span></button>
                                                <?php echo $_SESSION['failed']; ?>
                                            </div>
                                            <?php
                                            unset($_SESSION['failed']);
                                        } ?>
                                        <?php if (isset($_SESSION['message'])) { ?>
                                            <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                                    onclick="window.location.href ='./contact_dentist_view.php?user_id=<?php echo $user_row['user_id']; ?>'"><span
                                                        aria-hidden="true"><i class='bx bx-x-circle'></i></span></button>
                                                <?php echo $_SESSION['message']; ?>
                                            </div>
                                            <?php
                                            unset($_SESSION['message']);
                                        } ?>
                                        <div id="contentAbout">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Full Name</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <input type="text" class="form-control"
                                                                value="<?php echo $user_row['firstname'] . ' ' . $user_row['lastname']; ?>"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Address</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <?php
                                                            if (!empty($user_row['address'])) { ?>
                                                                <input type="text" class="form-control"
                                                                    value="<?php echo $user_row['address']; ?>" disabled>
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" value="No input address"
                                                                    disabled>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Contact Number</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <?php
                                                            if (!empty($user_row['contact_no'])) { ?>
                                                                <input type="text" class="form-control"
                                                                    value="<?php echo $user_row['contact_no']; ?>" disabled>
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control"
                                                                    value="No input Contact Number" disabled>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Age</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <?php
                                                            if (!empty($user_row['age'])) { ?>
                                                                <input type="text" class="form-control"
                                                                    value="<?php echo $user_row['age']; ?>" disabled>
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" value="No input Age"
                                                                    disabled>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Birthday</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <?php
                                                            if (!empty($user_row['birthday'])) { ?>
                                                                <input type="date" class="form-control"
                                                                    value="<?php echo $user_row['birthday']; ?>" disabled>
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control"
                                                                    value="No input birthday" disabled>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Gender</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <?php
                                                            if (!empty($user_row['gender'])) { ?>
                                                                <input type="text" class="form-control"
                                                                    value="<?php echo $user_row['gender']; ?>" disabled>
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" value="No input gender"
                                                                    disabled>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <a
                                                                href="./function/print/stuff_info.php?user_id=<?php echo $user_row['user_id']; ?>"><button
                                                                    type="button" class="btn btn-secondary px-4"><i
                                                                        class='bx bxs-printer'></i> Print
                                                                    Information</button></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="d-flex align-items-center mb-3">action counts</h5>
                                                            <!-- Display action counts -->
                                                            <div class="design-top">
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
                                                                        <p>
                                                                            <?php echo $action ?>
                                                                        </p>
                                                                        <!-- This is a paragraph element containing the action name -->
                                                                        <div class="progress mb-3" style="height: 5px">
                                                                            <!-- This is a div element with classes "progress" and "mb-3" from Bootstrap, representing a progress bar with some bottom margin -->
                                                                            <div class="progress-bar bg-primary" role="progressbar"
                                                                                style="width: <?php echo $count ?>%"
                                                                                aria-valuenow="<?php echo $count ?>"
                                                                                aria-valuemin="0" aria-valuemax="100">
                                                                                <!-- Inside the progress bar, there's another div with class "progress-bar" and class "bg-primary" from Bootstrap, representing the actual progress bar. It's styled with a blue color. -->
                                                                                <!-- The attributes aria-valuenow, aria-valuemin, and aria-valuemax are for accessibility purposes, indicating the current value, minimum, and maximum values respectively. -->
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br><!-- schedule-->
                                        <div id="contentschedule" style="display: none;">
                                            <h3>Schedule</h3>
                                            <ul class="unstyled">
                                                <li>
                                                    <a
                                                        href="./function/print/schedule_user.php?user_id=<?php echo $user_row['user_id']; ?>"><button
                                                            type="button" class="btn btn-secondary"><i
                                                                class='bx bx-printer'></i> Print The Schedule</button></a>
                                                </li>
                                            </ul>
                                            <br>
                                            <!--Table-->
                                            <?php
                                            // Check if user_id is set in the GET parameters
                                            if (!isset($_GET['user_id'])) {
                                                echo "<p>User ID not provided.</p>";
                                                exit; // This exits the script, preventing further execution
                                            }

                                            // Proceed only if user_id is provided
                                            $user_id = $_GET['user_id'];

                                            // User exists, proceed with generating the table
                                        
                                            // Define the start date (assuming the current week)
                                            $start_date = date('Y-m-d', strtotime('monday this week'));

                                            // Define office hours
                                            $office_hours_start = 8; // 8:00 AM
                                            $office_hours_end = 18; // 6:00 PM
                                        
                                            // Generate the table headers for Monday to Sunday
                                            echo "<div class='card'>";
                                            echo "<div class='table-responsive'>";
                                            echo "<table class='table table-bordered'>";
                                            echo "<thead class='thead-dark'>";
                                            echo "<tr>";
                                            echo "<th>Time</th>";
                                            for ($i = 0; $i < 7; $i++) {
                                                echo "<th>" . date('l', strtotime('monday this week +' . $i . ' days')) . "</th>"; // Display day name only
                                            }
                                            echo "</tr>";
                                            echo "</thead>";
                                            echo "<tbody>";

                                            // Generate the time slots for office hours
                                            for ($hour = $office_hours_start; $hour <= $office_hours_end; $hour++) {
                                                echo "<tr>";
                                                echo "<td>" . sprintf("%02d", $hour) . ":00</td>"; // Time in HH:00 format
                                                for ($day = 0; $day < 7; $day++) {
                                                    $current_day = date('l', strtotime('monday this week +' . $day . ' days'));
                                                    // Query duty from the database
                                                    $sql = "SELECT * FROM duty 
                    WHERE (duty_day = '$current_day' AND user_id = '$user_id') 
                    OR (duty_day LIKE '%$current_day%' AND duty_start_time <= '$hour:00:00' AND duty_end_time > '$hour:00:00')";
                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        // Output data of each row
                                                        $duty_info = "";
                                                        while ($duty_row = $result->fetch_assoc()) {
                                                            $account_id = $duty_row['user_id'];
                                                            $location_id = $duty_row['location_id'];
                                                            /* account query  */
                                                            $account_query = mysqli_query($conn, "select * from users where user_id = '$account_id' ") or die(mysqli_error($conn));
                                                            $account_row = mysqli_fetch_array($account_query);
                                                            /* Location query */
                                                            $location_query = mysqli_query($conn, "select * from location where location_id = '$location_id' ") or die(mysqli_error($conn));
                                                            $location_row = mysqli_fetch_array($location_query);

                                                            if ($duty_row["user_id"] == $user_id) {
                                                                $duty_info .= "<div class='duty-box'>";
                                                                $duty_info .= "Username: " . $account_row["username"] . "<br><br>";
                                                                $duty_info .= "Shop: " . $location_row["location"] . "<br>";
                                                                $duty_info .= "</div>";
                                                            }
                                                        }
                                                        echo "<td class='p-1'>$duty_info</td>";
                                                    } else {
                                                        echo "<td></td>";
                                                    }
                                                }
                                                echo "</tr>";
                                            }

                                            echo "</tbody>";
                                            echo "</table>";
                                            echo "</div>";
                                            echo "</div>";

                                            // Close database connection
                                            $conn->close();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include ('./function/footer.php'); ?>
            <?php } ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/chart-area-demo.js"></script>
    <script src="../../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../../js/datatables-simple-demo.js"></script>

    <!--JS Addition-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"> </script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./js/script.js"></script>


    <script>
        function toggleContentMode(mode) {
            var sections = document.querySelectorAll('[id^="content"]');
            sections.forEach(function (section) {
                if (section.id === "content" + mode) {
                    section.style.display = "block";
                } else {
                    section.style.display = "none";
                }
            });
        }

    </script>

</body>

</html>