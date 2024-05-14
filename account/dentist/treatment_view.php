<?php include ('./function/alert.php'); ?>
<input type="hidden" value="<?php echo $row['user_id']; ?>">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Treatment Plan View - Dentist</title>
    <!-- Datatables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- Custom Stylesheets -->
    <link href="../../css/styles.css" rel="stylesheet" />
    <!--Links -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Tab Swicth -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .tab-content {
            display: none;
            /* Hide tab content initially */
        }

        .tab-content.active {
            display: block;
            /* Show tab content when active */
        }

        /* Treatment Start */
        .project-list>tbody>tr>td {
            padding: 12px 8px;
        }

        .project-list>tbody>tr>td .avatar {
            width: 22px;
            border: 1px solid #CCC;
        }

        /* Treatment End */

        .product-grid-style {
            margin-top: -20px
        }

        img {
            max-width: 100%;
            height: auto;
            vertical-align: top;
        }

        .product-grid-style>[class*="col-"] {
            margin-top: 30px
        }

        .product-grid-style .product-img {
            position: relative
        }

        .product-grid-style .product-img img {
            border-radius: 0.25rem
        }

        .product-grid-style .product-details {
            transition: all .3s ease 0s;
            position: relative
        }

        .product-details .product-cart {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999
        }

        .product-details .product-cart>a {
            width: 40px;
            height: 40px;
            justify-content: center;
            align-items: center;
            display: flex;
            color: #292dc2;
            margin-top: 0;
            margin-right: 10px;
            border-radius: 50%;
            visibility: hidden;
            transition: all 0.5s;
            opacity: 0;
            cursor: pointer;
            background-color: #fff
        }

        .product-details .product-cart a:last-child {
            margin-right: 0
        }

        .product-details .product-cart>a:hover {
            background: #292dc2;
            color: #fff
        }

        .product-details:hover .product-cart a {
            transform: translateY(-30px);
            visibility: visible;
            opacity: 1
        }

        .product-grid-style .product-info {
            padding: 15px;
            float: left;
            width: 100%;
            text-align: center;
            font-size: 18px
        }

        .product-grid-style .product-info>a {
            margin-bottom: 5px;
            display: inline-block;
            font-weight: 600;
            font-size: 15px
        }

        .product-grid-style .price {
            font-weight: 600
        }

        .product-grid-style .price .red {
            color: #878787
        }

        .product-list {
            margin-top: -20px
        }

        .product-list>[class*="col-"] {
            margin-top: 30px
        }

        .product-card {
            border: 1px solid rgba(0, 0, 0, 0.075);
            height: 100%
        }

        .product-card .card-img {
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0
        }

        .product-card .card-body {
            padding: 2rem
        }

        .product-card .card-body .read-more {
            display: block
        }

        .product-card .card-body .read-more a {
            color: #292dc2;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px
        }

        .product-card .card-body .read-more a:hover {
            color: #282b2d
        }

        .product-card .card-footer:last-child {
            border-radius: 0
        }

        .product-card h3 {
            font-size: 18px;
            line-height: 26px;
            margin-bottom: 12px
        }

        .product-card h3 a {
            color: #282b2d
        }

        .product-card h3 a:hover {
            color: #292dc2
        }

        .product-card .card-footer {
            background: none;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 0.8rem 2rem;
            font-weight: 600
        }

        .product-card .card-footer a {
            line-height: normal
        }

        .product-card ul {
            margin-bottom: 0;
            padding-bottom: 0
        }

        .product-card .card-footer img {
            max-width: 35px
        }

        .product-card .card-footer ul li {
            display: inline-block;
            color: #999;
            font-size: 14px;
            font-weight: 500;
            margin: 0 10px 0 0
        }

        .product-card .card-footer ul li i {
            color: #292dc2;
            font-size: 16px;
            font-weight: 500;
            margin-right: 5px
        }

        @media screen and (max-width: 767px) {
            .product-card .card-img.bg-img {
                min-height: 250px
            }
        }

        @media screen and (max-width: 575px) {
            .product-card .card-body {
                padding: 1.5rem
            }
        }

        .product-grid-style .price .red {
            color: #878787;
        }

        .line-through {
            text-decoration: line-through;
        }


        .label-offer {
            position: absolute;
            left: 0;
            top: 0;
            height: 25px;
            line-height: 25px;
            display: inline-block;
            padding: 0px 12px;
            color: #fff;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 12px;
            z-index: 1
        }

        .bg-red {
            background-color: #ed1b24;
        }

        .bg-primary-solid,
        .primary-overlay-solid[data-overlay-dark]:before {
            background: #292dc2;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php
    //Profile show
    $schedule_id = $_GET['id'];
    $main_query = mysqli_query($conn, "select * from schedule where id = ' $schedule_id'") or die(mysqli_error($conn));

    while ($schedule_row = mysqli_fetch_array($main_query)) {
        $id = $schedule_row['id'];
        $timeslot = $schedule_row['timeslot'];
        $member_id = $schedule_row['member_id'];
        $account_id = $schedule_row['user_id'];
        $service_id = $schedule_row['service_id'];
        $treatment_id = $schedule_row['record_id'];
        $question_id = $schedule_row['question_id'];
        $location_id = $schedule_row['location_id'];

        // Timeslot Query
        $timeslot_query = mysqli_query($conn, "select * from timeslot where timeslot = '$timeslot'") or die(mysqli_error($conn));
        $timeslot_row = mysqli_fetch_array($timeslot_query);
        /* member query  */
        $member_query = mysqli_query($conn, "select * from members where member_id = ' $member_id'") or die(mysqli_error($conn));
        $member_row = mysqli_fetch_array($member_query);
        /* account query  */
        $account_query = mysqli_query($conn, "select * from users where user_id = ' $account_id' ") or die(mysqli_error($conn));
        $account_row = mysqli_fetch_array($account_query);
        /* service query  */
        $service_query = mysqli_query($conn, "select * from service where service_id = '$service_id' ") or die(mysqli_error($conn));
        $service_row = mysqli_fetch_array($service_query);
        /* treatment query  */
        $treatment_query = mysqli_query($conn, "select * from record where record_id = '$treatment_id' ") or die(mysqli_error($conn));
        $treatment_row = mysqli_fetch_array($treatment_query);
        /* question query  */
        $question_query = mysqli_query($conn, "select * from survey_responses where question_id = '$question_id' ") or die(mysqli_error($conn));
        $question_row = mysqli_fetch_array($question_query);
        // Location Query
        $location_query = mysqli_query($conn, "select * from location where location_id = '$location_id'") or die(mysqli_error($conn));
        $location_row = mysqli_fetch_array($location_query);
        ?>
        <input type="hidden" name="id" id="id" value="<?php echo $schedule_row['id']; ?>">
        <hr>
        <div class="container">
            <!-- Header -->
            <div class="row">
                <div class="col-sm-10">
                    <h1><i class='bx bx-add-to-queue'></i>Treatment Plan</h1>
                </div>
                <!--Logo-->
                <div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class=" img-responsive"
                            src="../../picture/Dental_Logo_Dashboard.png"></a></div>
            </div>
            <br>
            <!-- Body -->
            <div class="row">
                <!-- Main Body -->
                <div class="col-xl-9">
                    <!-- Message box -->
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
                    <br>
                    <ul class="nav nav-tabs" id="myTab">
                        <li><a onclick="toggleContentMode('information')">Information</a></li>
                        <li><a onclick="toggleContentMode('treatment')">History of Treatment Plan</a></li>
                        <li><a onclick="toggleContentMode('image')">Images</a></li>
                        <li><a onclick="toggleContentMode('history')">History</a></li>
                        <li><a onclick="toggleContentMode('guild')">Guild Answer</a></li>
                    </ul>

                    <main>
                        <!-- Information -->
                        <div id="information" class="tab-content active">
                            <div class="form-group">
                                <!-- Appointment Calendar information -->
                                <div class="card col-xs-12">
                                    <h3><strong>Schedule Appointment</strong></h3>
                                    <div class="card-body">
                                        <div class="col-xs-6">
                                            <label class="form-label">Date</label>
                                            <input type="date" class="form-control"
                                                value="<?php echo $schedule_row['date']; ?>" disabled>
                                        </div>
                                        <div class="col-xs-6">
                                            <?php
                                            // Extracting time start and time end from the database
                                            $time_start = $timeslot_row['time_start'];
                                            $time_end = $timeslot_row['time_end'];

                                            // Converting time to AM/PM format
                                            $time_start_ampm = date("h:i A", strtotime($time_start));
                                            $time_end_ampm = date("h:i A", strtotime($time_end));
                                            ?>
                                            <label class="form-label">Timeslot</label>
                                            <input type="Timeslot" class="form-control"
                                                value="Slot <?php echo $schedule_row['timeslot'] . " (" . $time_start_ampm . " to " . $time_end_ampm ?>)"
                                                disabled>
                                        </div>
                                        <div class="col-xs-12">
                                            <?php if ($schedule_row['status'] == "Done") { ?>
                                                <div class="form-group">
                                                    <label class="form-label">Status</label>
                                                    <input type="text" class="form-control bg-success text-white"
                                                        value="<?php echo $schedule_row['status']; ?>" disabled>
                                                </div>
                                            <?php } else if ($schedule_row['status'] == "Cancelled") { ?>
                                                    <div class="form-group">
                                                        <label class="form-label">Status</label>
                                                        <input type="text" class="form-control bg-danger text-white"
                                                            value="<?php echo $schedule_row['status']; ?>" disabled>
                                                    </div>
                                            <?php } else { ?>
                                                    <label class="form-label">Status</label>
                                                    <input type="text" class="form-control bg-warning text-white"
                                                        value="<?php echo $schedule_row['status']; ?>" disabled>
                                                    <br>
                                                    <div class="row my-4">
                                                        <div class="col">
                                                            <form action="./function/update.php" method="GET">
                                                                <input type="hidden" name="user_id"
                                                                    value="<?php echo $_SESSION['dentist_id']; ?>">
                                                                <input type="hidden" name="id"
                                                                    value="<?php echo $schedule_row['id']; ?>">
                                                                <input type="hidden" name="member_id"
                                                                    value="<?php echo $schedule_row['member_id']; ?>">
                                                                <input type="hidden" name="status" value="Done">
                                                                <button type="submit" class="btn btn-success" name="schedule_Done"
                                                                    onclick="return confirm('are you sure the schedule is Done?')">Appointment
                                                                    Done</button>
                                                            </form>
                                                        </div>
                                                        <div class="col">
                                                            <form action="./function/update.php" method="GET">
                                                                <input type="hidden" name="user_id"
                                                                    value="<?php echo $_SESSION['dentist_id']; ?>">
                                                                <input type="hidden" name="id"
                                                                    value="<?php echo $schedule_row['id']; ?>">
                                                                <input type="hidden" name="member_id"
                                                                    value="<?php echo $schedule_row['member_id']; ?>">
                                                                <input type="hidden" name="status" value="Cancelled">
                                                                <button type="submit" class="btn btn-danger"
                                                                    name="schedule_Cancelled"
                                                                    onclick="return confirm('are you sure the schedule is Cancelled?')">Cancelled</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-xs-6">
                                            <label class="form-label">Location Name</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $location_row['location']; ?>" disabled>
                                        </div>
                                        <div class="col-xs-6">
                                            <label class="form-label">Dentist Name</label>
                                            <input type="text" class="form-control"
                                                value="Dr. <?php echo $account_row['firstname'] . " " . $account_row['lastname']; ?>"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <!-- Dental Chart -->
                                <div class="col-xs-12">
                                    <br>
                                    <?php
                                    if (!empty($user_row['image'])) {
                                        echo '<img src="../../picture/profile/' . $member_row['image'] . '" 
                                                        alt="Admin" class="rounded-circle p-1 bg-primary profile-image">';
                                    } else {
                                        echo '<img src="../../picture/dental_chart/dental_chart.png" class="img-fluid" alt="Responsive image">';
                                    }
                                    ?>
                                    <br><br>
                                </div>
                                <!-- The Treatment Plan -->
                                <div class="card col-xs-12">
                                    <h3><strong>The Problem</strong></h3>
                                    <div>
                                        <div class="table-responsive">
                                            <!-- PROJECT TABLE -->
                                            <table class="table colored-header datatable project-list">
                                                <thead>
                                                    <tr>
                                                        <th>Service Offer</th>
                                                        <th>Teeth Number</th>
                                                        <th>Teeth Side</th>
                                                        <th>Priority</th>
                                                        <th>Status</th>
                                                        <th>Dentist</th>
                                                        <th>Price</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Treatment Plan -->
                                                    <?php if (!empty($schedule_row['record_id'])) { ?>
                                                        <?php
                                                        // Construct the SQL query to select the schedule for the provided member_id
                                                        $record_query = mysqli_query($conn, "SELECT * FROM `record` where `id` = '$schedule_id'") or die(mysqli_error($conn));
                                                        // Check if there are records
                                                        if (mysqli_num_rows($record_query) > 0) {
                                                            while ($record_row = mysqli_fetch_array($record_query)) {
                                                                $record_id = $record_row['record_id'];
                                                                $sale_id = $record_row['sale_id'];
                                                                $service_id = $record_row['service_id'];
                                                                $member_id = $record_row['member_id'];
                                                                $account_id = $record_row['user_id'];
                                                                /* service query  */
                                                                $service_query = mysqli_query($conn, "select * from service where service_id = '$service_id' ") or die(mysqli_error($conn));
                                                                $service01_row = mysqli_fetch_array($service_query);
                                                                // Sale
                                                                $sale_query = mysqli_query($conn, "SELECT * from `sales` WHERE sale_id = '$sale_id' AND status = 'Up'") or die(mysqli_error($conn));
                                                                $sale_row = mysqli_fetch_array($sale_query);
                                                                /* member query  */
                                                                $member_query = mysqli_query($conn, "select * from members where member_id = ' $member_id'") or die(mysqli_error($conn));
                                                                $member01_row = mysqli_fetch_array($member_query);
                                                                /* account query  */
                                                                $account_query = mysqli_query($conn, "select * from users where user_id = ' $account_id' ") or die(mysqli_error($conn));
                                                                $account01_row = mysqli_fetch_array($account_query);
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <a href="#"><?php echo $service01_row['service_offer']; ?></a>
                                                                    </td>
                                                                    <td><?php if ($record_row['teeth_no'] == "1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70") {
                                                                        echo 'All';
                                                                    } else if (!empty($record_row['teeth_side'])) {
                                                                        echo $record_row['teeth_no'];
                                                                    } else {
                                                                        echo 'No Data given';
                                                                    } ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($record_row['teeth_side'] == "Upper Left, Upper Right, Lower Left, Lower Right") {
                                                                            echo 'All Side';
                                                                        } else if (!empty($record_row['teeth_side'])) {
                                                                            echo $record_row['teeth_side'];
                                                                        } else {
                                                                            echo 'No Data given';
                                                                        } ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($record_row['priority'] == "High") { ?>
                                                                            <span class="label label-success">HIGH</span>
                                                                        <?php } else if ($record_row['priority'] == "Mid") { ?>
                                                                                <span class="label label-warning">MIDIUM</span>
                                                                        <?php } else if ($record_row['priority'] == "Low") { ?>
                                                                                    <span class="label label-primary">Low</span>
                                                                        <?php } else { ?>
                                                                                    No Data given
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if (!empty($record_row['done'])) { ?>
                                                                            <span class="label label-success">Done</span>
                                                                        <?php } else { ?>
                                                                            <span class="label label-danger">Not Started</span>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (!empty($account01_row['image'])) {
                                                                            echo '<img src="../../picture/profile/' . $account01_row['image'] . '" 
                                                                            alt="Admin" class="avatar img-circle">';
                                                                        } else {
                                                                            echo '<img src="../../picture/profile/human.png"
                                                                            alt="Admin" class="avatar img-circle" width="110">';
                                                                        } ?>
                                                                        <!-- Account Name -->
                                                                        <a
                                                                            href="#"><?php echo $account01_row['firstname'] . ' ' . $account01_row['lastname']; ?></a>
                                                                    </td>
                                                                    <td style="width: 70px;">
                                                                        <?php
                                                                        if (!empty($sale_row['price_sale'])) { ?>
                                                                            <span>₱
                                                                                <?php echo $sale_row['price_sale']; ?>
                                                                            </span>
                                                                            <br>
                                                                            <span style="color:grey; text-decoration: line-through;">₱
                                                                                <?php echo $service01_row['price']; ?>
                                                                            </span>
                                                                        <?php } else { ?>
                                                                            <span>₱
                                                                                <?php echo $service01_row['price']; ?>
                                                                            </span>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td>
                                                                        <a class="btn btn-primary"
                                                                            href="./treatment_update.php?record_id=<?php echo $record_row['record_id']; ?>">Edit</a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        } else {
                                                            // Display message box if no records found
                                                            echo '<tr><td colspan="8"><div class="alert alert-info">No records found.</div></td></tr>';
                                                        }
                                                        ?>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <td>
                                                                <a href="#"><?php echo $service_row['service_offer']; ?></a>
                                                            </td>
                                                            <td>No Data given</td>
                                                            <td>No Data given</td>
                                                            <td>No Data given</td>
                                                            <td><span class="label label-danger">Not Started</span></td>
                                                            <td>
                                                                <?php
                                                                if (!empty($account_row['image'])) {
                                                                    echo '<img src="../../picture/profile/' . $account_row['image'] . '" 
                                                                    alt="Admin" class="avatar img-circle">';
                                                                } else {
                                                                    echo '<img src="../../picture/profile/human.png"
                                                                    alt="Admin" class="avatar img-circle" width="110">';
                                                                } ?>
                                                                <!-- Account Name -->
                                                                <a
                                                                    href="#"><?php echo $account_row['firstname'] . ' ' . $account_row['lastname']; ?></a>
                                                            </td>
                                                            <td style="width: 70px;">
                                                                <?php
                                                                if (!empty($sale_row['price_sale'])) { ?>
                                                                    <span>₱
                                                                        <?php echo $sale_row['price_sale']; ?>
                                                                    </span>
                                                                    <br>
                                                                    <span style="color:grey; text-decoration: line-through;">₱
                                                                        <?php echo $service_row['price']; ?>
                                                                    </span>
                                                                <?php } else { ?>
                                                                    <span>₱
                                                                        <?php echo $service_row['price']; ?>
                                                                    </span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><!-- Post button with member_id and schedule_id -->
                                                                <form action="./function/add_treatment.php" method="post">
                                                                    <input type="hidden" name="service_id"
                                                                        value="<?php echo $schedule_row['service_id']; ?>">
                                                                    <input type="hidden" name="schedule_id"
                                                                        value="<?php echo $schedule_row['id']; ?>">
                                                                    <?php if (!empty($sale_row['price_sale'])) { ?>
                                                                        <input type="hidden" name="sale_id"
                                                                            value="<?php echo $sale_row['sale_id']; ?>">
                                                                    <?php } ?>
                                                                    <input type="hidden" name="user_id"
                                                                        value="<?php echo $schedule_row['user_id']; ?>">
                                                                    <input type="hidden" name="member_id"
                                                                        value="<?php echo $schedule_row['member_id']; ?>">
                                                                    <button class="btn btn-primary" name="check_treatment"
                                                                        type="submit">Edit</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <!-- Treatment Plan -->
                                                        <?php
                                                        // Construct the SQL query to select the schedule for the provided member_id
                                                        $record_query = mysqli_query($conn, "SELECT * FROM `record` where `id` = '$schedule_id'") or die(mysqli_error($conn));
                                                        while ($record_row = mysqli_fetch_array($record_query)) {

                                                            $record_id = $record_row['record_id'];
                                                            $sale_id = $record_row['sale_id'];
                                                            $service_id = $record_row['service_id'];
                                                            $member_id = $record_row['member_id'];
                                                            $account_id = $record_row['user_id'];
                                                            /* service query  */
                                                            $service_query = mysqli_query($conn, "select * from service where service_id = '$service_id' ") or die(mysqli_error($conn));
                                                            $service01_row = mysqli_fetch_array($service_query);
                                                            // Sale
                                                            $sale_query = mysqli_query($conn, "SELECT * from `sales` WHERE sale_id = '$sale_id' AND status = 'Up'") or die(mysqli_error($conn));
                                                            $sale_row = mysqli_fetch_array($sale_query);
                                                            /* member query  */
                                                            $member_query = mysqli_query($conn, "select * from members where member_id = ' $member_id'") or die(mysqli_error($conn));
                                                            $member01_row = mysqli_fetch_array($member_query);
                                                            /* account query  */
                                                            $account_query = mysqli_query($conn, "select * from users where user_id = ' $account_id' ") or die(mysqli_error($conn));
                                                            $account01_row = mysqli_fetch_array($account_query);
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <a href="#"><?php echo $service01_row['service_offer']; ?></a>
                                                                </td>
                                                                <td><?php if ($record_row['teeth_no'] == "1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70") {
                                                                    echo 'All';
                                                                } else if (!empty($record_row['teeth_side'])) {
                                                                    echo $record_row['teeth_no'];
                                                                } else {
                                                                    echo 'No Data given';
                                                                } ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($record_row['teeth_side'] == "Upper Left, Upper Right, Lower Left, Lower Right") {
                                                                        echo 'All Side';
                                                                    } else if (!empty($record_row['teeth_side'])) {
                                                                        echo $record_row['teeth_side'];
                                                                    } else {
                                                                        echo 'No Data given';
                                                                    } ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($record_row['priority'] == "High") { ?>
                                                                        <span class="label label-success">HIGH</span>
                                                                    <?php } else if ($record_row['priority'] == "Mid") { ?>
                                                                            <span class="label label-warning">MIDIUM</span>
                                                                    <?php } else if ($record_row['priority'] == "Mid") { ?>
                                                                                <span class="label label-primary">Low/span>
                                                                        <?php } else { ?>
                                                                                    No Data given
                                                                        <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <?php if (!empty($record_row['done'])) { ?>
                                                                        <span class="label label-success">Done</span>
                                                                    <?php } else { ?>
                                                                        <span class="label label-danger">Not Started</span>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    if (!empty($account01_row['image'])) {
                                                                        echo '<img src="../../picture/profile/' . $account01_row['image'] . '" 
                                                                    alt="Admin" class="avatar img-circle">';
                                                                    } else {
                                                                        echo '<img src="../../picture/profile/human.png"
                                                                    alt="Admin" class="avatar img-circle" width="110">';
                                                                    } ?>
                                                                    <!-- Account Name -->
                                                                    <a
                                                                        href="#"><?php echo $account01_row['firstname'] . ' ' . $account01_row['lastname']; ?></a>
                                                                </td>
                                                                <td style="width: 70px;">
                                                                    <?php
                                                                    if (!empty($sale_row['price_sale'])) { ?>
                                                                        <span>₱
                                                                            <?php echo $sale_row['price_sale']; ?>
                                                                        </span>
                                                                        <br>
                                                                        <span style="color:grey; text-decoration: line-through;">₱
                                                                            <?php echo $service01_row['price']; ?>
                                                                        </span>
                                                                    <?php } else { ?>
                                                                        <span>₱
                                                                            <?php echo $service01_row['price']; ?>
                                                                        </span>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-primary"
                                                                        href="./treatment_update.php?record_id=<?php echo $record_row['record_id']; ?>">Edit</a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <!-- END PROJECT TABLE -->
                                        </div>
                                    </div>
                                </div>
                                <!--Addition Treatment-->
                                <div class="col-xs-12">
                                    <br><br>
                                    <h3><strong>Addition Treatment</strong></h3>
                                    <?php
                                    if ($schedule_row['status'] == "Done" || $schedule_row['status'] == "Cancelled") {
                                        echo '<div class="alert alert-danger">Unfortunately, this is no longer available due to the current appointment status.</div>';
                                    } else if (!empty($schedule_row['record_id'])) { ?>
                                            <form method="post" action="./function/add.php">
                                                <div class="form-group">
                                                    <!-- Select Service -->
                                                    <label class="control-label">Select Service for this Appointment</label>
                                                    <select name="service_id" class="form-control">
                                                        <?php
                                                        // Fetch available services from the database
                                                        $query = mysqli_query($conn, "SELECT * FROM service WHERE status = 'Available'") or die(mysqli_error($conn));
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            echo '<option value="' . $row['service_id'] . '">' . $row['service_offer'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <!-- Teeth Number and Teeth Side -->
                                                <div class="form-group">
                                                    <!-- Master checkbox to select or deselect all checkboxes -->
                                                    <div>
                                                        <label>
                                                            <input type="checkbox" id="select-all-checkboxes"
                                                                onclick="toggleAllCheckboxes(this)">
                                                            Select All
                                                        </label>
                                                    </div>

                                                    <!-- Input text to display selected checkbox values -->
                                                    <div>
                                                        <label for="selected-teeth">
                                                            Selected Teeth:
                                                        </label>
                                                        <textarea type="text" class="form-control" id="selected-teeth"
                                                            readonly></textarea>
                                                    </div>

                                                    <!-- Input text to display classified selected teeth -->
                                                    <div>
                                                        <label for="classified-teeth">
                                                            Classified Selected Teeth:
                                                        </label>
                                                        <textarea type="text" class="form-control" id="classified-teeth"
                                                            readonly></textarea>
                                                    </div>

                                                    <!-- Hidden inputs to pass selected and classified teeth data in the form -->
                                                    <input type="hidden" id="hidden-selected-teeth" name="hidden_selected_teeth" />
                                                    <input type="hidden" id="hidden-classified-teeth"
                                                        name="hidden_classified_teeth" />
                                                    <br>
                                                    <table id="TeethNumber" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="3">Permanent Teeth Numbers</th>
                                                                <th colspan="3">Not Permanent Teeth</th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th>Upper Left</th>
                                                                <th>Upper Right</th>
                                                                <th></th>
                                                                <th>Upper Left</th>
                                                                <th>Upper Right</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1-8</td>
                                                                <td>
                                                                    <?php
                                                                    // Loop through each tooth number for upper left 1-8
                                                                    for ($i = 1; $i <= 8; $i++) {
                                                                        echo '<div class="checkbox">';
                                                                        echo '<label>';
                                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                                        echo 'Tooth ' . $i;
                                                                        echo '</label>';
                                                                        echo '</div>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    // Loop through each tooth number for upper right 9-16
                                                                    for ($i = 9; $i <= 16; $i++) {
                                                                        echo '<div class="checkbox">';
                                                                        echo '<label>';
                                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                                        echo 'Tooth ' . $i;
                                                                        echo '</label>';
                                                                        echo '</div>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>51-55</td>
                                                                <td>
                                                                    <?php
                                                                    // Loop through each tooth number for upper left not permanent teeth 51-55
                                                                    for ($i = 51; $i <= 55; $i++) {
                                                                        echo '<div class="checkbox">';
                                                                        echo '<label>';
                                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                                        echo 'Tooth ' . $i;
                                                                        echo '</label>';
                                                                        echo '</div>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    // Loop through each tooth number for upper right not permanent teeth 56-60
                                                                    for ($i = 56; $i <= 60; $i++) {
                                                                        echo '<div class="checkbox">';
                                                                        echo '<label>';
                                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                                        echo 'Tooth ' . $i;
                                                                        echo '</label>';
                                                                        echo '</div>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>17-24</td>
                                                                <td>
                                                                    <?php
                                                                    // Loop through each tooth number for lower left 17-24
                                                                    for ($i = 17; $i <= 24; $i++) {
                                                                        echo '<div class="checkbox">';
                                                                        echo '<label>';
                                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                                        echo 'Tooth ' . $i;
                                                                        echo '</label>';
                                                                        echo '</div>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    // Loop through each tooth number for lower right 25-32
                                                                    for ($i = 25; $i <= 32; $i++) {
                                                                        echo '<div class="checkbox">';
                                                                        echo '<label>';
                                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                                        echo 'Tooth ' . $i;
                                                                        echo '</label>';
                                                                        echo '</div>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>61-65</td>
                                                                <td>
                                                                    <?php
                                                                    // Loop through each tooth number for lower left not permanent teeth 61-65
                                                                    for ($i = 61; $i <= 65; $i++) {
                                                                        echo '<div class="checkbox">';
                                                                        echo '<label>';
                                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                                        echo 'Tooth ' . $i;
                                                                        echo '</label>';
                                                                        echo '</div>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    // Loop through each tooth number for lower right not permanent teeth 66-70
                                                                    for ($i = 66; $i <= 70; $i++) {
                                                                        echo '<div class="checkbox">';
                                                                        echo '<label>';
                                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                                        echo 'Tooth ' . $i;
                                                                        echo '</label>';
                                                                        echo '</div>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <script>
                                                    // JavaScript function to toggle all checkboxes
                                                    function toggleAllCheckboxes(masterCheckbox) {
                                                        const checkboxes = document.querySelectorAll('input[name="teeth_number[]"]');
                                                        const isChecked = masterCheckbox.checked;
                                                        for (const checkbox of checkboxes) {
                                                            checkbox.checked = isChecked;
                                                        }
                                                        updateSelectedTeeth();
                                                    }

                                                    // JavaScript function to update the input text with selected checkboxes and classify them
                                                    function updateSelectedTeeth() {
                                                        const selectedTeeth = [];
                                                        const categories = {
                                                            upperLeft: false,
                                                            upperRight: false,
                                                            lowerLeft: false,
                                                            lowerRight: false,
                                                        };
                                                        const checkboxes = document.querySelectorAll('input[name="teeth_number[]"]:checked');

                                                        for (const checkbox of checkboxes) {
                                                            selectedTeeth.push(checkbox.value);

                                                            // Classify the tooth based on its value
                                                            const toothNumber = parseInt(checkbox.value, 10);
                                                            if (toothNumber >= 1 && toothNumber <= 8) {
                                                                categories.upperLeft = true;
                                                            } else if (toothNumber >= 9 && toothNumber <= 16) {
                                                                categories.upperRight = true;
                                                            } else if (toothNumber >= 17 && toothNumber <= 24) {
                                                                categories.lowerLeft = true;
                                                            } else if (toothNumber >= 25 && toothNumber <= 32) {
                                                                categories.lowerRight = true;
                                                            } else if (toothNumber >= 51 && toothNumber <= 55) {
                                                                categories.upperLeft = true;
                                                            } else if (toothNumber >= 56 && toothNumber <= 60) {
                                                                categories.upperRight = true;
                                                            } else if (toothNumber >= 61 && toothNumber <= 65) {
                                                                categories.lowerLeft = true;
                                                            } else if (toothNumber >= 66 && toothNumber <= 70) {
                                                                categories.lowerRight = true;
                                                            }
                                                        }

                                                        // Update the input text element with the selected teeth values
                                                        const selectedTeethInput = document.getElementById('selected-teeth');
                                                        selectedTeethInput.value = selectedTeeth.join(', ');

                                                        // Update the hidden input with the selected teeth values for form submission
                                                        const hiddenSelectedTeeth = document.getElementById('hidden-selected-teeth');
                                                        hiddenSelectedTeeth.value = selectedTeeth.join(', ');

                                                        // Classify and update the classified teeth based on categories
                                                        const classifiedTeeth = [];
                                                        if (categories.upperLeft) {
                                                            classifiedTeeth.push("Upper Left");
                                                        }
                                                        if (categories.upperRight) {
                                                            classifiedTeeth.push("Upper Right");
                                                        }
                                                        if (categories.lowerLeft) {
                                                            classifiedTeeth.push("Lower Left");
                                                        }
                                                        if (categories.lowerRight) {
                                                            classifiedTeeth.push("Lower Right");
                                                        }

                                                        const classifiedTeethInput = document.getElementById('classified-teeth');
                                                        classifiedTeethInput.value = classifiedTeeth.join(', ');

                                                        // Update the hidden input with the classified teeth values for form submission
                                                        const hiddenClassifiedTeeth = document.getElementById('hidden-classified-teeth');
                                                        hiddenClassifiedTeeth.value = classifiedTeeth.join(', ');

                                                        // Update the state of the "Select All" checkbox based on the state of individual checkboxes
                                                        const allCheckboxes = document.querySelectorAll('input[name="teeth_number[]"]');
                                                        const selectAllCheckbox = document.getElementById('select-all-checkboxes');
                                                        const allChecked = Array.from(allCheckboxes).every(checkbox => checkbox.checked);
                                                        selectAllCheckbox.checked = allChecked;
                                                    }
                                                </script>

                                                <!--Priority -->
                                                <div class="form-group">
                                                    <label for="priority">Priority</label>
                                                    <select class="form-control" id="priority" name="priority">
                                                        <option value="High">HIGH</option>
                                                        <option value="Mid">MID</option>
                                                        <option value="Low">LOW</option>
                                                    </select>
                                                </div>

                                                <!-- Hidden Fields -->
                                                <input type="hidden" name="id" id="id" value="<?php echo $schedule_row['id']; ?>">
                                                <input type="hidden" name="user_id" id="user_id"
                                                    value="<?php echo $schedule_row['user_id']; ?>">
                                                <input type="hidden" name="member_id" id="member_id"
                                                    value="<?php echo $schedule_row['member_id']; ?>">

                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-success"
                                                    name="additional_treatment">Submit</button>
                                            </form>
                                        <?php
                                    } else {
                                        echo '<div class="alert alert-primary">No Data Available</div>';
                                    } ?>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                        <!-- History of Treatment Plan -->
                        <div id="treatment" class="tab-content">
                            <div class="col-xs-12">
                                <h3><strong>History of Treatment Plan</strong></h3>
                                <div>
                                    <div class="table-responsive">
                                        <!-- PROJECT TABLE -->
                                        <table class="table colored-header datatable project-list">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Service Offer</th>
                                                    <th>Teeth Number</th>
                                                    <th>Dentist</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Treatment Plan -->
                                                <?php
                                                $teeth_numbers = array(); // Initialize an empty array to store teeth numbers
                                            
                                                // Construct the SQL query to select the schedule for the provided member_id
                                                $service_done_query = mysqli_query($conn, "SELECT * FROM `service_done`") or die(mysqli_error($conn));
                                                while ($service_done_row = mysqli_fetch_array($service_done_query)) {

                                                    $service_done_id = $service_done_row['done_id'];
                                                    $service_id = $service_done_row['service_id'];
                                                    $sale_id = $service_done_row['sale_id'];
                                                    $schedule01_id = $service_done_row['id'];
                                                    $account_id = $service_done_row['user_id'];
                                                    /* service query  */
                                                    $service_query = mysqli_query($conn, "SELECT * FROM service WHERE service_id = '$service_id' ") or die(mysqli_error($conn));
                                                    $service01_row = mysqli_fetch_array($service_query);
                                                    // Sale
                                                    $sale_query = mysqli_query($conn, "SELECT * FROM `sales` WHERE sale_id = '$sale_id' AND status = 'Up'") or die(mysqli_error($conn));
                                                    $sale_row = mysqli_fetch_array($sale_query);
                                                    // Date
                                                    $schedule01_query = mysqli_query($conn, "SELECT * FROM `schedule` WHERE id = '$schedule01_id '") or die(mysqli_error($conn));
                                                    $schedule01_row = mysqli_fetch_array($schedule01_query);
                                                    /* account query  */
                                                    $account_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$account_id' ") or die(mysqli_error($conn));
                                                    $account01_row = mysqli_fetch_array($account_query);
                                                    if ($service_done_row['member_id'] == $member_id) {
                                                        // Store teeth numbers in the array
                                                        $teeth_numbers[] = $service_done_row['teeth_no'];
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $schedule01_row['date']; ?></td>
                                                            <td><a href="#"><?php echo $service01_row['service_offer']; ?></a></td>
                                                            <td><?php echo $service_done_row['teeth_no']; ?></td>
                                                            <td>
                                                                <?php
                                                                if (!empty($account01_row['image'])) {
                                                                    echo '<img src="../../picture/profile/' . $account01_row['image'] . '" alt="Admin" class="avatar img-circle">';
                                                                } else {
                                                                    echo '<img src="../../picture/profile/human.png" alt="Admin" class="avatar img-circle" width="110">';
                                                                }
                                                                ?>
                                                                <a href="#">
                                                                    <?php echo $account01_row['firstname'] . ' ' . $account01_row['lastname']; ?>
                                                                </a>
                                                            </td>
                                                            <td style="width: 70px;">
                                                                <?php if (!empty($sale_row['price_sale'])) { ?>
                                                                    <span>₱<?php echo $sale_row['price_sale']; ?></span>
                                                                    <br>
                                                                    <span
                                                                        style="color:grey; text-decoration: line-through;">₱<?php echo $service01_row['price']; ?></span>
                                                                <?php } else { ?>
                                                                    <span>₱<?php echo $service01_row['price']; ?></span>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } else {
                                                        echo '<div class="alert alert-danger">No Data Available</div>';
                                                    }
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                        <!-- END PROJECT TABLE -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Image -->
                        <div id="image" class="tab-content">
                            <div>
                                <h3>Image for Treatment Plan</h3>
                                <br> <br>
                                <div class="row">
                                    <div class="container">
                                        <div class="row justify-content-center product-grid-style">
                                            <div class="row justify-content-center product-grid-style">
                                                <?php
                                                // Fetch images from the database
                                                $image_query = "SELECT * FROM `images` WHERE `member_id` = '$member_id'";
                                                $image_result = mysqli_query($conn, $image_query);

                                                // Check if images are fetched successfully
                                                if (mysqli_num_rows($image_result) > 0) {
                                                    // If there are images, iterate through them
                                                    $count = 0;
                                                    while ($image_row = mysqli_fetch_assoc($image_result)) {
                                                        ?>
                                                        <div class="col-11 col-sm-6 col-lg-4 col-xl-3">
                                                            <div class="product-details">
                                                                <div class="product-img">
                                                                    <?php if (!empty($image_row['image'])) { ?>
                                                                        <img src="../../picture/treatment/<?php echo $image_row['image']; ?>"
                                                                            alt="..." style="width:250px;  height:180px;">
                                                                    <?php } else { ?>
                                                                        <img src="./picture/service/dental.jpg" alt="...">
                                                                    <?php } ?>
                                                                </div>

                                                                <div class="product-cart">
                                                                    <a href="#!"><i class="fa-solid fa fa-eye"></i></a>
                                                                    <!-- <a href="#!"><i class="fas fa-cart-plus"></i></a> -->
                                                                    <!-- <a href="#!"><i class="fas fa-heart"></i></a> -->
                                                                </div>

                                                                <div class="product-info">
                                                                    <a href="#!">
                                                                        <?php echo $image_row['image_title']; ?>
                                                                    </a>
                                                                    <p class="price text-center m-0 ">
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $count++;
                                                        // Add a clearfix every third image
                                                        if ($count % 3 == 0) {
                                                            echo '<div class="clearfix visible-xs-block visible-sm-block visible-md-block visible-lg-block"></div>';
                                                        }
                                                    }
                                                } else { ?>
                                                    <!-- If no images are found -->
                                                    <br><br>
                                                    <div class="alert alert-primary" role="alert">
                                                        No images found!
                                                    </div>
                                                <?php }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- / .row -->
                            </div>
                        </div>
                        <!-- History/ Activity Log -->
                        <div id="history" class="tab-content">
                            <h2>Activity Log</h2>
                            <!-- activity log -->
                            <div class="col-md-12 offset-md">
                                <?php
                                $id = $_GET['id'];
                                // Assuming $conn is your database connection object
                                $stmt = $conn->prepare("SELECT * FROM activity_logs WHERE id = ? ORDER BY timestamp DESC");
                                $stmt->bind_param("i", $id);

                                // Execute the prepared statement
                                $stmt->execute();

                                // Get the result
                                $result = $stmt->get_result();

                                // Handle the result
                                if ($result->num_rows > 0) {
                                    while ($activity_row = $result->fetch_assoc()) {
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
                                                    <?php echo "<small class='text-muted'>Change by: Someone</small>"; ?>
                                                </p>
                                            </div>
                                            <div class="card-footer text-muted">
                                                <?php echo date('Y-m-d H:i:s', strtotime($activity_row['timestamp'])); ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo "<div class='alert alert-secondary' role='alert'>No activity logs found.</div>";
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Guild Answer -->
                        <div id="guild" class="tab-content">
                            <H3>Guild Answer Content</H3>
                        </div>
                    </main>
                </div>
                <!--Side body-->
                <div class="col-xl-3">
                    <br>
                    <!-- Basic Information -->
                    <div class="card">
                        <br>
                        <!--Profile-->
                        <div class="text-center">
                            <?php
                            if (!empty($member_row['image'])) {
                                echo '<img src="../../picture/profile/' . $member_row['image'] . '" 
                                                        alt="Admin" class="rounded-circle p-1 bg-primary profile-image">';
                            } else {
                                echo '<img src="../../picture/profile/human.png"
                                                        alt="Admin" class="rounded-circle p-1 bg-primary profile-image" width="110">';
                            }
                            ?>
                            <h3 class="card-title">
                                <?php echo $member_row['firstname'] . ' ' . $member_row['lastname']; ?>
                            </h3>
                            <h4 class="card-subtitle mb-2 text-muted"><?php echo $member_row['username']; ?></h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" value="<?php echo $member_row['address']; ?>"
                                        disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" value="<?php echo $member_row['email']; ?>"
                                        disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Contact Num</label>
                                    <input type="text" class="form-control" value="<?php echo $member_row['contact_no']; ?>"
                                        disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Age</label>
                                    <input type="text" class="form-control"
                                        value="<?php echo $member_row['age']; ?> years old" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Birthday</label>
                                    <input type="date" class="form-control" value="<?php echo $member_row['birthday']; ?>"
                                        disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gender</label>
                                    <input type="text" class="form-control" value="<?php echo $member_row['gender']; ?>"
                                        disabled>
                                </div>
                            </form>
                            <!-- Profile link -->
                            <a class="btn btn-primary"
                                href="./contact_client_view.php?member_id=<?php echo $member_row['member_id']; ?>">
                                <!-- profile -->
                                Profile
                            </a>
                            <!-- Schedule View -->
                            <a class="btn btn-secondary" href="./schedule_view.php?id=<?php echo $schedule_row['id']; ?>">
                                <!-- Schedule View -->
                                Schedule View
                            </a>
                        </div>
                    </div>
                    <br>
                    <!-- Requriment -->
                    <div class="card">
                        <h4><strong>Requirement</strong></h4>
                        <div class="card-body">
                            <?php if ($service_row['imaging_tests'] == "yes") {
                                $service02_query = mysqli_query($conn, "SELECT * from service WHERE service_offer = 'Imaging Tests'") or die(mysqli_error($conn));
                                $service02_row = mysqli_fetch_array($service02_query);
                                if ($service02_row['service_offer'] == "Imaging Tests") {
                                    if ($service02_row['status'] == "Available") { ?>
                                        <div class="card">
                                            <div class="card-body">
                                                <form method="post" action="./function/add.php">
                                                    <input type="hidden" name="service_id"
                                                        value="<?php echo $service02_row['service_id']; ?>">
                                                    <input type="hidden" name="id" value="<?php echo $schedule_row['id']; ?>">
                                                    <input type="hidden" name="user_id" value="<?php echo $user_row['user_id']; ?>">
                                                    <input type="hidden" name="member_id"
                                                        value="<?php echo $member_row['member_id']; ?>">
                                                    <p>Select an Additional Service for <button type="submit" class="btn btn-primary"
                                                            name="add_imaging_tests">Imaging Tests</button>
                                                    </p>
                                                </form>
                                                <p class="text-center fw-bold mx-3 mb-0">Or</p>
                                                <form class="form" action="./function/add_image.php" method="post"
                                                    enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <input type="hidden" id="image_title" name="image_title" value="Imaging Tests">
                                                        <label for="description">Description:</label><br>
                                                        <textarea id="description" name="description" class="form-control"
                                                            placeholder="Add Description if needed"></textarea><br>
                                                        <label for="image">Select Image for Imaging Tests:</label>
                                                        <input type="file" id="image" class="form-control" name="image">

                                                        <input type="hidden" name="id" value="<?php echo $schedule_row['id']; ?>">
                                                        <input type="hidden" name="user_id" value="<?php echo $user_row['user_id']; ?>">
                                                        <input type="hidden" name="member_id" id="member_id"
                                                            value="<?php echo $member_row['member_id']; ?>">
                                                        <br>
                                                        <button type="submit" class="btn btn-success"
                                                            name="image_upload_treatment">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="alert alert-primary" role="alert"> Imaging Tests is not available.
                                                </div>
                                                <form class="form" action="./function/add_image.php" method="post"
                                                    enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <input type="hidden" id="image_title" name="image_title" value="Imaging Tests">
                                                        <label for="description">Description:</label><br>
                                                        <textarea id="description" name="description" class="form-control"
                                                            placeholder="Add Description if needed"></textarea><br>
                                                        <label for="image">Select Image for Imaging Tests:</label>
                                                        <input type="file" id="image" class="form-control" name="image">

                                                        <input type="hidden" name="id" value="<?php echo $schedule_row['id']; ?>">
                                                        <input type="hidden" name="user_id" value="<?php echo $user_row['user_id']; ?>">
                                                        <input type="hidden" name="member_id" id="member_id"
                                                            value="<?php echo $member_row['member_id']; ?>">
                                                        <br>
                                                        <button type="submit" class="btn btn-success"
                                                            name="image_upload_treatment">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="alert alert-danger" role="alert">
                                                Imaging Tests is not listed in Service Offers
                                            </div>
                                            <form class="form" action="./function/add_image.php" method="post"
                                                enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <input type="hidden" id="image_title" name="image_title" value="Imaging Tests">
                                                    <label for="description">Description:</label><br>
                                                    <textarea id="description" name="description" class="form-control"
                                                        placeholder="Add Description if needed"></textarea><br>
                                                    <label for="image">Select Image for Imaging Tests:</label>
                                                    <input type="file" id="image" class="form-control" name="image">

                                                    <input type="hidden" name="id" value="<?php echo $schedule_row['id']; ?>">
                                                    <input type="hidden" name="user_id" value="<?php echo $user_row['user_id']; ?>">
                                                    <input type="hidden" name="member_id" id="member_id"
                                                        value="<?php echo $member_row['member_id']; ?>">
                                                    <br>
                                                    <button type="submit" class="btn btn-success"
                                                        name="image_upload_treatment">Update Treatment Image</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<div class="alert alert-primary" role="alert">
                                    No Imaging Tests Required
                                  </div>';
                            } ?>

                            <?php
                            if ($service_row['x_ray'] == "yes") {
                                $service01_query = mysqli_query($conn, "select * from service WHERE service_offer = 'X-Ray'") or die(mysqli_error($conn));
                                $service01_row = mysqli_fetch_array($service01_query);

                                if ($service01_row['service_offer'] == "X-Ray") {
                                    if ($service01_row['status'] == "Available") {
                                        ?>
                                        <div class="card">
                                            <div class="card-body">
                                                <form method="post" action="./function/add.php">
                                                    <input type="hidden" name="service_id"
                                                        value="<?php echo $service01_row['service_id']; ?>">
                                                    <input type="hidden" name="id" value="<?php echo $schedule_row['id']; ?>">
                                                    <input type="hidden" name="user_id" value="<?php echo $user_row['user_id']; ?>">
                                                    <input type="hidden" name="member_id"
                                                        value="<?php echo $member_row['member_id']; ?>">
                                                    <p>Select an Additional Service for <button type="submit" class="btn btn-primary"
                                                            name="add_x_ray">X-Ray</button>
                                                    </p>
                                                </form>
                                                <p class="text-center fw-bold mx-3 mb-0">Or</p>
                                                <form class="form" action="./function/add_image.php" method="post"
                                                    enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <input type="hidden" id="image_title" name="image_title" value="X-Ray">
                                                        <label for="description">Description:</label><br>
                                                        <textarea id="description" name="description" class="form-control"
                                                            placeholder="Add Description if needed"></textarea><br>
                                                        <label for="image">Select Image for X-Ray:</label>
                                                        <input type="file" id="image" class="form-control" name="image">

                                                        <input type="hidden" name="id" value="<?php echo $schedule_row['id']; ?>">
                                                        <input type="hidden" name="user_id" value="<?php echo $user_row['user_id']; ?>">
                                                        <input type="hidden" name="member_id" id="member_id"
                                                            value="<?php echo $member_row['member_id']; ?>">
                                                        <br>
                                                        <button type="submit" class="btn btn-success"
                                                            name="image_upload_treatment">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="alert alert-danger" role="alert"> X Ray is not available.
                                                </div>
                                                <form class="form" action="./function/add_image.php" method="post"
                                                    enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <input type="hidden" id="image_title" name="image_title" value="X-Ray">
                                                        <label for="description">Description:</label><br>
                                                        <textarea id="description" name="description" class="form-control"
                                                            placeholder="Add Description if needed"></textarea><br>
                                                        <label for="image">Select Image for X-Ray:</label>
                                                        <input type="file" id="image" class="form-control" name="image">

                                                        <input type="hidden" name="id" value="<?php echo $schedule_row['id']; ?>">
                                                        <input type="hidden" name="user_id" value="<?php echo $user_row['user_id']; ?>">
                                                        <input type="hidden" name="member_id" id="member_id"
                                                            value="<?php echo $member_row['member_id']; ?>">
                                                        <br>
                                                        <button type="submit" class="btn btn-success"
                                                            name="image_upload_treatment">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="alert alert-danger" role="alert">
                                                X Ray is not listed in Service Offers
                                            </div>
                                            <form class="form" action="./function/add_image.php" method="post"
                                                enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <input type="hidden" id="image_title" name="image_title" value="X-Ray">
                                                    <label for="description">Description:</label><br>
                                                    <textarea id="description" name="description" class="form-control"
                                                        placeholder="Add Description if needed"></textarea><br>
                                                    <label for="image">Select Image for X-Ray:</label>
                                                    <input type="file" id="image" class="form-control" name="image">

                                                    <input type="hidden" name="id" value="<?php echo $schedule_row['id']; ?>">
                                                    <input type="hidden" name="user_id" value="<?php echo $user_row['user_id']; ?>">
                                                    <input type="hidden" name="member_id" id="member_id"
                                                        value="<?php echo $member_row['member_id']; ?>">
                                                    <br>
                                                    <button type="submit" class="btn btn-success"
                                                        name="image_upload_treatment">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="alert alert-primary" role="alert">
                                    No X-Ray Required
                                </div>
                                <?php
                            }
                            ?>

                            <?php if ($service_row['consent'] == "yes") { ?>
                                <div class="card">
                                    <div class="card-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="consent_small">Consent</label>
                                                <input type="file" class="form-control" id="consent_small"
                                                    aria-describedby="consent_small" placeholder="Enter Imaging Tests">
                                                <small id="consent_small" class="form-text text-muted">
                                                    you can Download <a href="./function/print/consent_form.php">Consent
                                                        Form</a>
                                                </small>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php } else {
                                echo '<div class="alert alert-primary" role="alert">
                                    No Consent Required
                                  </div>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../../js/datatables-simple-demo.js"></script>

    <!--JS Addition-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"> </script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./js/script.js"></script>
    <!-- Tab Swicth -->
    <script>
        function toggleContentMode(tabName) {
            // Hide all tab contents
            var tabContents = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove('active');
            }

            // Show the selected tab content
            var selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
            }
        }

        function toggleTabContent() {
            var tabContents = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.toggle('active');
            }
        }
    </script>

</body>

</html>