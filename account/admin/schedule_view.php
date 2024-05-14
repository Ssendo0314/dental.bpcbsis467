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
    <title>Appointment History - Dentist</title>

    <style>
        body {
            margin-top: 20px;
            background-color: #f1f3f7;
        }

        .card {
            margin-bottom: 24px;
            -webkit-box-shadow: 0 2px 3px #e4e8f0;
            box-shadow: 0 2px 3px #e4e8f0;
        }

        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #eff0f2;
            border-radius: 1rem;
        }

        .activity-checkout {
            list-style: none
        }

        .activity-checkout .checkout-icon {
            position: absolute;
            top: -4px;
            left: -24px
        }

        .activity-checkout .checkout-item {
            position: relative;
            padding-bottom: 24px;
            padding-left: 35px;
            border-left: 2px solid #f5f6f8
        }

        .activity-checkout .checkout-item:first-child {
            border-color: #3b76e1
        }

        .activity-checkout .checkout-item:first-child:after {
            background-color: #3b76e1
        }

        .activity-checkout .checkout-item:last-child {
            border-color: transparent
        }

        .activity-checkout .checkout-item.crypto-activity {
            margin-left: 50px
        }

        .activity-checkout .checkout-item .crypto-date {
            position: absolute;
            top: 3px;
            left: -65px
        }



        .avatar-xs {
            height: 1rem;
            width: 1rem
        }

        .avatar-sm {
            height: 2rem;
            width: 2rem
        }

        .avatar {
            height: 3rem;
            width: 3rem
        }

        .avatar-md {
            height: 4rem;
            width: 4rem
        }

        .avatar-lg {
            height: 5rem;
            width: 5rem
        }

        .avatar-xl {
            height: 6rem;
            width: 6rem
        }

        .avatar-title {
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            background-color: #3b76e1;
            color: #fff;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            font-weight: 500;
            height: 100%;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 100%
        }

        .avatar-group {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding-left: 8px
        }

        .avatar-group .avatar-group-item {
            margin-left: -8px;
            border: 2px solid #fff;
            border-radius: 50%;
            -webkit-transition: all .2s;
            transition: all .2s
        }

        .avatar-group .avatar-group-item:hover {
            position: relative;
            -webkit-transform: translateY(-2px);
            transform: translateY(-2px)
        }

        .card-radio {
            background-color: #fff;
            border: 2px solid #eff0f2;
            border-radius: .75rem;
            padding: .5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block
        }

        .card-radio:hover {
            cursor: pointer
        }

        .card-radio-label {
            display: block
        }

        .edit-btn {
            width: 35px;
            height: 35px;
            line-height: 40px;
            text-align: center;
            position: absolute;
            right: 25px;
            margin-top: -50px
        }

        .card-radio-input {
            display: none
        }

        .card-radio-input:checked+.card-radio {
            border-color: #3b76e1 !important
        }


        .font-size-16 {
            font-size: 16px !important;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        a {
            text-decoration: none !important;
        }


        .form-control {
            display: block;
            width: 100%;
            padding: 0.47rem 0.75rem;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #545965;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #e2e5e8;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.75rem;
            -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        }

        .edit-btn {
            width: 35px;
            height: 35px;
            line-height: 40px;
            text-align: center;
            position: absolute;
            right: 25px;
            margin-top: -50px;
        }

        .ribbon {
            position: absolute;
            right: -26px;
            top: 20px;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            padding: 1px 22px;
            font-size: 13px;
            font-weight: 500
        }
    </style>

</head>

<body class="sb-nav-fixed">
    <?php
    $schedule_id = $_GET['id'];
    $schedule_query = mysqli_query($conn, "SELECT * FROM schedule where `id` = $schedule_id") or die(mysqli_error($conn));
    while ($schedule_row = mysqli_fetch_array($schedule_query)) {
        $id = $schedule_row['id'];
        $timeslot = $schedule_row['timeslot'];
        $member_id = $schedule_row['member_id'];
        $user_id = $schedule_row['user_id'];
        $service_id = $schedule_row['service_id'];
        $location_id = $schedule_row['location_id'];

        $timeslot_query = mysqli_query($conn, "select * from timeslot where timeslot = '$timeslot'") or die(mysqli_error($conn));
        $timeslot_row = mysqli_fetch_array($timeslot_query);
        $member_query = mysqli_query($conn, "select * from members where member_id = '$member_id'") or die(mysqli_error($conn));
        $member_row = mysqli_fetch_array($member_query);
        $user_query = mysqli_query($conn, "select * from users where user_id = ' $user_id ' ") or die(mysqli_error($conn));
        $user_row = mysqli_fetch_array($user_query);
        $service_query = mysqli_query($conn, "select * from service where service_id = '$service_id' ") or die(mysqli_error($conn));
        $service_row = mysqli_fetch_array($service_query);
        $location_query = mysqli_query($conn, "select * from location where location_id = '$location_id'") or die(mysqli_error($conn));
        $location_row = mysqli_fetch_array($location_query);
        ?>
        <div class="container">
            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        onclick="window.location.href ='schedule_view.php'"><span aria-hidden="true"><i
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
                        onclick="window.location.href ='schedule_view.php'"><span aria-hidden="true"><i
                                class='bx bx-x-circle'></i></span></button>
                    <?php echo $_SESSION['failed']; ?>
                </div>
                <?php
                unset($_SESSION['failed']);
            } ?>
            <!--space-->
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        onclick="window.location.href ='schedule_view.php'"><span aria-hidden="true"><i
                                class='bx bx-x-circle'></i></span></button>
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php
                unset($_SESSION['message']);
            } ?>
            <!--space-->
            <?php if (isset($_SESSION['image'])) { ?>
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        onclick="window.location.href ='schedule_view.php'"><span aria-hidden="true"><i
                                class='bx bx-x-circle'></i></span></button>
                    <?php echo $_SESSION['image']; ?>
                </div>
                <?php
                unset($_SESSION['image']);
            } ?>
            <div class="row">
                <!-- Appointment -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <ol class="activity-checkout mb-0 px-4 mt-3">
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-receipt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Appointment Information</h5>
                                            <p class="text-muted text-truncate mb-4">Details About your Appointment</p>
                                            <div class="mb-3">
                                                <form>
                                                    <div class="form-group">
                                                        <label class="form-label">Full Name</label>
                                                        <input type="text" class="form-control"
                                                            value="<?php echo $member_row['firstname'] . " " . $member_row['lastname']; ?>"
                                                            disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Date</label>
                                                        <input type="date" class="form-control"
                                                            value="<?php echo $schedule_row['date']; ?>" disabled>
                                                    </div>
                                                    <?php
                                                    // Extracting time start and time end from the database
                                                    $time_start = $timeslot_row['time_start'];
                                                    $time_end = $timeslot_row['time_end'];

                                                    // Converting time to AM/PM format
                                                    $time_start_ampm = date("h:i A", strtotime($time_start));
                                                    $time_end_ampm = date("h:i A", strtotime($time_end));
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="form-label">Timeslot</label>
                                                        <input type="Timeslot" class="form-control"
                                                            value="Slot <?php echo $schedule_row['timeslot'] . " (" . $time_start_ampm . " to " . $time_end_ampm ?>)"
                                                            disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Location Name</label>
                                                        <input type="text" class="form-control"
                                                            value="<?php echo $location_row['location']; ?>" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Dentist Name</label>
                                                        <input type="text" class="form-control"
                                                            value="Dr. <?php echo $user_row['firstname'] . " " . $user_row['lastname']; ?>"
                                                            disabled>
                                                    </div>
                                                    <br>
                                                    <?php if ($schedule_row['status'] == "Proccess" || $schedule_row['status'] == "Waiting") { ?>
                                                        <div class="form-group">
                                                            <a
                                                                href="./function/print/schedule_info.php?id=<?php echo $schedule_row['id']; ?>"><button
                                                                    type="button" class="btn btn-secondary"><i
                                                                        class='bx bx-printer'></i>
                                                                    Print
                                                                    The
                                                                    Information</button></a>
                                                        </div>
                                                    <?php } ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-truck text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Status Info</h5>
                                            <form>
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
                                                        <div class="form-group">
                                                            <label class="form-label">Status</label>
                                                            <input type="text" class="form-control bg-warning text-white"
                                                                value="<?php echo $schedule_row['status']; ?>" disabled>
                                                            <br>
                                                        </div>
                                                <?php } ?>
                                            </form>
                                            <?php if (!empty($schedule_row['note'])) { ?>
                                                <div class="form-group">
                                                    <label class="form-label">Note</label>
                                                    <input type="text" class="form-control"
                                                        value="<?php echo $schedule_row['note']; ?>" disabled>
                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group">
                                                    <label class="form-label">Note</label>
                                                    <input type="text" class="form-control" value="No Note Found" disabled>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </li>
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class='bx bxs-star text-white font-size-20'></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Review</h5>
                                            <?php if ($schedule_row['status'] == "Done") { ?>
                                                <?php $review_query = mysqli_query($conn, "SELECT * FROM `testimony` WHERE id = $id LIMIT 1") or die(mysqli_error($conn));
                                                while ($review_row = mysqli_fetch_array($review_query)) {
                                                    if ($review_row['id'] == $id) { ?>
                                                        <br><br>
                                                        <div class="alert alert-primary" role="alert">
                                                            <br>
                                                            <p>If you want to check the list of review</p>
                                                        </div>
                                                    <?php } else { ?>
                                                        <br><br>
                                                        <div class="alert alert-primary" role="alert">
                                                            Not ready of Review
                                                        </div>
                                                    <?php }
                                                } ?>
                                            <?php } else if ($schedule_row['status'] == "Cancelled") { ?>
                                                    <br><br>
                                                    <div class="alert alert-danger" role="alert">
                                                        Sorry Review is not available
                                                    </div>
                                            <?php } else { ?>
                                                    <br><br>
                                                    <div class="alert alert-primary" role="alert">
                                                        Not ready of Review
                                                    </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col">
                            <a href="./dashboard.php" class="btn btn-link text-muted"> Back </a>
                        </div><!-- end col -->
                    </div> <!-- end row-->
                </div>
                <!-- Side-->
                <div class="col-xl-5">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Service Offer</label>
                                    <input type="text" class="form-control" aria-describedby="emailHelp"
                                        value="<?php echo $service_row['service_offer']; ?>" disabled>
                                </div>
                                <br>
                                <?php
                                if ($schedule_row['status'] == "Proccess" || $schedule_row['status'] == "Waiting") { ?>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Addition Service</label>
                                        <?php if (!empty($schedule_row['record_id'])) { ?>
                                            <div class="card">
                                                <div class="card-body">
                                                    <?php
                                                    // Construct the SQL query to select the schedule for the provided member_id
                                                    $record_query = mysqli_query($conn, "SELECT * FROM `record` where `id` = '$schedule_id' AND member_id = '$member_id'") or die(mysqli_error($conn));
                                                    while ($record_row = mysqli_fetch_array($record_query)) {
                                                        $service_id = $record_row['service_id'];
                                                        $sale_id = $record_row['sale_id'];
                                                        /* service query  */
                                                        $service_query = mysqli_query($conn, "select * from service where service_id = '$service_id' ") or die(mysqli_error($conn));
                                                        $service03_row = mysqli_fetch_array($service_query);
                                                        // Sale
                                                        $sale_query = mysqli_query($conn, "SELECT * from `sales` WHERE sale_id = '$sale_id' AND status = 'Up'") or die(mysqli_error($conn));
                                                        $sale_row = mysqli_fetch_array($sale_query);
                                                        ?>
                                                        <div class="row">
                                                            <div class="row">
                                                                <div class="col-8 col-sm-8">
                                                                    <strong><?php echo $service03_row['service_offer']; ?></strong>
                                                                </div>
                                                                <div class="col-4 col-sm-3">
                                                                    <?php
                                                                    if (!empty($sale_row['price_sale'])) { ?>
                                                                        <span>₱
                                                                            <?php echo $sale_row['price_sale']; ?>
                                                                        </span>
                                                                        <br>
                                                                        <span style="color:grey; text-decoration: line-through;">₱
                                                                            <?php echo $service03_row['price']; ?>
                                                                        </span>
                                                                    <?php } else { ?>
                                                                        <span>₱
                                                                            <?php echo $service03_row['price']; ?>
                                                                        </span>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <br><br>
                                            <div class="alert alert-primary" role="alert">
                                                No Addition Service
                                            </div>
                                        <?php }
                                } ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($schedule_row['status'] == "Done") { ?>
                            <!-- Sale -->
                            <div class="card checkout-order-summary">
                                <div class="card-body">
                                    <div class="p-3 bg-light mb-3">
                                        <h5 class="font-size-16 mb-0">Order Summary
                                        </h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 table-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0" scope="col">Product Desc</th>
                                                    <th class="border-top-0 text-center" scope="col">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $record_query = mysqli_query($conn, "SELECT * FROM `service_done` where `id` = '$schedule_id' AND member_id = '$member_id'") or die(mysqli_error($conn));
                                                while ($record_row = mysqli_fetch_array($record_query)) {
                                                    $service_id = $record_row['service_id'];
                                                    $sale_id = $record_row['sale_id'];
                                                    /* service query  */
                                                    $service_query = mysqli_query($conn, "select * from service where service_id = '$service_id' ") or die(mysqli_error($conn));
                                                    $service04_row = mysqli_fetch_array($service_query);
                                                    // Sale
                                                    $sale_query = mysqli_query($conn, "SELECT * from `sales` WHERE sale_id = '$sale_id' AND status = 'Up'") or die(mysqli_error($conn));
                                                    $sale_row = mysqli_fetch_array($sale_query);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <h6 class="font-size-12 text-truncate"><a href="#"
                                                                    class="text-dark"><?php echo $service04_row['service_offer']; ?></a>
                                                            </h6>
                                                            <!-- <p class="text-muted mb-0 mt-1">$ 260 x 2</p> -->
                                                        </td>
                                                        <td class="text-end">
                                                            <?php
                                                            if (!empty($sale_row['price_sale'])) { ?>
                                                                <span>₱
                                                                    <?php echo $sale_row['price_sale']; ?>
                                                                </span>
                                                                <br>
                                                                <span style="text-decoration: line-through;">₱
                                                                    <?php echo $service04_row['price']; ?>
                                                                </span>
                                                            <?php } else { ?>
                                                                <span>₱
                                                                    <?php echo $service_row['price']; ?>
                                                                </span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        <?php } else if ($schedule_row['status'] == "Waiting" || $schedule_row['status'] == "Process") { ?>
                                <div class="alert alert-warning" role="alert">
                                    Waiting for the Schedule to be done.
                                </div>
                        <?php } else { ?>
                                <div class="alert alert-danger" role="alert">
                                    The Schedule is no longer available
                                </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        </div>

    <?php } ?>
    <!-- Footer -->
    <?php include ('./function/footer.php'); ?>

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