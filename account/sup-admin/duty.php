<?php
// Include the database connection file if not included already
include ('./function/alert.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Duty Board - Owner</title>
    <!-- CSS LINK -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <!--Online Icon Design;-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css"
        integrity="sha512-LX0YV/MWBEn2dwXCYgQHrpa9HJkwB+S+bnBpifSOTO1No27TqNMKYoAn6ff2FBh03THAzAiiCwQ+aPX+/Qt/Ow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .duty-box {
            border: 1px solid #000;
            padding: 5px;
            margin: 5px;
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
                $location_id = $_GET['location_id'];
                $list_query = "SELECT * FROM `location` WHERE location_id='$location_id'";
                $result = mysqli_query($conn, $list_query);
                while ($main_row = mysqli_fetch_array($result)) { ?>
                    <br>
                    <div class="container-fluid px-4">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item">My Dental</li>
                            <li class="breadcrumb-item"><a href="./shop.php">Dentist Office</a></li>
                            <li class="breadcrumb-item active"><a
                                    href="./duty.php?user_id=<?php echo $main_row['location_id']; ?>">Dentist Office - List
                                    of Duty</a></li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-body pb-0">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="text-center border-end">
                                                    <h4 class="text-primary font-size-20 mt-3 mb-2">
                                                        <?php echo $main_row['location']; ?>
                                                    </h4>
                                                    <h5 class="text-muted font-size-13 mb-0">Dental Office</h5>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-md-9">
                                                <div class="ms-3">
                                                    <div>
                                                        <h4 class="card-title mb-2">Biography</h4>
                                                        <p class="mb-0 text-muted">
                                                            <?php if (!empty($main_row['about'])) { ?>
                                                                <?php echo $main_row['about']; ?>
                                                            <?php } else { ?>
                                                                No Biography available
                                                            <?php } ?>
                                                        </p>
                                                    </div>
                                                    <div class="row my-4">
                                                        <div class="col-md-12">
                                                            <div>
                                                                <?php if (!empty($main_row['email'])) { ?>
                                                                    <p class="text-muted mb-2 fw-medium"><i
                                                                            class="mdi mdi-email-outline me-2"></i>
                                                                        <?php echo $main_row['email']; ?>
                                                                    </p>
                                                                <?php } else { ?>
                                                                    <p class="text-muted mb-2 fw-medium"><i
                                                                            class="mdi mdi-email-outline me-2"></i>
                                                                        No Email available
                                                                    </p>
                                                                <?php } ?>
                                                                <?php if (!empty($main_row['contact_no'])) { ?>
                                                                    <p class="text-muted fw-medium mb-0"><i
                                                                            class="mdi mdi-phone-in-talk-outline me-2"></i>
                                                                        <?php echo $main_row['contact_no']; ?>
                                                                    </p>
                                                                <?php } else { ?>
                                                                    <p class="text-muted fw-medium mb-0"><i
                                                                            class="mdi mdi-phone-in-talk-outline me-2"></i>
                                                                        No Contact Number available
                                                                    </p>
                                                                <?php } ?>
                                                            </div>
                                                        </div><!-- end col -->
                                                    </div><!-- end row -->

                                                    <ul class="nav nav-tabs nav-tabs-custom border-bottom-0 mt-3 nav-justfied"
                                                        role="tablist">
                                                        <li role="presentation">
                                                            <!--Add Duty-->
                                                            <!-- <a href="./function/add_duty.php?location_id=<?php //echo $main_row['location_id']; ?>"
                                                                class="btn  btn-primary text-white" onclick="openForm()"><i
                                                                    class='bx bx-add-to-queue'></i>
                                                                Add Duty</a> -->
                                                            <!-- Edit Information of Shop -->
                                                            <a href="./function/edit_location.php?location_id=<?php echo $main_row['location_id']; ?>"
                                                                class="btn btn-primary text-white">
                                                                Edit the Information</a>
                                                            <!-- Content for the right section -->
                                                            <button class="btn btn-outline-secondary"
                                                                onclick="toggleContentMode('Team')"> Team </button>
                                                            <button class="btn btn-outline-secondary"
                                                                onclick="toggleContentMode('Duty')">Duty</button>
                                                            <!-- <button class="btn btn-outline-secondary"
                                                                onclick="toggleContentMode('Service')">Service</button> -->
                                                        </li><!-- end li -->
                                                    </ul><!-- end ul -->
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                                <br>
                                <div class="card">
                                        <div class="tab-content p-4">
                                            <div id="contentTeam">
                                                <h4><strong>Team</strong></h4>
                                                <div class="card-header">
                                                    <i class="fas fa-table me-1"></i> DataTable for List Duty
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-bordered table-hover dt-responsive"
                                                        id="datatablesSimple">
                                                        <thead>
                                                            <tr>
                                                                <th>Account</th>
                                                                <th>Duty Day</th>
                                                                <th>duty start time</th>
                                                                <th>duty end time</th>
                                                                <th>Role</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Account</th>
                                                                <th>Duty Day</th>
                                                                <th>duty start time</th>
                                                                <th>duty end time</th>
                                                                <th>Role</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <?php
                                                            $duty_query = "SELECT * FROM `duty` WHERE `location_id` = '{$main_row['location_id']}'";
                                                            $duty_result = mysqli_query($conn, $duty_query);
                                                            //while statement
                                                            while ($duty_row = mysqli_fetch_array($duty_result)) {
                                                                $account_id = $duty_row['user_id'];
                                                                /* account query  */
                                                                $account_query = mysqli_query($conn, "select * from users where user_id = ' $account_id' ") or die(mysqli_error($conn));
                                                                $account_row = mysqli_fetch_array($account_query);

                                                                // Display time slot in AM/PM format
                                                                $time_start = $duty_row['duty_start_time'];
                                                                $time_end = $duty_row['duty_end_time'];
                                                                $time_start_ampm = date("h:i A", strtotime($time_start));
                                                                $time_end_ampm = date("h:i A", strtotime($time_end));
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $account_row['firstname'] . ' ' . $account_row['lastname']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $duty_row['duty_day']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $time_start_ampm; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $time_end_ampm; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $account_row['role']; ?>
                                                                    </td>
                                                                    <td width="auto">
                                                                        <a
                                                                            href="./contact_dentist_view.php?user_id=<?php echo $account_row['user_id']; ?>">
                                                                            <button class="btn  btn-primary text-white"
                                                                                type="submit" name="shop_view">View</button>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div id="contentDuty" style="display: none;">
                                                <h3><strong>Duty</strong></h3>
                                                <div>
                                                    <br>
                                                    <?php

                                                    // Define the start date (assuming the current week)
                                                    $start_date = date('Y-m-d', strtotime('monday this week'));

                                                    // Define office hours
                                                    $office_hours_start = 9; // 9:00 AM
                                                    $office_hours_end = 17; // 5:00 PM
                                            
                                                    // Generate the table headers for Monday to Sunday
                                                    echo "<div class='table-responsive'>";
                                                    echo "<table class='table'>";
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
                                                            $sql = "SELECT * FROM duty WHERE (duty_day = '$current_day' OR duty_day LIKE '%$current_day%') AND duty_start_time <= '$hour:00:00' AND duty_end_time > '$hour:00:00' AND location_id = '{$main_row['location_id']}'";
                                                            $result = $conn->query($sql);

                                                            if ($result->num_rows > 0) {
                                                                // Output data of each row
                                                                $duty_info = "";
                                                                while ($duty01_row = $result->fetch_assoc()) {
                                                                    $account_id = $duty01_row['user_id'];
                                                                    /* account query  */
                                                                    $account_query = mysqli_query($conn, "select * from users where user_id = '$account_id' ") or die(mysqli_error($conn));
                                                                    $account_row = mysqli_fetch_array($account_query);

                                                                    // Display time slot in AM/PM format
                                                                    $time_start = $duty01_row['duty_start_time'];
                                                                    $time_end = $duty01_row['duty_end_time'];
                                                                    $time_start_ampm = date("h:i A", strtotime($time_start));
                                                                    $time_end_ampm = date("h:i A", strtotime($time_end));

                                                                    $duty_info .= "<div class='duty-box'>";
                                                                    $duty_info .= "<div class='text-success'>Account: " . $account_row["firstname"] . "</div><br>";
                                                                    $duty_info .= "Role: " . $account_row["role"] . "<br>";
                                                                    $duty_info .= "</div>";
                                                                }
                                                                echo "<td class='p-1'>$duty_info</td>";
                                                            } else {
                                                                echo "<td></td>";
                                                            }
                                                        }
                                                        echo "</tr>";
                                                    }

                                                    echo "</tbody>";
                                                    echo "</table></div>";

                                                    // Close database connection
                                                    //$conn->close();
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card -->
                            </div><!-- end col -->
                            <!-- side -->
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="pb-2">
                                            <h4 class="card-title mb-3">Activity Count in
                                                <?php echo $main_row['location']; ?>
                                            </h4>
                                            <ul class="list-group">
                                                <?php
                                                // Check if location_id is set
                                                if (isset($main_row['location_id'])) {
                                                    // SQL query to get distinct actions and their counts
                                                    $location_id = $main_row['location_id'];
                                                    $action_count_sql = "SELECT status, COUNT(*) AS log_count FROM schedule WHERE `location_id` = ? GROUP BY status";

                                                    // Prepare and bind the statement
                                                    $stmt = $conn->prepare($action_count_sql);
                                                    $stmt->bind_param("i", $location_id);
                                                    $stmt->execute();
                                                    $action_count_result = $stmt->get_result();

                                                    // Process the data
                                                    $action_counts = array();
                                                    if ($action_count_result && $action_count_result->num_rows > 0) {
                                                        while ($action_count_row = $action_count_result->fetch_assoc()) {
                                                            $action_counts[$action_count_row['status']] = $action_count_row['log_count'];
                                                        }
                                                    }
                                                }
                                                ?>
                                                <?php foreach ($action_counts as $action => $count): ?>
                                                    <?php if ($action !== 'Update Active' && $action !== 'Update Deactive'): ?>
                                                        <li
                                                            class="test-dark list-group-item d-flex justify-content-between align-items-center">
                                                            <?php echo $action ?>
                                                            <span class="test-dark"><strong>
                                                                    <?php echo $count ?>
                                                                </strong></span>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div><!-- end cardbody -->
                                </div><!-- end card -->
                                <br>
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <h4 class="card-title mb-4">Details</h4>
                                            <div class="table-responsive">
                                                <table class="table table-bordered mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Batch Name:</th>
                                                            <td>
                                                                <?php echo $main_row['location']; ?>
                                                            </td>
                                                        </tr><!-- end tr -->
                                                        <tr>
                                                            <th scope="row">Location:</th>
                                                            <td>
                                                                <?php if (!empty($main_row['map'])) { ?>
                                                                    <a href="<?php echo htmlspecialchars($main_row['map_link']); ?>"
                                                                        target="_blank" class="text-muted">
                                                                        <?php echo htmlspecialchars($main_row['map']); ?>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <p class="text-muted fw-medium mb-0">
                                                                        No Map available
                                                                    </p>
                                                                <?php } ?>
                                                            </td>
                                                        </tr><!-- end tr -->
                                                    </tbody><!-- end tbody -->
                                                </table><!-- end table -->
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div>
                    </div>
                <?php } ?>
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


    <script>
        function toggleContentMode(mode) {
            var sections = document.querySelectorAll('[id^="content"]');
            sections.forEach(function (section) {
                if (section.id === "content" + mode) {
                    section.style.display = "block";
                    section.classList.add("active");
                } else {
                    section.style.display = "none";
                    section.classList.remove("active");
                }
            });
        }
    </script>


</body>

</html>