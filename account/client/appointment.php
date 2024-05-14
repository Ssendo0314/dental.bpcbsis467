<?php include('./function/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Appointment History</title><!--chart_bar-->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <!--Online Icon Design;-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
</head>

<body class="sb-nav-fixed">
    <!--Top Navbar-->
    <?php include('./function/navbar.php'); ?>
    <div id="layoutSidenav">
        <!--Nav Sidebar-->
        <?php include('./function/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <?php
                //Profile show
                $id = $_GET['member_id'];
                $list_query = "SELECT * FROM `members` WHERE member_id='$id'";
                $result = mysqli_query($conn, $list_query);
                while ($member_row = mysqli_fetch_array($result)) {
                    ?>
                    <!--DATABASE-->
                    <input type="hidden" name="id" id="member_id" value="<?php echo $member_row['member_id']; ?>">
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Appointment Record</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item">Personal Information</li>
                            <li class="breadcrumb-item active">Record</li>
                        </ol>
                        <!--Chart-->
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Apointment History
                                    </div>
                                    <div class="card-body"><canvas id="myChart" width="100%" height="40"></canvas></div>
                                    <?php
                                    // Your PHP data
                                    //history
                                    $history_query = "select * from schedule where `member_id`= $id AND `timestamp`";
                                    $history_query_run = mysqli_query($conn, $history_query);
                                    $history_total = mysqli_num_rows($history_query_run);
                                    //Done
                                    $done_query = "select * from schedule where `member_id`= $id AND `status`= 'Done'";
                                    $done_query_run = mysqli_query($conn, $done_query);
                                    $done_total = mysqli_num_rows($done_query_run);
                                    //Cancelled
                                    $cancelled_query = "select * from schedule where `member_id`= $id AND `status`= 'Cancelled'";
                                    $cancelled_query_run = mysqli_query($conn, $cancelled_query);
                                    $cancelled_total = mysqli_num_rows($cancelled_query_run);
                                    //Value
                                    $xValues = ["Done Apointment", "Cancelled Apointment",];
                                    $yValues = [$done_total, $cancelled_total];
                                    $barColors = ["#28a745", "#dc3545"];
                                    ?>
                                    <div class="card-footer small text-muted">
                                        <?php
                                        $time_query = "SELECT COUNT(*) AS total_rows, MAX(timestamp) AS last_timestamp FROM schedule WHERE member_id = $id";
                                        $time_query_run = mysqli_query($conn, $time_query);
                                        if ($time_query_run && mysqli_num_rows($time_query_run) > 0) {
                                            $row = mysqli_fetch_assoc($time_query_run);
                                            $time_total = $row['total_rows'];
                                            $last_timestamp = $row['last_timestamp'];
                                            $member_id = $id; // Assuming $id holds the member_id value
                                            ?>
                                            <label class="mb-0">
                                                Total Rows:
                                                <?php echo $time_total; ?><br>
                                                Last Timestamp:
                                                <?php echo $last_timestamp; ?><br>
                                            </label>
                                            <?php
                                        } else { ?>
                                            <h4 class="mb-0">0</h4>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Appointment History for this Week
                                    </div>
                                    <div class="card-body"><canvas id="myBar_solo" width="100%" height="40"></canvas></div>
                                    <?php
                                    // Get the current date from the clock script
                                    $currentDate = date('Y-m-d');

                                    // Calculate the start date of the week for the current date (Monday)
                                    $startDate = date('Y-m-d', strtotime('last monday', strtotime($currentDate)));

                                    // Calculate the end date of the week for the current date (Sunday)
                                    $endDate = date('Y-m-d', strtotime('next sunday', strtotime($startDate)));

                                    // Query to fetch data from your database for the specified week
                                    $query = "SELECT * FROM schedule WHERE member_id = '$id' AND date BETWEEN '$startDate' AND '$endDate'";

                                    // Execute the query
                                    $result = mysqli_query($conn, $query);

                                    // Check if there are any results
                                    if (mysqli_num_rows($result) > 0) {
                                        // Initialize an associative array to store data for each day of the week
                                        $weeklyData = array(
                                            'Monday' => array(),
                                            'Tuesday' => array(),
                                            'Wednesday' => array(),
                                            'Thursday' => array(),
                                            'Friday' => array(),
                                            'Saturday' => array(),
                                            'Sunday' => array()
                                        );

                                        // Fetch each row from the result set
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            // Determine the day of the week for the current row
                                            $dayOfWeek = date('l', strtotime($row['date']));

                                            // Store the row in the corresponding day's array
                                            $weeklyData[$dayOfWeek][] = $row;
                                        }

                                        // Prepare JSON encoded data for JavaScript
                                        $weeklyDataJSON = json_encode($weeklyData);
                                    } else {
                                        // No data found
                                        $weeklyDataJSON = '[]';
                                    }
                                    ?>
                                    <div class="card-footer small text-muted">
                                        <?php
                                        $time_query = "SELECT COUNT(*) AS total_rows, MAX(timestamp) AS last_timestamp FROM schedule WHERE member_id = $id";
                                        $time_query_run = mysqli_query($conn, $time_query);
                                        if ($time_query_run && mysqli_num_rows($time_query_run) > 0) {
                                            $row = mysqli_fetch_assoc($time_query_run);
                                            $time_total = $row['total_rows'];
                                            $last_timestamp = $row['last_timestamp'];
                                            $member_id = $id; // Assuming $id holds the member_id value
                                            ?>
                                            <label class="mb-0">
                                                Total Rows:
                                                <?php echo $time_total; ?><br>
                                                Last Timestamp:
                                                <?php echo $last_timestamp; ?><br>
                                            </label>
                                        <?php } else { ?>
                                            <h4 class="mb-0">0</h4>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Card-->
                        <div class="row">
                            <div class="col-xl-4 col-md-3">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Pending Appointment
                                        <?php
                                        $pending_query = "select * from schedule where `member_id`= $id AND `status`= 'Waiting'";
                                        $pending_query_run = mysqli_query($conn, $pending_query);
                                        if ($pending_total = mysqli_num_rows($pending_query_run)) { ?>
                                            <h4 class="mb-0">
                                                <?php echo $pending_total ?>
                                            </h4>
                                        <?php } else { ?>
                                            <h4 class="mb-0">0</h4>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-3">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Complete Appointment
                                        <?php
                                        $done_query = "select * from schedule where `member_id`= $id AND `status`= 'Done'";
                                        $done_query_run = mysqli_query($conn, $done_query);
                                        if ($done_total = mysqli_num_rows($done_query_run)) { ?>
                                            <h4 class="mb-0">
                                                <?php echo $done_total ?>
                                            </h4>
                                        <?php } else { ?>
                                            <h4 class="mb-0">0</h4>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-3">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Cancel Appointment
                                        <?php
                                        $cancelled_query = "select * from schedule where `member_id`= $id AND `status`= 'Cancelled'";
                                        $cancelled_query_run = mysqli_query($conn, $cancelled_query);
                                        if ($cancelled_total = mysqli_num_rows($cancelled_query_run)) { ?>
                                            <h4 class="mb-0">
                                                <?php echo $cancelled_total ?>
                                            </h4>
                                        <?php } else { ?>
                                            <h4 class="mb-0">0</h4>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Table-->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable for List of Appointment History
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover dt-responsive" id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Member</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Service</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Member</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Service</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $schedule_query = mysqli_query($conn, "SELECT * from schedule where member_id = $id ORDER BY date DESC") or die(mysqli_error($conn));
                                        while ($schedule_row = mysqli_fetch_array($schedule_query)) {
                                            $id = $schedule_row['id'];
                                            $timeslot = $schedule_row['timeslot'];
                                            $member_id = $schedule_row['member_id'];
                                            $account_id = $schedule_row['user_id'];
                                            $service_id = $schedule_row['service_id'];

                                            // Time slot
                                            $timeslot_query = mysqli_query($conn, "select * from timeslot where timeslot = '$timeslot'") or die(mysqli_error($conn));
                                            $timeslot_row = mysqli_fetch_array($timeslot_query);
                                            /* member query  */
                                            $member_query = mysqli_query($conn, "select * from members where member_id = ' $member_id'") or die(mysqli_error($conn));
                                            $member_row = mysqli_fetch_array($member_query);
                                            /* service query  */
                                            $account_query = mysqli_query($conn, "select * from users where user_id = ' $account_id' ") or die(mysqli_error($conn));
                                            $account_row = mysqli_fetch_array($account_query);
                                            /* service query  */
                                            $service_query = mysqli_query($conn, "select * from service where service_id = '$service_id' ") or die(mysqli_error($conn));
                                            $service_row = mysqli_fetch_array($service_query);
                                            ?>
                                            <tr>
                                                <td>
                                                    <!--NAME-->
                                                    <?php echo $member_row['firstname'] . " " . $member_row['lastname']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $schedule_row['date']; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Extracting time start and time end from the database
                                                    $time_start = $timeslot_row['time_start'];
                                                    $time_end = $timeslot_row['time_end'];

                                                    // Converting time to AM/PM format
                                                    $time_start_ampm = date("h:i A", strtotime($time_start));
                                                    $time_end_ampm = date("h:i A", strtotime($time_end));

                                                    echo $time_start_ampm . " to " . $time_end_ampm;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $service_row['service_offer']; ?>
                                                </td>
                                                <td>
                                                    <?php if ($schedule_row['status'] == "Done") { ?>
                                                        <button class="btn btn-success" disabled>Appointment Done</button>
                                                    <?php } else if ($schedule_row['status'] == "Waiting") { ?>
                                                            <button class="btn btn-warning" disabled>Pending</button>
                                                    <?php } else if ($schedule_row['status'] == "Cancelled") { ?>
                                                                <button class="btn btn-danger" disabled>Cancelled</button>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <!-- Cancelled -->
                                                    <?php if ($schedule_row['status'] == "Waiting") { ?>
                                                        <form action="./function/update.php" method="GET">
                                                            <input type="hidden" name="id"
                                                                value="<?php echo $schedule_row['id']; ?>">
                                                            <input type="hidden" name="member_id"
                                                                value="<?php echo $schedule_row['member_id']; ?>">
                                                            <input type="hidden" name="status" value="Cancelled">
                                                            <button type="submit" class="btn btn-danger" name="schedule_Cancelled"
                                                                onclick="return confirm('are you sure the schedule is Cancelled?')">Cancelled</button>
                                                        </form>
                                                    <?php } ?>
                                                    <br><!-- View -->
                                                    <a class="btn btn-primary"
                                                        href="./schedule_view.php?id=<?php echo $schedule_row['id']; ?>"
                                                        name="schedule_view"><i class='bx bxs-info-circle'></i>
                                                        View</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </main>
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
        /* Pie Chart for Appointment */
        var xValues = <?php echo json_encode($xValues); ?>;
        var yValues = <?php echo json_encode($yValues); ?>;
        var barColors = <?php echo json_encode($barColors); ?>;

        new Chart("myChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: { display: false },
                title: {
                    display: true,
                    text: "The Total :<?php echo json_encode($history_total); ?>",
                },
            }
        });

        /* Bar Chart */
        var weeklyData = <?php echo $weeklyDataJSON; ?>;

        // Prepare data for Chart.js
        var labels = Object.keys(weeklyData);
        var data = Object.values(weeklyData).map(week => week.length);

        // Chart configuration
        var ctx = document.getElementById('myBar_solo').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Weekly Schedule',
                    data: data,
                    backgroundColor: '#28a745'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>