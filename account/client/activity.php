<?php include('./function/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Activity Log - Admin</title>
    <!-- External CSS libraries -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- BoxIcons -->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <style>
        .activity-log {
            border-left: 3px solid #007bff;
            /* Adjust color and thickness as needed */
            padding-left: 10px;
            /* Adjust padding as needed */
            margin-bottom: 15px;
            /* Adjust margin as needed */
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <!-- Top Navbar -->
    <?php include('./function/navbar.php'); ?>
    <div id="layoutSidenav">
        <!-- Nav Sidebar -->
        <?php include('./function/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <br>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Activity Log</li>
                    </ol>
                    <div class="container-fluid gedf-wrapper">
                        <div class="row">
                            <!-- Side -->
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <?php
                                        if (!empty($row['image'])) {
                                            echo '<img class="card-img-top" src="../../picture/profile/' . $row['image'] . '" class="img-rounded" alt="Cinque Terre" style="width: 10rem;">';
                                        } else {
                                            echo '<img class="card-img-top" src="../../picture/profile/human.png" class="img-rounded" alt="Default Image" style="width: 10rem;">';
                                        }
                                        ?>
                                        <br><br>
                                        <div class="h5 card-title">
                                            <?php echo $row['username']; ?>
                                        </div>
                                        <div class="card-text text-muted">Fullname : </div>
                                        <div class="card-text">
                                            <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                                        </div>
                                        <br>
                                        <div class="card-text">
                                            <?php
                                            if (!empty($row['bio'])) {
                                                echo $row['bio'];
                                            } else {
                                                echo 'No Bio Information';
                                            } ?>
                                        </div>
                                        <br>
                                        <a class="link" href="./profile.php?user_id=<?php echo $row['member_id']; ?>">
                                            <!-- profile -->
                                            Profile
                                        </a>
                                    </div>
                                </div>
                                <br>
                                <div class="card">
                                    <div class="card -body">
                                        <div class="h5">Control</div>
                                        <form method="get">
                                            <button type="submit" class="btn btn-outline-primary active" name="filter"
                                                value="all">All</button>
                                            <button type="submit" class="btn btn-outline-primary" name="filter"
                                                value="today">Today</button>
                                            <button type="submit" class="btn btn-outline-primary" name="filter"
                                                value="yesterday">Yesterday</button>
                                            <button type="submit" class="btn btn-outline-primary" name="filter"
                                                value="last_week">Last
                                                Week</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Center -->
                            <div class="col-md-6 gedf-main">
                                <div class="container mt-5 mb-6">
                                    <div class="row">
                                        <div class="col-md-12 offset-md">
                                            <h2>Activity Log</h2>
                                            <br>
                                            <?php
                                            // Function to check if activity logs exist for a given filter
                                            function check_logs_exist($sql)
                                            {
                                                global $conn;
                                                $result = $conn->query($sql);
                                                return($result && $result->num_rows > 0);
                                            }

                                            // Retrieve and display activity logs based on filter
                                            $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
                                            switch ($filter) {
                                                case 'today':
                                                    $sql = "SELECT * FROM activity_logs WHERE member_id = $id AND DATE(timestamp) = CURDATE() ORDER BY timestamp DESC";
                                                    $logs_exist = check_logs_exist($sql);
                                                    break;
                                                case 'yesterday':
                                                    $sql = "SELECT * FROM activity_logs WHERE member_id = $id AND DATE(timestamp) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY timestamp DESC";
                                                    $logs_exist = check_logs_exist($sql);
                                                    break;
                                                case 'last_week':
                                                    $sql = "SELECT * FROM activity_logs WHERE member_id = $id AND DATE(timestamp) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE() ORDER BY timestamp DESC";
                                                    $logs_exist = check_logs_exist($sql);
                                                    break;
                                                default:
                                                    // For 'All' filter, check if logs exist without filtering by date
                                                    $sql = "SELECT * FROM activity_logs WHERE member_id = $id ORDER BY timestamp DESC";
                                                    $logs_exist = check_logs_exist($sql);
                                            }

                                            // Display message if no logs exist for today, yesterday, or last week
                                            if (!$logs_exist) {
                                                echo "<div class='alert alert-secondary' role='alert'>No activity logs found for this filter.</div>";
                                            } else {
                                                // Fetch and display activity logs
                                                $result = $conn->query($sql);
                                                if ($result && $result->num_rows > 0) {
                                                    // Initialize the previous group label
                                                    $prev_group_label = null;

                                                    // Display logs
                                                    while ($activity_row = $result->fetch_assoc()) {
                                                        // Exclude logs with actions "Update Active" and "Update Deactive"
                                                        if ($activity_row['action'] == 'Update Active' || $activity_row['action'] == 'Update Deactive') {
                                                            continue; // Skip this log and move to the next one
                                                        }

                                                        // Get the group label for the current activity log
                                                        $current_group_label = get_group_label($activity_row['timestamp'], $filter);

                                                        // If the group label has changed, add an <hr> tag and display the new group label
                                                        if ($current_group_label !== $prev_group_label) {
                                                            if ($prev_group_label !== null) {
                                                                echo "<hr>";
                                                            }
                                                            echo "<h4>$current_group_label</h4>";
                                                            $prev_group_label = $current_group_label;
                                                        }

                                                        // Display each activity log
                                                        ?>
                                                        <div class="activity-log card gedf-card mb-3">
                                                            <div class="card-header">
                                                                <?php echo $activity_row['action']; ?>
                                                            </div>
                                                            <div class="card-body">
                                                                <p class="card-text">
                                                                    <?php echo $activity_row['description']; ?>
                                                                </p>
                                                                <p class="card-text">
                                                                    <?php
                                                                    // Display user details for the log
                                                                    echo "<small class='text-muted'>Change by: You</small>";
                                                                    ?>
                                                                </p>
                                                            </div>
                                                            <div class="card-footer text-muted">
                                                                <?php echo date('Y-m-d H:i:s', strtotime($activity_row['timestamp'])); ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }

                                            // Function to get the group label for a given timestamp and filter
                                            function get_group_label($timestamp, $filter)
                                            {
                                                switch ($filter) {
                                                    case 'today':
                                                        $today_start = date('Y-m-d 00:00:00');
                                                        $today_end = date('Y-m-d 23:59:59');
                                                        if ($timestamp >= $today_start && $timestamp <= $today_end) {
                                                            return "Today";
                                                        }
                                                        break;
                                                    case 'yesterday':
                                                        $yesterday_start = date('Y-m-d 00:00:00', strtotime('-1 day'));
                                                        $yesterday_end = date('Y-m-d 23:59:59', strtotime('-1 day'));
                                                        if ($timestamp >= $yesterday_start && $timestamp <= $yesterday_end) {
                                                            return "Yesterday";
                                                        }
                                                        break;
                                                    case 'last_week':
                                                        $last_week_start = date('Y-m-d 00:00:00', strtotime('-1 week'));
                                                        $last_week_end = date('Y-m-d 23:59:59');
                                                        if ($timestamp >= $last_week_start && $timestamp <= $last_week_end) {
                                                            return "Last Week";
                                                        }
                                                        break;
                                                }
                                                return "All";
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Side -->
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="h5">
                                            Counts
                                        </div>
                                        <?php
                                        // SQL query to get distinct actions and their counts
                                        $action_count_sql = "SELECT action, COUNT(*) AS log_count FROM activity_logs WHERE member_id = $id GROUP BY action";
                                        $action_count_result = $conn->query($action_count_sql);

                                        // Process the data
                                        $action_counts = array();
                                        if ($action_count_result && $action_count_result->num_rows > 0) {
                                            while ($row = $action_count_result->fetch_assoc()) {
                                                $action_counts[$row['action']] = $row['log_count'];
                                            }
                                        }
                                        ?>
                                        <!-- Display action counts -->
                                        <?php foreach ($action_counts as $action => $count): ?>
                                            <?php if ($action !== 'Update Active' && $action !== 'Update Deactive'): ?>
                                                <div class="h7 text-muted">
                                                    <?php echo $action ?>:
                                                    <input type="text"
                                                        name="<?php echo strtolower(str_replace(' ', '_', $action)) ?>_count"
                                                        value="<?php echo $count ?>" disabled />
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <!-- Ads -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include('./function/footer.php'); ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS - added -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <!-- Simple DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <!-- Your custom scripts -->
    <script src="../../js/scripts.js"></script>
    <script src="./js/script.js"></script>
    <!-- Chart.js demo scripts -->
    <script src="../../assets/demo/chart-area-demo.js"></script>
    <script src="../../assets/demo/chart-bar-demo.js"></script>
    <!-- Simple DataTables demo script -->
    <script src="../../js/datatables-simple-demo.js"></script>

    <!--JS Addition-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"> </script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./js/script.js"></script>
</body>

</html>