<?php include ('./function/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dental Office - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <link href="../../css/shop.css" rel="stylesheet" />
    <!--Online Icon Design;-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
</head>

<body class="sb-nav-fixed">
    <!--Datebase-->
    <?php include ('../../dbcon.php'); ?>
    <!--Top Navbar-->
    <?php include ('./function/navbar.php'); ?>
    <div id="layoutSidenav">
        <!--Nav Sidebar-->
        <?php include ('./function/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                            <!-- Bg -->
                            <div class="pt-20 rounded-top" style="background:
                             url(https://bootdey.com/image/480x480/00FFFF/000000) no-repeat;
                            background-size: cover;">
                            </div>
                            <div class="card rounded-bottom smooth-shadow-sm">
                                <div class="d-flex align-items-center justify-content-between
                                pt-4 pb-6 px-4">
                                    <div class="d-flex align-items-center">
                                        <!-- <div class="avatar-xxl avatar-indicators avatar-online me-2
                                        position-relative d-flex justify-content-end align-items-end mt-n10">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar8.png" class="avatar-xxl
                                            rounded-circle border border-2 " alt="Image">
                                        </div> -->
                                        <div class="lh-1">
                                            <h1 class="mt-4">Dental Office</h1>
                                            <p class="mb-0 d-block">
                                            <ol class="breadcrumb mb-4">
                                                <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                                                <li class="breadcrumb-item">My Dental</li>
                                                <li class="breadcrumb-item active">Dentist Office</li>
                                            </ol>
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="./function/add_location.php" class="btn btn-outline-primary
                                        d-none d-md-block">Add Location</a>
                                    </div>
                                </div>
                                <ul class="nav nav-lt-tab px-4" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <!--Help-->
                                            <a class="btn btn-info text-white" data-bs-toggle="collapse"
                                                data-bs-target="#pagesCollapsehow" aria-expanded="false"
                                                aria-controls="pagesCollapsehow"><i class='bx bx-info-circle'></i>
                                                How
                                                to use</a>
                                            <a class="btn btn-secondary active text-white" href="./shop.php">All
                                                location</a>
                                            <a class="btn btn-primary active text-white" href="./function/add_duty2.php">Add
                                                duty</a>
                                        </div>
                                        <!-- <a class="nav-link active" href="#"> Followers </a> -->
                                    </li>
                                </ul>
                                <br>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!--Message-->
                    <?php if (isset($_SESSION['success'])) { ?>
                        <div class="alert alert-success">
                            <button onclick="window.location.href ='./shop.php'" type="button" class="close"
                                data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i
                                        class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['success'];
                            // Unset multiple specific session variables
                            unset($_SESSION['success']); ?>
                        </div>
                    <?php } ?>
                    <!--space-->
                    <?php if (isset($_SESSION['failed'])) { ?>
                        <div class="alert alert-danger">
                            <button onclick="window.location.href ='./shop.php'" type="button" class="close"
                                data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i
                                        class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['failed'];
                            // Unset multiple specific session variables
                            unset($_SESSION['failed']); ?>
                        </div>
                    <?php } ?>
                    <!--Help information-->
                    <div id="pagesCollapsehow" class="collapse alert alert-info">
                        <h3><i class='bx bx-info-circle'></i> How To Use</h3>

                        <br>
                    </div>
                    <br>
                    <!-- location table -->
                    <div class="py-6">
                        <div class="row">
                            <div class="row justify-content-center product-grid-style">
                                <div class="row justify-content-center product-grid-style">
                                    <?php
                                    $location_query = "SELECT * FROM `location`";
                                    $location_result = mysqli_query($conn, $location_query);

                                    //while statement
                                    while ($location_row = mysqli_fetch_array($location_result)) {
                                        ?>
                                        <div class="col-11 col-sm-6 col-lg-4 col-xl-3">
                                            <div class="product-details">
                                                <!-- card -->
                                                <div class="card mb-5 rounded-3">
                                                    <div>
                                                        <?php if (!empty($location_row['picture'])) { ?>
                                                            <img src="../../picture/location/<?php echo $location_row['picture']; ?>"
                                                                alt="Image" class="img-fluid rounded-top">
                                                        <?php } else { ?>
                                                            <img src="../../picture/location/location.jpg" alt="Image"
                                                                class="img-fluid rounded-top">
                                                        <?php } ?>
                                                    </div>
                                                    <!-- avatar -->
                                                    <!-- <div class="avatar avatar-xl mt-n7 ms-4">
                                                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                                    alt="Image" class="rounded-circle border-4 border-white-color-40">
                                                            </div> -->
                                                    <!-- card body -->
                                                    <div class="card-body">
                                                        <!-- Title -->
                                                        <h4 class="mb-1">
                                                            <?php echo $location_row['location']; ?>
                                                        </h4>
                                                        <p>
                                                            <?php echo $location_row['map']; ?>
                                                        </p>
                                                        <div>
                                                            <!-- Dropdown -->
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <a href="./duty.php?location_id=
                                                                <?php echo $location_row['location_id']; ?>"><button
                                                                        class="btn btn-outline-primary" type="submit"
                                                                        name="shop_view">View</button></a>
                                                                <div class="dropdown dropstart">
                                                                    <a href="#!"
                                                                        class="btn btn-ghost btn-icon btn-sm rounded-circle"
                                                                        id="dropdownMenuOne" data-bs-toggle="dropdown"
                                                                        aria-haspopup="true" aria-expanded="false">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                            class="feather feather-more-vertical icon-xs">
                                                                            <circle cx="12" cy="12" r="1"></circle>
                                                                            <circle cx="12" cy="5" r="1"></circle>
                                                                            <circle cx="12" cy="19" r="1"></circle>
                                                                        </svg>
                                                                    </a>
                                                                    <div class="dropdown-menu"
                                                                        aria-labelledby="dropdownMenuOne">
                                                                        <!-- update -->
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="./function/edit_location.php?location_id=<?php echo $location_row['location_id']; ?>">
                                                                            Edit Location</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
</body>

</html>