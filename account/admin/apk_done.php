<?php include('./function/alert.php'); ?>
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
    <title>Appointment History - Dentist</title>
</head>

<body class="sb-nav-fixed">
    <!--Top Navbar-->
    <?php include('./function/navbar.php'); ?>
    <div id="layoutSidenav">
        <!--Nav Sidebar-->
        <?php include('./function/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Completed Apointment</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item">My Pages</li>
                        <li class="breadcrumb-item">My Reports</li>
                        <li class="breadcrumb-item active">Completed Apointment</li>
                    </ol>
                    <!--Message-->
                    <?php if (isset($_SESSION['success'])) { ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                onclick="window.location.href ='done.php'"><span aria-hidden="true"><i
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
                                onclick="window.location.href ='done.php'"><span aria-hidden="true"><i
                                        class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['failed']; ?>
                        </div>
                        <?php
                        unset($_SESSION['failed']);
                    } ?>
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
                            <a class="btn btn-primary text-white" href="./function/print/history.php"><i
                                    class='bx bxs-printer'></i> Print All</a>
                            <a class="btn btn-dark text-white" href="./function/download/history.php"><i
                                    class='bx bxs-download'></i> Download All</a>
                        </div>
                    </div>
                    <!--Table-->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable for List Appointment
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
                                        <th>Account Status</th>
                                        <th>Dentist Duty</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php $schdule_query = mysqli_query($conn, "select * from schedule WHERE `location_id` = '{$row['location_id']}'") or die(mysqli_error($conn));
                                    while ($schdule_row = mysqli_fetch_array($schdule_query)) {
                                        $id = $schdule_row['id'];
                                        $timeslot = $schdule_row['timeslot'];
                                        $member_id = $schdule_row['member_id'];
                                        $account_id = $schdule_row['user_id'];
                                        $service_id = $schdule_row['service_id'];

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
                                        if ($schdule_row['status'] == 'Done') {
                                            ?>
                                            <tr>
                                                <td>
                                                    <!--NAME-->
                                                    <?php echo $member_row['firstname'] . " " . $member_row['lastname']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $schdule_row['date']; ?>
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
                                                    <?php if ($schdule_row['status'] == "Done") { ?>
                                                        <button class="btn btn-success" disabled>Appointment Done</button>
                                                    <?php } else if ($schdule_row['status'] == "Waiting") { ?>
                                                            <button class="btn btn-warning" disabled>Pending</button>
                                                    <?php } else if ($schdule_row['status'] == "Cancelled") { ?>
                                                                <button class="btn btn-danger" disabled>Cancelled</button>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($member_row['status'] == "active") { ?>
                                                        <form action="./function/update.php" method="GET">
                                                            <input type="hidden" name="user_id"
                                                                value="<?php echo $_SESSION['admin_id']; ?>">
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
                                                                    value="<?php echo $_SESSION['admin_id']; ?>">
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
                                                        href="./schedule_view.php?id=<?php echo $schdule_row['id']; ?>"
                                                        name="schedule_view"><i class='bx bxs-info-circle'></i>
                                                        View</a>
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
            <?php include('./function/footer.php'); ?>
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