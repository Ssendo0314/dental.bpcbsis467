<?php
// Include the database connection script
include('./function/alert.php');

// Function to fetch schedule data with week
function getWeeklySchedule($week)
{
    global $conn;
    $sql = "SELECT date, WEEK(date) as week FROM schedule WHERE WEEK(date) = $week"; // Modified SQL query to fetch data for a specific week
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
    <title>Dashboard - Owner</title>
    <!-- CSS LINK -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <!--Online Icon Design;-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <!--Message-->
                    <?php if (isset($_SESSION['success'])) { ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                onclick="window.location.href ='dashboard.php'"><span aria-hidden="true"><i
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
                                onclick="window.location.href ='dashboard.php'"><span aria-hidden="true"><i
                                        class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['failed']; ?>
                        </div>
                        <?php
                        unset($_SESSION['failed']);
                    } ?>
                    <!-- Opening for owner -->
                    <div class="card text-center">
                        <div class="card-header">
                            
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Welcome Back, Boss <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>!</h5>
                            <p class="card-text">I hope you have a Great Day.
                            </p>
                        </div>
                        <div class="card-footer text-muted">
                            you are currently using Admin Mode
                        </div>
                    </div>
                    <br>
                    <!--Chart-->
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    <a href="./service.php">List of Service</a>
                                </div>
                                <br><br>
                                <div class="card-body"><canvas id="myChart2" width="100%" height="40"></canvas></div>
                                <?php
                                // Execute the query to retrieve service_offer values and count service_id from schedule
                                $sql = "SELECT s.service_offer AS service_offer, COUNT(sc.service_id) AS count 
                                FROM schedule AS sc 
                                LEFT JOIN service AS s ON sc.service_id = s.service_id 
                                GROUP BY sc.service_id";
                                $result = $conn->query($sql);

                                // Process the data
                                $data = array();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $data[] = array(
                                            'service_offer' => $row['service_offer'],
                                            'count' => $row['count']
                                        );
                                    }
                                }
                                ?>
                                <div class="card-footer small text-muted">
                                    <?php
                                    $time_query = "SELECT COUNT(*) AS total_rows, MAX(timestamp) AS last_timestamp FROM schedule";
                                    $time_query_run = mysqli_query($conn, $time_query);
                                    if ($time_query_run && mysqli_num_rows($time_query_run) > 0) {
                                        $row = mysqli_fetch_assoc($time_query_run);
                                        $last_timestamp = $row['last_timestamp'];
                                        ?>
                                        <label class="mb-0">
                                            <br>
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
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    <a href="./function/apk_select _nav_history.php">Weekly Schedule Bar Chart</a>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <a class="btn btn-secondary" href="?week=<?php echo $week - 1; ?>">Previous</a>
                                        <!-- Navigate to previous week -->
                                        <a class="btn btn-secondary" href="?week=<?php echo $week + 1; ?>">Next</a>
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
                </div>
            </main>
            <?php include('./function/footer.php'); ?>
        </div>
    </div>

    <!-- JS -->
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

        //Chart
        // Get data from PHP
        var data = <?php echo json_encode($data); ?>;

        // Prepare labels and data for the chart
        var labels = [];
        var counts = [];
        data.forEach(function (item) {
            labels.push(item.service_offer);
            counts.push(item.count);
        });

        // Create the chart
        var ctx = document.getElementById('myChart2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Service Count',
                    data: counts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
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