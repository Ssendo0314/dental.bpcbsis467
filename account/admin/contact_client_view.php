<?php include ('./function/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- Datatables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- Custom Stylesheets -->
    <link href="../../css/styles.css" rel="stylesheet" />
    <link href="../../css/profile.css" rel="stylesheet" />
    <title>Contact Client Account - Admin</title>
    <!-- Font Awesome Icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- BoxIcons -->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <title>Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styling */
        .top-image {
            height: 300px;
            /* Adjust height as needed */
            background-image: url('../../picture/Background.png');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Adjust opacity as needed */
        }

        .profile-image {
            width: 110px;
            height: 110px;
            object-fit: cover;
            /* Maintain aspect ratio */
        }

        /**
     * Portfolio
     */

        .profile-image-portfolio {
            width: 210px;
            height: 210px;
            object-fit: cover;
        }

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
        @media (min-width: 200px) {
            .col-lg-4.isotope-item {
                width: 23%;
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

        @media (max-width: 67px) {
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
    <!--Top Navbar-->
    <?php include ('./function/navbar.php'); ?>
    <div id="layoutSidenav">
        <!--Nav Sidebar-->
        <?php include ('./function/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <?php
                //Profile show
                $id = $_GET['member_id'];
                $list_query = "SELECT * FROM `members` WHERE member_id='$id'";
                $result = mysqli_query($conn, $list_query);
                while ($member_row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="container-fluid px-4">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="top-image">
                                        <div class="overlay"></div>
                                        <ol class="breadcrumb mb-4">
                                            <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item">Account</li>
                                            <li class="breadcrumb-item"><a href="./contact_client.php">Client Account</a>
                                            </li>
                                            <li class="breadcrumb-item active">Contact Client View</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="main-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <?php
                                                    if (!empty($member_row['image'])) {
                                                        echo '<img src="../../picture/profile/' . $member_row['image'] . '" 
                                                        alt="Admin" class="rounded-circle p-1 bg-primary profile-image">';
                                                    } else {
                                                        echo '<img src="../../picture/profile/human.png"
                                                        alt="Admin" class="rounded-circle p-1 bg-primary profile-image" width="110">';
                                                    }
                                                    ?>
                                                    <div class="mt-3">
                                                        <h4>
                                                            <?php echo $member_row['firstname'] . ' ' . $member_row['lastname'] . ' ' . $member_row['suffixname']; ?>
                                                        </h4>
                                                        <p class="text-secondary mb-1">
                                                            <?php echo $member_row['username']; ?>
                                                        </p>
                                                        <p class="text-muted font-size-sm">
                                                            <strong>
                                                                <?php echo $member_row['role']; ?>
                                                            </strong>
                                                        </p>
                                                        <p class="text-muted font-size-sm">
                                                            <?php
                                                            if (!empty($member_row['bio'])) {
                                                                echo $member_row['bio'];
                                                            } else {
                                                                echo 'No bio available';
                                                            }
                                                            ?>
                                                        </p>
                                                        <?php if ($member_row['status'] == "active") { ?>
                                                            <form action="./function/update.php" method="GET">
                                                                <input type="hidden" name="user_id"
                                                                    value="<?php echo $_SESSION['admin_id']; ?>">
                                                                <input type="hidden" name="member_id"
                                                                    value="<?php echo $member_row['member_id']; ?>">
                                                                <input type="hidden" name="status" value="deactivate">
                                                                <button type="submit" class="btn btn-outline-success"
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
                                                                    <button type="submit" class="btn btn-outline-danger"
                                                                        name="update_active"
                                                                        onclick="return confirm('Are you sure you want to activate the account?')">Deactivate</button>
                                                                </form>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <hr class="my-4">
                                                <ul class="list-group list-group-flush">
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-globe me-2 icon-inline">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                                                <path
                                                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                                                </path>
                                                            </svg>Website</h6>
                                                        <?php if (!empty($member_row['website'])) { ?>
                                                            <span class="text-secondary">
                                                                <a href="<?php echo $member_row['website']; ?>" target="_blank"
                                                                    class="text-secondary">
                                                                    <?php echo $member_row['website_name']; ?>
                                                                </a>
                                                            </span>
                                                        <?php } else { ?>
                                                            <span class="text-secondary">No Website Found</span>
                                                        <?php } ?>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <h6 class="mb-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-facebook me-2 icon-inline text-primary">
                                                                <path
                                                                    d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                                                </path>
                                                            </svg>
                                                            Facebook
                                                        </h6>
                                                        <?php if (!empty($member_row['facebook'])) { ?>
                                                            <span class="text-secondary">
                                                                <a href="<?php echo $member_row['facebook']; ?>" target="_blank"
                                                                    class="text-secondary">
                                                                    <?php echo $member_row['firstname'] . ' ' . $member_row['lastname']; ?>
                                                                </a>
                                                            </span>
                                                        <?php } else { ?>
                                                            <span class="text-secondary">No facebook Found</span>
                                                        <?php } ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <!-- Content for the right section -->
                                        <button class="btn btn-outline-secondary"
                                            onclick="toggleContentMode('About')">About</button>
                                        <button class="btn btn-outline-secondary"
                                            onclick="toggleContentMode('dental_chart')">Dental Chart</button>
                                        <button class="btn btn-outline-secondary"
                                            onclick="toggleContentMode('treatment_plan')">Treatment Plan</button>
                                        <br><br>
                                        <?php if (isset($_SESSION['success'])) { ?>
                                            <div class="alert alert-success">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                                    onclick="window.location.href ='./contact_client_view.php?member_id=<?php echo $member_row['member_id']; ?>'"><span
                                                        aria-hidden="true"><i class='bx bx-x-circle'></i></span></button>
                                                <?php echo $_SESSION['success']; ?>
                                            </div>
                                            <?php
                                            unset($_SESSION['success']);
                                        } ?>
                                        <!--space-->
                                        <?php if (isset($_SESSION['failed'])) { ?>
                                            <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                                    onclick="window.location.href ='./contact_client_view.php?member_id=<?php echo $member_row['member_id']; ?>'"><span
                                                        aria-hidden="true"><i class='bx bx-x-circle'></i></span></button>
                                                <?php echo $_SESSION['failed']; ?>
                                            </div>
                                            <?php
                                            unset($_SESSION['failed']);
                                        } ?>
                                        <?php if (isset($_SESSION['message'])) { ?>
                                            <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                                    onclick="window.location.href ='./contact_client_view.php?member_id=<?php echo $row['member_id']; ?>'"><span
                                                        aria-hidden="true"><i class='bx bx-x-circle'></i></span></button>
                                                <?php echo $_SESSION['message']; ?>
                                            </div>
                                            <?php
                                            unset($_SESSION['message']);
                                        } ?>
                                        <div id="contentAbout">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Full Name</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <input type="text" class="form-control"
                                                                value="<?php echo $member_row['firstname'] . ' ' . $member_row['middlename'] . ' ' . $member_row['lastname'] . ' ' . $member_row['suffixname']; ?>"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Address</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <?php
                                                            if (!empty($member_row['address'])) { ?>
                                                                <input type="text" class="form-control"
                                                                    value="<?php echo $member_row['address']; ?>" disabled>
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" value="No input address"
                                                                    disabled>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Contact Number</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <?php
                                                            if (!empty($member_row['contact_no'])) { ?>
                                                                <input type="text" class="form-control"
                                                                    value="<?php echo $member_row['contact_no']; ?>" disabled>
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control"
                                                                    value="No input Contact Number" disabled>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Age</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <?php
                                                            if (!empty($member_row['age'])) { ?>
                                                                <input type="text" class="form-control"
                                                                    value="<?php echo $member_row['age']; ?> years old"
                                                                    disabled>
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" value="No input Age"
                                                                    disabled>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Birthday</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <?php
                                                            if (!empty($member_row['birthday'])) { ?>
                                                                <input type="date" class="form-control"
                                                                    value="<?php echo $member_row['birthday']; ?>" disabled>
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control"
                                                                    value="No input birthday" disabled>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Gender</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <?php
                                                            if (!empty($member_row['gender'])) { ?>
                                                                <input type="text" class="form-control"
                                                                    value="<?php echo $member_row['gender']; ?>" disabled>
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" value="No input gender"
                                                                    disabled>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <?php if (!empty($member_row['guardianfirstname'])) { ?>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-3">
                                                                <h6 class="mb-0">Guardian Name</h6>
                                                            </div>
                                                            <div class="col-sm-9 text-secondary">
                                                                <input type="text" class="form-control"
                                                                    value="<?php echo $member_row['guardianfirstname'] . ' ' . $member_row['guardianmiddlename'] . ' ' . $member_row['guardianlastname']; ?>"
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-3">
                                                                <h6 class="mb-0">Guardian Contact Number</h6>
                                                            </div>
                                                            <div class="col-sm-9 text-secondary">
                                                                <input type="text" class="form-control"
                                                                    value="<?php echo $member_row['guardian_contact_no']; ?>"
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-3">
                                                                <h6 class="mb-0">Guardian Job</h6>
                                                            </div>
                                                            <div class="col-sm-9 text-secondary">
                                                                <input type="text" class="form-control"
                                                                    value="<?php echo $member_row['guardian_job']; ?>" disabled>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="row">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <a
                                                                href="./function/print/member_info.php?member_id=<?php echo $member_row['member_id']; ?>"><button
                                                                    type="button" class="btn btn-secondary"><i
                                                                        class='bx bx-printer'></i> Print The
                                                                    Information</button></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="d-flex align-items-center mb-3">action counts</h5>
                                                            <!-- Display action counts -->
                                                            <div class="design-top">
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
                                                                <?php foreach ($action_counts as $action => $count): ?>
                                                                    <?php if ($action !== 'Update Active' && $action !== 'Update Deactive'): ?>
                                                                        <p>
                                                                            <?php echo $action ?>
                                                                        </p>
                                                                        <!-- This is a paragraph element containing the action name -->
                                                                        <div class="progress mb-3" style="height: 5px">
                                                                            <!-- This is a div element with classes "progress" and "mb-3" from Bootstrap, representing a progress bar with some bottom margin -->
                                                                            <div class="progress-bar bg-primary" role="progressbar"
                                                                                style="width: <?php echo $count ?>%"
                                                                                aria-valuenow="<?php echo $count ?>"
                                                                                aria-valuemin="0" aria-valuemax="100">
                                                                                <!-- Inside the progress bar, there's another div with class "progress-bar" and class "bg-primary" from Bootstrap, representing the actual progress bar. It's styled with a blue color. -->
                                                                                <!-- The attributes aria-valuenow, aria-valuemin, and aria-valuemax are for accessibility purposes, indicating the current value, minimum, and maximum values respectively. -->
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br><!-- DENTAL CHART -->
                                        <div id="contentdental_chart" style="display: none;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3>DENTAL CHART</h3>
                                                    <div>
                                                        <div class="row">
                                                            <?php
                                                            // Fetch images from the database
                                                            $image_query = "SELECT * FROM `images` WHERE `member_id` = '$id'";
                                                            $image_result = mysqli_query($conn, $image_query);

                                                            // Check if images are fetched successfully
                                                            if (mysqli_num_rows($image_result) > 0) {
                                                                // If there are images, iterate through them
                                                                $count = 0;
                                                                while ($image_row = mysqli_fetch_assoc($image_result)) {
                                                                    ?>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <div class="portfolio__item">
                                                                                <div class="portfolio-item__img">
                                                                                    <a href="portfolio-item.html">
                                                                                        <img src="../../picture/treatment/<?php echo $image_row['image']; ?>"
                                                                                            class="img-responsive profile-image-portfolio"
                                                                                            alt="<?php echo $image_row['image_title']; ?>">
                                                                                        <div class="portfolio-item__mask">
                                                                                            <div
                                                                                                class="portfolio-item-mask__content">
                                                                                                <div
                                                                                                    class="portfolio-item-mask__title">
                                                                                                    <?php echo $image_row['image_id']; ?>
                                                                                                    <?php echo $image_row['image_title']; ?>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="portfolio-item-mask__summary">
                                                                                                    <?php echo $image_row['description']; ?>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- / .portfolio-item-mask__content -->
                                                                                        </div> <!-- / .portfolio-item__mask -->
                                                                                    </a>
                                                                                </div> <!-- / .portfolio-item__img -->
                                                                            </div> <!-- / .portfolio__item -->
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    $count++;
                                                                    // Add a clearfix every third image
                                                                    if ($count % 3 == 0) {
                                                                        echo '<div class="clearfix visible-xs-block visible-sm-block visible-md-block visible-lg-block"></div>';
                                                                    }
                                                                }
                                                            } else {
                                                                // If no images are found
                                                                echo '<div class="alert alert-warning">No images found!</div>';
                                                            }
                                                            ?>
                                                        </div> <!-- / .row -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br><!-- Treatment Plan -->
                                        <div id="contenttreatment_plan" style="display: none;">
                                            <h3>Treatment Plan</h3>
                                            <!--Table-->
                                            <nav>
                                                <ul class="unstyled">
                                                    <li>
                                                        <a
                                                            href="./function/print/treatment_info.php?member_id=<?php echo $member_row['member_id']; ?>"><button
                                                                type="button" class="btn btn-secondary"><i
                                                                    class='bx bx-printer'></i> Print The Treatment
                                                                Plan</button></a>
                                                    </li>
                                                </ul>
                                            </nav>
                                            <div class="card-body">
                                                <!-- PROJECT TABLE -->
                                                <table class="table table-bordered table-hover dt-responsive"
                                                    id="datatablesSimple">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Service Offer</th>
                                                            <th>Teeth Number</th>
                                                            <th>Dentist</th>
                                                            <!-- The Price is hidden in Super Admin -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Treatment Plan -->
                                                        <?php
                                                        $teeth_numbers = array(); // Initialize an empty array to store teeth numbers
                                                    
                                                        // Construct the SQL query to select the schedule for the provided member_id
                                                        $service_done_query = mysqli_query($conn, "SELECT * FROM `service_done` WHERE member_id = $id") or die(mysqli_error($conn));
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
                                                            // Store teeth numbers in the array
                                                            $teeth_numbers[] = $service_done_row['teeth_no'];
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $schedule01_row['date']; ?></td>
                                                                <td><?php echo $service01_row['service_offer']; ?></td>
                                                                <td><?php echo $service_done_row['teeth_no']; ?></td>
                                                                <td>
                                                                    <a href="#">
                                                                        <?php echo $account01_row['firstname'] . ' ' . $account01_row['lastname']; ?>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <!-- END PROJECT TABLE -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include ('./function/footer.php'); ?>
            <?php } ?>
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
                } else {
                    section.style.display = "none";
                }
            });
        }

    </script>

</body>

</html>