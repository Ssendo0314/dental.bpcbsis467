<?php
// Include the database connection script
include ('./function/alert.php');
//Profile show
$location_id = $_GET['location_id'];
$list_query = "SELECT * FROM `location` WHERE location_id ='$location_id'";
$result = mysqli_query($conn, $list_query);
while ($location_row = mysqli_fetch_array($result)) {
    // Function to fetch schedule data with week
    function getWeeklySchedule($week)
    {
        global $conn;
        $location_id = $_GET['location_id'];
        $sql = "SELECT date, WEEK(date) as week FROM schedule WHERE WEEK(date) = '$week' AND location_id ='$location_id'";
        $result = $conn->query($sql);
        $dateLabels = array();
        $dateOccurrences = array();

        // Initialize the occurrences array for all days of the week
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        foreach ($daysOfWeek as $day) {
            $dateLabels[] = $day;
            $dateOccurrences[$day] = 0;
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $date = $row['date'];
                // Increment the occurrence count for the corresponding day
                $dayOfWeek = date('l', strtotime($date));
                $dateOccurrences[$dayOfWeek]++;
            }
        }
        return array(
            'labels' => $dateLabels,
            'occurrences' => array_values($dateOccurrences)
        );
    }

    // Handle navigation
    $week = isset($_GET['week']) ? $_GET['week'] : date('W'); // Default to current week
    $weeklySchedule = getWeeklySchedule($week);
    $dateLabels = $weeklySchedule['labels'];
    $dateOccurrences = $weeklySchedule['occurrences'];
    ?>

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
        <?php include ('./function/navbar.php'); ?>
        <div id="layoutSidenav">
            <!--Nav Sidebar-->
            <?php include ('./function/sidebar.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Cancelled Appointment</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item">My Pages</li>
                            <li class="breadcrumb-item">My Reports</li>
                            <li class="breadcrumb-item active">Cancelled Appointment</li>
                        </ol>
                        <!--Message-->
                        <?php if (isset($_SESSION['success'])) { ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                    onclick="window.location.href ='apk_done.php'"><span aria-hidden="true"><i
                                            class='bx bx-x-circle'></i></span></button>
                                <?php echo $_SESSION['success']; ?>
                            </div>
                            <?php
                            unset($_SESSION['success']);
                        } ?>
                        <!--space-->
                        <?php if (isset($_SESSION['failed'])) { ?>
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                    onclick="window.location.href ='apk_done.php'"><span aria-hidden="true"><i
                                            class='bx bx-x-circle'></i></span></button>
                                <?php echo $_SESSION['failed']; ?>
                            </div>
                            <?php
                            unset($_SESSION['failed']);
                        } ?>
                        <div class="card">
                            <div class="card-body">
                                <!-- check only -->
                                <?php //echo $location_row['location_id'];        ?>
                                <p>Location select is
                                    <strong>
                                        <?php echo $location_row['location']; ?>
                                    </strong>
                                </p>
                                <!-- Use any element to open the sidenav -->
                                <a class="btn btn-outline-primary" onclick="openNav()">Change Location</a>
                                <?php include ('./function/apk_selected_location.php'); ?>
                            </div>
                        </div>
                        <br>
                        <!--Chart-->
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Apointment History
                                    </div>
                                    <div class="card-body"><br><br><canvas id="myChart" width="100%" height="40"></canvas>
                                    </div>
                                    <?php
                                    // Your PHP data
                                    //history
                                    $history_query = "select * from schedule where timestamp";
                                    $history_query_run = mysqli_query($conn, $history_query);
                                    $history_total = mysqli_num_rows($history_query_run);
                                    //Done
                                    $done_query = "select * from schedule WHERE location_id = '$location_id' AND status= 'Done'";
                                    $done_query_run = mysqli_query($conn, $done_query);
                                    $done_total = mysqli_num_rows($done_query_run);
                                    //Pending
                                    $pending_query = "select * FROM schedule WHERE location_id = '$location_id' AND status= 'Waiting'";
                                    $pending_query_run = mysqli_query($conn, $pending_query);
                                    $pending_total = mysqli_num_rows($pending_query_run);
                                    //Cancelled
                                    $cancelled_query = "select * from schedule WHERE location_id = '$location_id' AND status= 'Cancelled'";
                                    $cancelled_query_run = mysqli_query($conn, $cancelled_query);
                                    $cancelled_total = mysqli_num_rows($cancelled_query_run);
                                    //Value
                                    $xValues = ["Done Apointment", "Pending Apointment", "Cancelled Apointment",];
                                    $yValues = [$done_total, $pending_total, $cancelled_total];
                                    $barColors = ["#28a745", "#ffc107", "#dc3545"];
                                    ?>
                                    <div class="card-footer small text-muted">
                                        <?php
                                        $time_query = "SELECT COUNT(*) AS total_rows, MAX(timestamp) AS last_timestamp FROM schedule WHERE location_id = '$location_id'";
                                        $time_query_run = mysqli_query($conn, $time_query);
                                        if ($history_query_run && mysqli_num_rows($time_query_run) > 0) {
                                            $row = mysqli_fetch_assoc($time_query_run);
                                            $time_total = $row['total_rows'];
                                            $last_timestamp = $row['last_timestamp'];
                                            ?>
                                            <label class="mb-0">
                                                Total Rows:
                                                <?php echo $time_total; ?><br>
                                                Last Timestamp:
                                                <?php if (!empty($last_timestamp)) {
                                                    echo $last_timestamp;
                                                } else {
                                                    echo 'no timeslot taken';
                                                } ?>
                                            </label>
                                        <?php } else { ?>
                                            <h4 class="mb-0">0</h4>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Weekly Schedule Bar Chart
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <a class="btn btn-secondary"
                                                href="./apk_done.php?location_id=<?php echo $location_row['location_id']; ?>&week=<?php echo $week - 1; ?>">Previous</a>
                                            <!-- Navigate to previous week -->

                                            <a class="btn btn-secondary"
                                                href="./apk_done.php?location_id=<?php echo $location_row['location_id']; ?>&week=<?php echo $week + 1; ?>">Next</a>
                                            <!-- Navigate to next week -->

                                        </div>
                                        <canvas id="scheduleChart" width="800" height="400"></canvas>
                                    </div>
                                    <div class="card-footer small text-muted">
                                        <p>
                                            <span id="weekLabel">Week
                                                <?php echo $week; ?>
                                            </span> <!-- Display current week -->
                                            <span id="weekDates"></span> <!-- Display dates for the week -->
                                        </p>
                                        <?php
                                        $time_query = "SELECT COUNT(*) AS total_rows, MAX(timestamp) AS last_timestamp FROM schedule";
                                        $time_query_run = mysqli_query($conn, $time_query);
                                        if ($time_query_run && mysqli_num_rows($time_query_run) > 0) {
                                            $row = mysqli_fetch_assoc($time_query_run);
                                            $last_timestamp = $row['last_timestamp'];
                                            ?>
                                            <label class="mb-0">
                                                Last Timestamp:
                                                <?php echo $last_timestamp; ?>
                                            </label>
                                            <?php
                                        } else {
                                            ?>
                                            <h4 class="mb-0">0</h4>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <!--Card-->
                        <?php include ('./function/card.php'); ?>
                        <!--Secondary Nav-->
                        <div class="card mb-4">
                            <!--Secondary Nav-->
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <!--Help-->
                                <a class="btn btn-info text-white" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapsehow" aria-expanded="false"
                                    aria-controls="pagesCollapsehow"><i class='bx bx-info-circle'></i>
                                    How
                                    to use</a>
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
                                            <th>Location</th>
                                            <th>Account Status</th>
                                            <th>Dentist Duty</th>
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
                                            <th>Location</th>
                                            <th>Account Status</th>
                                            <th>Dentist Duty</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $schedule_query = mysqli_query($conn, "SELECT * FROM schedule WHERE location_id = '$location_id'") or die(mysqli_error($conn));
                                        while ($schedule_row = mysqli_fetch_array($schedule_query)) {
                                            $id = $schedule_row['id'];
                                            $timeslot = $schedule_row['timeslot'];
                                            $member_id = $schedule_row['member_id'];
                                            $account_id = $schedule_row['user_id'];
                                            $service_id = $schedule_row['service_id'];

                                            $timeslot_query = mysqli_query($conn, "SELECT * FROM timeslot WHERE timeslot = '$timeslot'") or die(mysqli_error($conn));
                                            $timeslot_row = mysqli_fetch_array($timeslot_query);
                                            /* member query  */
                                            $member_query = mysqli_query($conn, "SELECT * FROM members WHERE member_id = '$member_id'") or die(mysqli_error($conn));
                                            $member_row = mysqli_fetch_array($member_query);
                                            /* service query  */
                                            $account_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$account_id' ") or die(mysqli_error($conn));
                                            $account_row = mysqli_fetch_array($account_query);
                                            /* service query  */
                                            $service_query = mysqli_query($conn, "SELECT * FROM service WHERE service_id = '$service_id' ") or die(mysqli_error($conn));
                                            $service_row = mysqli_fetch_array($service_query);

                                            if ($schedule_row['status'] == 'Cancelled') {
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
                                                        <?php echo $location_row['location']; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($member_row['status'] == "active") { ?>
                                                            <form action="./function/update.php" method="GET">
                                                                <input type="hidden" name="user_id"
                                                                    value="<?php echo $_SESSION['id']; ?>">
                                                                <input type="hidden" name="member_id"
                                                                    value="<?php echo $member_row['member_id']; ?>">
                                                                <input type="hidden" name="status" value="deactivate">
                                                                <button type="submit" class="btn bg-success text-white"
                                                                    name="update_deactivate"
                                                                    onclick="return confirm('Are you sure you want to deactivate the account?')">Activate</button>
                                                            </form>
                                                        <?php } else if ($member_row['status'] == "deactivate") { ?>
                                                                <form action="./function/update.php" method="GET">
                                                                    <input type="hidden" name="user_id"
                                                                        value="<?php echo $_SESSION['id']; ?>">
                                                                    <input type="hidden" name="member_id"
                                                                        value="<?php echo $member_row['member_id']; ?>">
                                                                    <input type="hidden" name="status" value="active">
                                                                    <button type="submit" class="btn bg-danger text-white"
                                                                        name="update_active"
                                                                        onclick="return confirm('Are you sure you want to activate the account?')">Deactivate</button>
                                                                </form>
                                                        <?php } ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        if (!empty($account_row['username'])) {
                                                            echo $account_row['username'];
                                                        } else {
                                                            // If $account_row['username'] is empty, you can echo some default content or leave it blank
                                                            echo "Username Not Available";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a class="btn"
                                                            href="./schedule_view.php?id=<?php echo $schedule_row['id']; ?>"
                                                            name="schedule_view"><i class='bx bxs-info-circle'></i> View</a>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>

            // $(document).ready(function () {
            //     // Listen for changes in the select input
            //     $('#location').change(function () {
            //         var locationId = $(this).val();

            //         // Send AJAX request to fetch data based on selected location
            //         $.ajax({
            //             url: './apk_history=filter.php', // Replace with the name of this file
            //             method: 'POST',
            //             data: { location_id: locationId },
            //             success: function (response) {
            //                 $('#view-container').html(response);
            //             },
            //             error: function (xhr, status, error) {
            //                 console.error(xhr.responseText);
            //             }
            //         });
            //     });
            // });

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
            /* Bar Chart */
            document.addEventListener('DOMContentLoaded', function () {
                var dateLabels = <?php echo json_encode($dateLabels); ?>;
                var dateOccurrences = <?php echo json_encode($dateOccurrences); ?>;
                var weekNumber = <?php echo $week; ?>;

                var ctx = document.getElementById('scheduleChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: dateLabels,
                        datasets: [{
                            label: 'Events in week',
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            data: dateOccurrences
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });

                // Function to get the start and end dates of the week
                function getWeekDates(week, year) {
                    var date = new Date(year, 0, 1 + (week - 1) * 7);
                    var startDate = new Date(date);
                    var endDate = new Date(date.setDate(date.getDate() + 6));
                    return [startDate.toDateString(), endDate.toDateString()];
                }

                var currentYear = new Date().getFullYear();
                var [startDate, endDate] = getWeekDates(weekNumber, currentYear);
                document.getElementById('weekDates').textContent = startDate + ' to ' + endDate;
            });

        </script>
    </body>

    </html>
<?php } ?>