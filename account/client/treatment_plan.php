<?php include ('./function/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Treatment Plan - Client</title>
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
                    <h1 class="mt-4">My Treatment Plan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item">Personal Information</li>
                        <li class="breadcrumb-item active">My Treatment Plan</li>
                    </ol>
                    <!--Help information-->
                    <div id="pagesCollapsehow" class="collapse alert alert-info">
                        <h3><i class='bx bx-info-circle'></i> How To Use</h3>
                        1. You can View the Treatment Plan using the button.
                        <br>
                        2. You can also Cancel the Treatment Plan using the button.
                        <br>
                    </div>
                    <div class="card mb-4">
                        <!--Secondary Nav-->
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <!--Help-->
                            <a class="btn btn-info text-white" data-bs-toggle="collapse"
                                data-bs-target="#pagesCollapsehow" aria-expanded="false"
                                aria-controls="pagesCollapsehow"><i class='bx bx-info-circle'></i>
                                How
                                to use</a>
                            <a class="btn btn-secondary"
                                href="./function/print/treatment_info.php?member_id=<?php echo $row['member_id']; ?>"><i
                                    class='bx bx-printer'></i> Print The
                                Treatment
                                Plan</a>
                        </div>
                    </div>
                    <!-- History of Treatment Plan -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable for List of Appointment History
                        </div>
                        <div class="card-body">
                            <!-- PROJECT TABLE -->
                            <table class="table table-bordered table-hover dt-responsive" id="datatablesSimple">
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
                                        if ($service_done_row['member_id'] == "$id") {
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
</body>

</html>