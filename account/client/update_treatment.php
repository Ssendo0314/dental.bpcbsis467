<?php include ('./function/alert.php'); ?>

<!-- Upload treatment -->


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

        /**
 * Portfolio
 */
        /* Portfolio navigation */
        .portfolio__nav {
            list-style: none;
            padding-left: 0;
            margin-bottom: 40px;
            margin-top: -20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .portfolio__nav>li {
            display: inline-block;
        }

        .portfolio__nav>li>a {
            display: block;
            padding: 20px 10px;
            margin-bottom: -1px;
            border-bottom: 2px solid transparent;
            color: #757575;
            -webkit-transition: all .05s linear;
            -o-transition: all .05s linear;
            transition: all .05s linear;
        }

        .portfolio__nav>li>a:hover,
        .portfolio__nav>li>a:focus {
            color: #333333;
            text-decoration: none;
        }

        .portfolio__nav>li.active>a {
            color: #ed3e49;
            border-bottom-color: #ed3e49;
        }

        @media (max-width: 767px) {
            .portfolio__nav {
                border-bottom: 0;
            }

            .portfolio__nav>li {
                display: block;
            }

            .portfolio__nav>li>a {
                padding: 10px 15px;
                margin-bottom: 10px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }

            .portfolio__nav>li.active>a {
                font-weight: 600;
            }
        }

        /* Portfolio thumbnails */
        .isotope-item {
            padding-left: 10px;
            padding-right: 10px;
        }

        /* Firefox bug fix */
        @media (min-width: 1200px) {
            .col-lg-4.isotope-item {
                width: 33%;
            }
        }

        .portfolio__item {
            margin-bottom: 20px;
        }

        .portfolio-item__img {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .portfolio-item__img:hover .portfolio-item__mask {
            background: rgba(255, 255, 255, 0.9);
        }

        .portfolio-item__img:hover .portfolio-item-mask__content {
            top: 0;
        }

        .portfolio-item__mask {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0);
            -webkit-transition: background .3s;
            -o-transition: background .3s;
            transition: background .3s;
        }

        @media (max-width: 767px) {
            .portfolio-item__mask {
                visibility: hidden;
            }
        }

        .portfolio-item-mask__content {
            position: absolute;
            display: block;
            top: -100%;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 40px 20px;
            overflow: hidden;
            color: #333333;
            text-decoration: none;
            -webkit-transition: top .3s;
            -o-transition: top .3s;
            transition: top .3s;
        }

        .portfolio-item-mask__title {
            margin-bottom: 20px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .portfolio-item-mask__summary {
            font-size: 12px;
        }

        .portfolio-item__recent>[class*="col-"] {
            padding-left: 10px;
            padding-right: 10px;
        }

        .tab-pane {
            padding-top: 20px;
        }

        .panel-body>ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .panel-body>ul>li {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .panel-body>ul>li>a {
            display: block;
            padding: 8px 0;
            font-weight: 600;
            font-size: 11px;
            color: #777777;
            text-transform: uppercase;
            text-decoration: none;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <input type="hidden" value="<?php echo $row['member_id']; ?>">
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
    <!--space-->
    <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                onclick="window.location.href ='dashboard.php'"><span aria-hidden="true"><i
                        class='bx bx-x-circle'></i></span></button>
            <?php echo $_SESSION['message']; ?>
        </div>
        <?php
        unset($_SESSION['message']);
    } ?>
    <?php
    //Profile show
    $id = $_GET['id'];
    $main_query = mysqli_query($conn, "select * from schedule where id = '$id'") or die(mysqli_error($conn));

    while ($schedule_row = mysqli_fetch_array($main_query)) {
        $schedule_id = $schedule_row['id'];
        $member_id = $schedule_row['member_id'];
        $account_id = $schedule_row['user_id'];
        $service_id = $schedule_row['service_id'];
        $treatment_id = $schedule_row['record_id'];
        $question_id = $schedule_row['question_id'];
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

        ?>
        <input type="hidden" name="id" id="id" value="<?php echo $schedule_row['id']; ?>">
        <div class="container bootstrap snippet">
            <div class="row">
                <div class="col-sm-10">
                    <h1><i class='bx bx-add-to-queue'></i>Appointment Infromation</h1>
                </div>
                <!--Logo-->
                <div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class=" img-responsive"
                            src="../../picture/Dental_Logo_Dashboard.png"></a></div>
            </div>
            <div class="row">
                <div class="col-sm-3"><!--left col-->
                    <!--Profile-->
                    <div class="text-center">
                        <?php
                        if (!empty($member_row['image'])) {
                            echo '<img class="card-img-top" src="../../picture/profile/' . $member_row['image'] . '" class="avatar img-circle img-thumbnail" alt="Cinque Terre" style="width: 10rem;">';
                        } else {
                            echo '<img class="card-img-top" src="../../picture/profile/human.png" class="avatar img-circle img-thumbnail" alt="Default Image" style="width: 10rem;">';
                        }
                        ?>
                    </div>
                    </hr><br>
                    <!--Basic Information-->
                    <div class="panel panel-default">
                        <div class="panel-heading">Basic Information<i class="fa fa-link fa-1x"></i></div>
                        <div class="panel-body">
                            <p>
                                <label for="username">Username:</label>
                                <?php echo $member_row['username']; ?>
                            </p>
                            <p>
                                <label for="firstname">First Name:</label>
                                <?php echo $member_row['firstname']; ?>
                            </p>
                            <p>
                                <label for="lastname">Last Name:</label>
                                <?php echo $member_row['lastname']; ?>
                            </p>
                            <p>
                                <label for="address">Address:</label>
                                <?php echo $member_row['address']; ?>
                            </p>
                            <p>
                                <label for="email">Email:</label>
                                <?php echo $member_row['email']; ?>
                            </p>
                            <p>
                                <label for="ContactNum">Contact Num:</label>
                                <?php echo $member_row['contact_no']; ?>
                            </p>
                            <p>
                                <label for="age">Age:</label>
                                <?php echo $member_row['age']; ?> years old
                            </p>
                            <p>
                                <label for="gender">Gender:</label>
                                <?php echo $member_row['gender']; ?>
                            </p>
                            <br>
                            <a class="link"
                                href="./contact_client_view.php?member_id=<?php echo $member_row['member_id']; ?>">
                                <!-- profile -->
                                Profile
                            </a>
                        </div>
                    </div>
                </div><!--/col-3-->
                <div class="col-sm-9">
                    <ul class="nav nav-tabs" id="myTab">
                        <li><a onclick="toggleContentMode('home')">Information</a></li>
                    </ul>

                    <main>
                        <!-- Information -->
                        <div id="information" class="tab-content active">
                            <hr>
                            <div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label for="problem_label">
                                            <h4>Problem</h4>
                                        </label>
                                        <?php if (isset($treatment_row['problem']) && $treatment_row['problem']) { ?>
                                            <input type="text" class="form-control" name="problem" id="problem"
                                                value="<?php echo $treatment_row['problem']; ?>" disabled>
                                        <?php } else { ?>
                                            <input type="text" class="form-control bg-secondary text-white"
                                                value="Sorry! No Problem under the Treament Plan found." disabled>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label for="record_label">
                                            <h4>Accepted Treatment Solution</h4><!--Record-->
                                        </label>
                                        <?php if (isset($treatment_row['record']) && $treatment_row['record']) { ?>
                                            <input type="text" class="form-control" name="record" id="record"
                                                value="<?php echo $treatment_row['record']; ?>" disabled>
                                        <?php } else { ?>
                                            <input type="text" class="form-control bg-secondary text-white"
                                                value="Sorry! No Solution under the Treament Plan found." disabled>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="record_label">
                                            <h4>Ideal Service</h4>
                                        </label>
                                        <?php if (!empty($treatment_row['ideal_service'])) { ?>
                                            <input type="text" class="form-control" name="ideal_service" id="ideal_service"
                                                value="<?php echo $treatment_row['ideal_service']; ?>" disabled>
                                        <?php } else { ?>
                                            <input type="text" class="form-control bg-secondary text-white"
                                                value="Sorry! No Ideal Service under the Treament Plan found." disabled>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="service_id">
                                            <h4>Accepted Treatment</h4><!--Service offer -->
                                        </label>
                                        <input type="text" class="form-control" name="service_offer" id="service_offer"
                                            value="<?php echo $service_row['service_offer']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="date_label">
                                            <h4>Date</h4>
                                        </label>
                                        <input type="date" class="form-control" name="date" id="date"
                                            value="<?php echo $schedule_row['date']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="status_label">
                                            <h4>Status</h4>
                                        </label>
                                        <?php if ($schedule_row['status'] == 'Waiting') { ?>
                                            <input type="text" class="form-control bg-warning text-white" name="status"
                                                id="status" value="<?php echo $schedule_row['status']; ?>" disabled>
                                        <?php } else if ($schedule_row['status'] == 'Done') { ?>
                                                <input type="text" class="form-control bg-success text-white" name="status"
                                                    id="status" value="<?php echo $schedule_row['status']; ?>" disabled>
                                        <?php } else if ($schedule_row['status'] == 'Cancelled') { ?>
                                                    <input type="text" class="form-control bg-danger text-white" name="status"
                                                        id="status" value="<?php echo $schedule_row['status']; ?>" disabled>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label for="date_label">
                                            <h4>Notes</h4>
                                        </label>
                                        <input type="text" class="form-control" name="note" id="note"
                                            value="<?php echo $schedule_row['note']; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 box">
                                    <form class="form" action="./function/update.php" method="post"
                                        enctype="multipart/form-data">
                                        <label for="image_label">
                                            <h4>Image</h4>
                                        </label>
                                        <br>
                                        <div class="card w-80 border border border-dark">
                                            <div class="card-body">
                                                <div class="border border-primary bg-light">
                                                    <h5 class="card-title text-center">Upload Image Here</h5>
                                                    <p class="card-text text-center">Please make sure this photo need.</p>
                                                    <input type="file" name="image">
                                                    <br>
                                                </div>
                                                <br>
                                                <label for="date_label">
                                                    <h4>Title</h4>
                                                </label>
                                                <input type="text" class="form-control" name="image_title" id="image_title"
                                                    placeholder="Please input the Title">
                                                <br>
                                                <label for="date_label">
                                                    <h4>Description</h4>
                                                </label>
                                                <input type="text" class="form-control" name="description" id="description"
                                                    placeholder="Please input the Description">
                                                <br>
                                                <input type="text" name="schedule_id" id="schedule_id"
                                                    value="<?php echo $schedule_row['id']; ?>">
                                                <input type="text" name="record_id" id="record_id"
                                                    value="<?php echo $schedule_row['record_id']; ?>">
                                                <input type="text" name="member_id" id="member_id"
                                                    value="<?php echo $member_row['member_id']; ?>">
                                                <button type="submit" class="btn btn-success"
                                                    name="image_upload_treatment">Update Treatment Image</button>
                                            </div>
                                        </div>
                                        <br><br>
                                    </form>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <br>
                                    <?php if ($schedule_row['status'] == 'Waiting') { ?>
                                        <form action="./function/update.php" method="GET">
                                            <input type="hidden" name="id" value="<?php echo $schedule_row['id']; ?>">
                                            <input type="hidden" name="member_id"
                                                value="<?php echo $schedule_row['member_id']; ?>">
                                            <input type="hidden" name="status" value="Cancelled">
                                            <button type="submit" class="btn btn-lg btn-danger" name="schedule_Cancelled"
                                                onclick="return confirm('are you sure the schedule is Cancelled?')">Cancelled</button>
                                            <a class="btn btn-lg link" href="javascript:history.back()">Back</a>
                                        <?php } else { ?>
                                            <a class="btn btn-lg link" href="javascript:history.back()">Back</a>
                                        <?php } ?>
                                </div>
                            </div>
                            </form>
                        </div>
                    </main>
                </div>
            <?php } ?>


            <?php include ('./function/footer.php'); ?>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
                crossorigin="anonymous"></script>
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