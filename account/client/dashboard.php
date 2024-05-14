<?php include ('./function/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--Online Icon Design; BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <title>Dashboard - Client</title>
    <style>
        .muted-link {
            color: #6c757d;
            /* Adjust the color code as per your preference */
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
                <div class="container-fluid px-6">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <!--Message-->
                    <?php if (isset ($_SESSION['success'])) { ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                onclick="window.location.href ='./dashboard.php'"><span aria-hidden="true"><i
                                        class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['success']; ?>
                        </div>
                        <?php
                        unset($_SESSION['success']);
                    } ?>
                    <!--space-->
                    <?php if (isset ($_SESSION['failed'])) { ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                onclick="window.location.href ='./dashboard.php'"><span aria-hidden="true"><i
                                        class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['failed']; ?>
                        </div>
                        <?php
                        unset($_SESSION['failed']);
                    } ?>
                    <!--space-->
                    <?php
                    // Check if dentist info is available in session
                    if (isset ($_SESSION['dentist_info'])) {
                        $dentist_info = $_SESSION['dentist_info'];
                        // Unset the session variable to clear it after displaying
                        unset($_SESSION['dentist_info']);
                        ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                onclick="window.location.href ='./dashboard.php'">
                                <span aria-hidden="true"><i class='bx bx-x-circle'></i></span>
                            </button>
                            <!-- Displaying Date, Timeslot, and Location -->
                            <p>Date:
                                <?php echo $_SESSION['date']; ?>
                            </p>
                            <p>Dentist:
                                <?php echo $dentist_info['firstname'] . ' ' . $dentist_info['lastname']; ?>
                            </p>


                            <!-- Form for setting an appointment -->
                            <form class="formContainer" method="POST" action="./function/yes.php">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="hidden" name="date1" value="<?php echo $_SESSION['date']; ?>">
                                <input type="hidden" name="timeslot1" value="<?php echo $_SESSION['timeslot']; ?>">
                                <input type="hidden" name="location1" value="<?php echo $_SESSION['location']; ?>">
                                <input type="hidden" name="service1" value="<?php echo $_SESSION['service']; ?>">
                                <input type="hidden" name="dentist1" value="<?php echo $dentist_info['user_id']; ?>">
                                <input type="hidden" name="equal" value="1">
                                <input type="hidden" name="question1" value="<?php echo $row['question_id'] ?>">
                                <p>Please Confirm your appointment schedule</p>
                                <button name="yes" class="btn btn-success"><i
                                        class="icon-check icon-large"></i>&nbsp;Yes</button>
                                &nbsp; <a href="../client/dashboard.php" class="btn btn-danger"><i
                                        class="icon-remove"></i>&nbsp;No</a>
                            </form>
                        </div>
                    <?php } ?>

                    <?php
                    if (isset ($_SESSION['error_message'])) {
                        $error_message = $_SESSION['error_message'];
                        // Unset the session variable to clear it after displaying
                        unset($_SESSION['error_message']);
                        ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                onclick="window.location.href ='./dashboard.php'">
                                <span aria-hidden="true"><i class='bx bx-x-circle'></i></span>
                            </button>
                            <?php echo $error_message; ?>
                        </div>
                    <?php } ?>
                    <br>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <a href="./calendar.php" class="muted-link"><i class='bx bxs-calendar'></i> My
                                        Calendar</a>
                                </div>
                                <?php include ('./mini_calendar.php'); ?>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <h2>Hello,
                                    <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>!
                                </h2>
                                <br>
                                <!--Create Appointment-->
                                <?php
                                // Construct the SQL query to select the schedule for the provided member_id with status = 'Waiting'
                                $schedule_query = "SELECT * FROM `schedule` WHERE `member_id`= '$id' AND `status` = 'Waiting' LIMIT 1";
                                $schedule_result = mysqli_query($conn, $schedule_query);

                                // Fetch the schedule row
                                if ($schedule_row = mysqli_fetch_assoc($schedule_result)) {
                                    // Retrieve relevant information from the schedule row
                                    $service_id = $schedule_row['service_id'];
                                    $number_id = $schedule_row['timeslot'];
                                    $location_id = $schedule_row['location_id'];

                                    /* Service query */
                                    $service_query = mysqli_query($conn, "SELECT * FROM `service` WHERE `service_id` = '$service_id'") or die (mysqli_error($conn));
                                    $service_row = mysqli_fetch_assoc($service_query);
                                    /* Timeslot query */
                                    $time_query = mysqli_query($conn, "SELECT * FROM `timeslot` WHERE `timeslot` = '$number_id'") or die (mysqli_error($conn));
                                    $time_row = mysqli_fetch_assoc($time_query);
                                    // location query
                                    $location_query = mysqli_query($conn, "SELECT * FROM `location` WHERE `location_id` = '$location_id'") or die (mysqli_error($conn));
                                    $location_row = mysqli_fetch_assoc($location_query);
                                    if ($schedule_row['status'] == "Waiting")
                                    ?>

                                    <h5>You have existing Appointment, Do you want to Cancel?</h5>
                                    <label for="date">Date</label>
                                    <input type="date" name="date" value="<?php echo $schedule_row['date']; ?>" disabled>
                                    <label for="treatment">Treatment</label>
                                    <input type="text" name="treatment" value="<?php echo $service_row['service_offer']; ?>"
                                        disabled>
                                    <?php
                                    // Extracting time start and time end from the database
                                    $time_start = $time_row['time_start'];
                                    $time_end = $time_row['time_end'];

                                    // Converting time to AM/PM format
                                    $time_start_ampm = date("h:i A", strtotime($time_start));
                                    $time_end_ampm = date("h:i A", strtotime($time_end));
                                    ?>
                                    <label for="time">Timeslot</label>
                                    <input type="text" name="time"
                                        value="This Slot <?php echo $time_row['timeslot']; ?> (<?php echo $time_start_ampm . " to " . $time_end_ampm; ?>)" disabled>
                                    <?php if (!empty ($location_row['map'])) { ?>
                                        <label for="location">Location</label>
                                        <input type="text" name="time"
                                            value="<?php echo htmlspecialchars($location_row['location']); ?>" disabled>
                                        <a href="<?php echo htmlspecialchars($location_row['map_link']); ?>" target="_blank"
                                            class="text-muted">
                                            <?php echo htmlspecialchars($location_row['map']); ?>
                                        </a>
                                    <?php } else { ?>
                                        <label for="location">Location</label>
                                        <input type="text" name="time"
                                            value="<?php echo htmlspecialchars($location_row['location']); ?>" disabled>
                                    <?php } ?>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-3">
                                        <br>
                                            <form action="./function/update.php" method="GET">
                                                <input type="hidden" name="id" value="<?php echo $schedule_row['id']; ?>">
                                                <input type="hidden" name="member_id"
                                                    value="<?php echo $schedule_row['member_id']; ?>">
                                                <input type="hidden" name="status" value="Cancelled">
                                                <button type="submit" class="btn btn-danger px-4" name="schedule_Cancelled"
                                                    onclick="return confirm('are you sure you want to Cancel the schedule appointment?')">Cancel</button>
                                            </form>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                        <br>
                                            <a
                                                href="./function/print/schedule_info.php?id=<?php echo $schedule_row['id']; ?>"><button
                                                    type="button" class="btn btn-secondary"><i class='bx bx-printer'></i>
                                                    Print
                                                    The
                                                    Information</button></a>
                                        </div>
                                    </div>
                                    <br>
                                <?php } else { ?>
                                    <!--Include another PHP file to handle adding new appointments-->
                                    <?php include ('./function/add_ap.php'); ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card mb-12">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card mb-4">
                                <?php $member_query = "SELECT * FROM `members` WHERE member_id='$id'";
                                $result = mysqli_query($conn, $member_query);
                                while ($member_row = mysqli_fetch_array($result)) { ?>
                                    <div class="card-header">
                                        <h4><b>My Information</b></h4>
                                    </div>
                                    <br>
                                    <label for="full_name">Name</label>
                                    <input type="text" name="full_name"
                                        value="<?php echo $member_row['firstname'] . ' ' . $member_row['lastname']; ?>"
                                        disabled>
                                    <label for="role">Role</label>
                                    <input type="text" name="role" value="<?php echo $member_row['role']; ?>" disabled>
                                    <br><br>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <p>Your Information here: <a class="small stretched-link"
                                                href="./profile.php?member_id=<?php echo $member_row['member_id']; ?>">View
                                                Profile</a></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4><b>My Record</b></h4>
                                </div>
                                <br><br><br>
                                <h5>Ensure Record are Safe!</h5>
                                <p>You can now track your record with us</p>
                                <br><br>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <p>Find your Record here: <a class="small stretched-link"
                                            href="./appointment.php?member_id=<?php echo $row['member_id']; ?>">View
                                            Details</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4><b>My Treament Plan</b></h4>
                                </div>
                                <?php
                                // Construct the SQL query to select the schedule for the provided member_id
                                $schedule_query = "SELECT * FROM `schedule` WHERE `member_id`= '$id' AND `status` = 'Waiting' LIMIT 1";
                                $schedule_result = mysqli_query($conn, $schedule_query);

                                // Fetch the schedule row
                                if ($schedule_row = mysqli_fetch_assoc($schedule_result)) {
                                    // Retrieve relevant information from the schedule row
                                    $service_id = $schedule_row['service_id'];
                                    $number_id = $schedule_row['timeslot'];
                                    $location_id = $schedule_row['location_id'];

                                    /* Service query */
                                    $service_query = mysqli_query($conn, "SELECT * FROM `service` WHERE `service_id` = '$service_id'") or die (mysqli_error($conn));
                                    $service_row = mysqli_fetch_assoc($service_query);
                                    /* Timeslot query */
                                    $time_query = mysqli_query($conn, "SELECT * FROM `timeslot` WHERE `timeslot` = '$number_id'") or die (mysqli_error($conn));
                                    $time_row = mysqli_fetch_assoc($time_query);
                                    // location query
                                    $location_query = mysqli_query($conn, "SELECT * FROM `location` WHERE `location_id` = '$location_id'") or die (mysqli_error($conn));
                                    $location_row = mysqli_fetch_assoc($location_query);
                                    if ($schedule_row['status'] == 'Waiting') { ?>
                                        <label for="date">Date</label>
                                        <input type="date" name="date" value="<?php echo $schedule_row['date']; ?>" disabled>
                                        <label for="treatment">Treatment</label>
                                        <input type="text" name="treatment" value="<?php echo $service_row['service_offer']; ?>"
                                            disabled>
                                        <?php
                                        // Extracting time start and time end from the database
                                        $time_start = $time_row['time_start'];
                                        $time_end = $time_row['time_end'];

                                        // Converting time to AM/PM format
                                        $time_start_ampm = date("h:i A", strtotime($time_start));
                                        $time_end_ampm = date("h:i A", strtotime($time_end));
                                        ?>
                                        <label for="time">Timeslot</label>
                                        <input type="text" name="time"
                                            value="<?php echo $time_start_ampm . " to " . $time_end_ampm; ?>" disabled>
                                        <?php if (!empty ($location_row['map'])) { ?>
                                            <label for="location">Location</label>
                                            <input type="text" name="time"
                                                value="<?php echo htmlspecialchars($location_row['location']); ?>" disabled>
                                            <a href="<?php echo htmlspecialchars($location_row['map_link']); ?>" target="_blank"
                                                class="text-muted">
                                                <?php echo htmlspecialchars($location_row['map']); ?>
                                            </a>
                                        <?php } else { ?>
                                            <label for="location">Location</label>
                                            <input type="text" name="time"
                                                value="<?php echo htmlspecialchars($location_row['location']); ?>" disabled>
                                        <?php } ?>
                                    <?php } else {
                                        // Debug information
                                        echo "Status: " . $schedule_row['status'] . "<br>";
                                        echo "Waiting branch not entered!";
                                        ?>
                                        <br>
                                        <h5>Schedule An Appointment Now!</h5>
                                        <p>We provide Quality Service</p>
                                        <br>
                                    <?php }
                                } else {
                                    // Debug information
                                    //echo "No schedule found!";
                                    ?>
                                    <br><br>
                                    <h5>Schedule An Appointment Now!</h5>
                                    <p>We provide Quality Service</p>
                                    <br><br>
                                <?php } ?>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <p>You can find your treatment plan here: <a class="small stretched-link"
                                            href="./treatment_plan.php?member_id=<?php echo $row['member_id']; ?>">View
                                            Details</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include ('./function/footer.php'); ?>
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
</body>

</html>